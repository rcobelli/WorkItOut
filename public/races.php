<?php

include '../init.php';

$samlHelper->processSamlInput();

if (!$samlHelper->isLoggedIn()) {
    header("Location: index.php");
    die();
}

$config['type'] = Rybel\backbone\LogStream::console;

// Boilerplate
$page = new Rybel\backbone\page();
$page->addHeader("../includes/header.php");
$page->addFooter("../includes/footer.php");
$page->addHeader("../includes/navbar.php");

$helper = new RaceDao($config);
$sportDao = new SportDao($config);

// Application logic
if ($_REQUEST['action'] == 'delete') {
    if ($helper->delete($_REQUEST['id'])) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
} elseif ($_REQUEST['submit'] == 'create') {
    if ($helper->insert($_POST)) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
} elseif ($_REQUEST['submit'] == 'training') {
    $raceDao = new RaceTrainingDao($config);
    if (!$raceDao->insert($_POST)) {
        $page->addError($raceDao->getErrorMessage());
    }
} elseif ($_REQUEST['submit'] == 'update') {
    if ($helper->update($_POST['id'], $_POST)) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
}


// Start rendering the content
ob_start();

if (empty($_REQUEST['action'])) {
    ?>
    <button class="btn btn-success float-right" onclick="window.location = '?action=create'">New Event</button>
    <?php
}
?>
<h1>Manage Event</h1>

<?php

if ($_REQUEST['action'] == 'create') {
    include_once('../components/newRaceForm.php');
} elseif ($_REQUEST['action'] == 'update') {
    $data = $helper->select($_REQUEST['id']);
    include_once('../components/editRaceForm.php');
} elseif ($_REQUEST['action'] == 'training') {
    $raceDao = new RaceTrainingDao($config);
    $data = $helper->select($_REQUEST['id']);

    $existingTraining = $raceDao->selectForRace($_REQUEST['id']);
    include_once('../components/editRaceTraining.php');
} else {
    ?>
    <table class="table table-hover mt-5">
        <thead>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Sport</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($helper->selectAll() as $i) {
            echo "<tr>";
            echo "<td><a href='?action=update&id=" . $i['race_id'] . "'>" . $i['race_name'] . "</a></td>";
            echo "<td><a  href='?action=update&id=" . $i['race_id'] . "'>" . date('m/d/y', strtotime($i['race_date'])) . "</a></td>";
            echo "<td><a  href='?action=update&id=" . $i['race_id'] . "'>" . $i['sport_name'] . "</a></td>";
            echo "<td><a class='btn btn-outline-info mr-2' href='?action=training&id=" . $i['race_id'] . "'>📆</a><a class='btn btn-outline-danger' href='?action=delete&id=" . $i['race_id'] . "'>🗑️</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
}

$content = ob_get_clean();
$page->render($content);
