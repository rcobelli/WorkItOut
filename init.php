<?php

if ($_COOKIE['debug'] == 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
} else {
    error_reporting(0);
}

if ($_SERVER['SERVER_NAME'] == "dev.rybel-llc.com" && $_COOKIE['centerdesk'] != "loggedIn") {
    die();
}

include_once("stdlib.php");
require_once("vendor/autoload.php");
include_once("classes/site.php");
include_once("classes/page.php");
include_once("classes/Helper.php");
include_once("classes/Dao.php");
include_once("classes/RaceDao.php");
include_once("classes/SportDao.php");
include_once("classes/RaceTrainingDao.php");
include_once("classes/RecurringTrainingDao.php");
include_once("classes/ScheduleHelper.php");

$ini = parse_ini_file("config.ini", true)["rdb"];

try {
    $pdo = new PDO(
        'mysql:host=' . $ini['db_host'] . ';dbname=' . $ini['db_name'] . ';charset=utf8mb4',
        $ini['db_username'],
        $ini['db_password'],
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::ATTR_PERSISTENT => false
        )
    );
} catch (Exception $e) {
    exit($e);
}

$config = array(
    'dbo' => $pdo
);

$errors = array();

// Start session if not already created
if (session_status() == PHP_SESSION_NONE) {
    session_name("lb");
    session_start();
}

date_default_timezone_set('America/New_York');
