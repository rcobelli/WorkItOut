<?php

include '../init.php';

$samlHelper->processSamlInput();

if (!$samlHelper->isLoggedIn()) {
    header("Location: ?sso");
    die();
}

use Detection\MobileDetect;

$config['type'] = Rybel\backbone\LogStream::console;

$helper = new ScheduleHelper($config);

// Boilerplate
$page = new Rybel\backbone\page();
$page->addHeader("../includes/header.php");
$page->addFooter("../includes/footer.php");
$page->addHeader("../includes/navbar.php");

// Start rendering the content
ob_start();

if (!isset($_GET['month']) || !isset($_GET['year'])) {
    $_GET['day'] = date("j");
    $_GET['month'] = date("m");
    $_GET['year'] = date("Y");
} else {
    $_GET['day'] = 1;
}


$detect = new MobileDetect();

if ($detect->isMobile()) {
    $workouts = $helper->fetchSchedule(date('Y-m-d'));

    echo "<h5>" . date('D, F j Y') . "</h5>";

    if (empty($workouts)) {
        echo '<i>Rest Day</i>';
    } else {
        echo "<ul>";
        foreach ($workouts as $w) {
            echo "<li>" . $w['sport_name'] . ": " . $w['title'] . "</li>";
            if (!empty($w['description'])) {
                echo "<ul><li>" . $w['description'] . "</li></ul>";
            }
            if (!empty($w['race_id'])) {
                $raceDao = new RaceDao($config);
                $data = $raceDao->select($w['race_id']);
                
                $diff = round((strtotime($data['race_date']) - time()) / (60 * 60 * 24));


                echo "<ul><li><i>" . $data['race_name'] . " is in " . $diff . " days</i></li></ul>";
            }
        }
        echo "</ul>";
    }
} else {
    $day_num        = $_GET['day'];
    $month_num      = $_GET['month'];
    $year           = $_GET['year'];
    
    
    if ($month_num == 12) {
        $next_year = $year + 1;
        $next_month = 1;
        $prev_year = $year;
        $prev_month = 11;
    } elseif ($month_num == 1) {
        $next_year = $year;
        $next_month = 2;
        $prev_year = $year - 1;
        $prev_month = 12;
    } else {
        $next_year = $year;
        $next_month = $month_num + 1;
        $prev_year = $year;
        $prev_month = $month_num - 1;
    }
    
    
    $date_today     = getdate(mktime(0, 0, 0, $month_num, 1, $year));
    $month_name     = $date_today["month"];
    $first_week_day = $date_today["wday"];
    
    $cont  = true;
    $today = 27;
    while (($today <= 32) && ($cont)) {
        $date_today = getdate(mktime(0, 0, 0, $month_num, $today, $year));
        if ($date_today["mon"] != $month_num) {
            $lastday = $today - 1;
            $cont    = false;
        }
        $today++;
    }
    echo "<p style='float: right;'><a href='?month=$prev_month&year=$prev_year'>Previous Month</a> | <a href='?month=$next_month&year=$next_year'>Next Month</a>";
    echo "<h1>$month_name $year</h1>";
    echo "<table cellspacing=0 cellpadding=5 frame='all' rules='all' class='cal'>";
    echo "<tr><th>Su</th><th>M</th><th>Tu</th><th>W</th><th>Th</th><th>F</th><th>Sa</th></tr>";
    
    $day       = 1;
    $wday      = $first_week_day;
    $firstweek = true;
    
    while ($day <= $lastday) {
        if ($firstweek) {
            echo "<tr align=left>";
            for ($i = 1; $i <= $first_week_day; $i++) {
                echo "<td> </td>";
            }
            $firstweek = false;
        }
        if ($wday == 0) {
            echo "<tr align=left>";
        }
    
        $workouts = $helper->fetchSchedule($year . '-' . $month_num . '-' . $day);
    
        echo "<td";
    
        if ($year . '-' . $month_num . '-' . $day == date('Y-m-j')) {
            echo " style='border: 3px solid black;'";
        }
    
        echo ">";
    
        echo "<h5>$day</h5>";
    
        if (empty($workouts)) {
            echo '<i>Rest Day</i>';
        } else {
            echo "<ul>";
            foreach ($workouts as $w) {
                echo "<li title='" . $w['description'] . "'>" . $w['sport_name'] . ": " . $w['title'] . "</li>";
            }
            echo "</ul>";
        }
    
        echo "</td>";
        if ($wday == 6) {
            echo "</tr>";
        }
    
        $wday++;
        $wday = $wday % 7;
        $day++;
    }
    
    while ($wday <= 6 && $wday > 0) { // Fill in the last row
        echo "<td>&nbsp;</td>";
        $wday++;
    }
    echo "</tr></table>";
}

$content = ob_get_clean();
$page->render($content);
