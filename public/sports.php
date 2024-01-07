<?php

include '../init.php';

$helper = new SportDao($config);

// Application logic
if ($_REQUEST['action'] == 'delete') {
    if ($helper->delete($_REQUEST['id'])) {
        header("Location: ?");
        die();
    } else {
        $errors[] = $helper->getErrorMessage();
    }
} elseif ($_REQUEST['submit'] == 'create') {
    if ($helper->insert($_POST)) {
        header("Location: ?");
        die();
    } else {
        $errors[] = $helper->getErrorMessage();
    }
} elseif ($_REQUEST['submit'] == 'training') {
    $recurringDao = new RecurringTrainingDao($config);
    if ($recurringDao->insert($_POST)) {
        header("Location: ?");
        die();
    } else {
        $errors[] = $recurringDao->getErrorMessage();
    }
} elseif ($_REQUEST['submit'] == 'update') {
    if ($helper->update($_POST['id'], $_POST)) {
        header("Location: ?");
        die();
    } else {
        $errors[] = $helper->getErrorMessage();
    }
}

// Site/page boilerplate
$site = new site($errors);
$site->addHeader("../includes/navbar.php");
init_site($site);

$page = new page();
$site->setPage($page);


// Start rendering the content
ob_start();

if (empty($_REQUEST['action'])) {
    ?>
    <button class="btn btn-success float-right" onclick="window.location = '?action=create'">New Sport</button>
    <?php
}
?>
<h1>Manage Sports</h1>

<?php

if ($_REQUEST['action'] == 'create') {
    include_once('../components/newSportForm.php');
} elseif ($_REQUEST['action'] == 'update') {
    $data = $helper->select($_REQUEST['id']);
    include_once('../components/editSportForm.php');
} elseif ($_REQUEST['action'] == 'training') {
    $recurringDao = new RecurringTrainingDao($config);
    $data = $helper->select($_REQUEST['id']);

    $existingTraining = $recurringDao->selectForSport($_REQUEST['id']);
    include_once('../components/editRecurringTraining.php');
} else {
    ?>
    <table class="table table-hover mt-5">
        <thead>
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($helper->selectAll() as $i) {
            echo "<tr>";
            echo "<td><a href='?action=update&id=" . $i['training_sport'] . "'>" . $i['sport_name'] . "</a></td>";
            echo "<td><a class='btn btn-outline-info mr-2' href='?action=training&id=" . $i['sport_id'] . "'>📆</a><a class='btn btn-outline-danger' href='?action=delete&id=" . $i['sport_id'] . "'>🗑️</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
}


// End rendering the content
$content = ob_get_clean();
$page->setContent($content);

$site->render();
?>
