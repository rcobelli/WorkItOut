<?php

// Support DEBUG cookie
if ($_COOKIE['debug'] == 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
} else {
    error_reporting(0);
}

require_once("vendor/autoload.php");
include_once("classes/Dao.php");
include_once("classes/RaceDao.php");
include_once("classes/SportDao.php");
include_once("classes/RaceTrainingDao.php");
include_once("classes/RecurringTrainingDao.php");
include_once("classes/ScheduleHelper.php");

$ini = parse_ini_file("config.ini", true)["wio"];

date_default_timezone_set('America/New_York');

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
    'dbo' => $pdo,
    'appName' => 'Work It Out'
);

// Setup SAML
$baseUrl = "https://dev.rybel-llc.com:449/";
$keycloakUrl = "https://dev.rybel-llc.com:8443/realms/Rybel";

$samlHelper = new Rybel\backbone\SamlAuthHelper($baseUrl, 
                            $keycloakUrl, 
                            file_get_contents("../certs/idp.cert"), 
                            file_get_contents('../certs/public.crt'), 
                            file_get_contents('../certs/private.pem'),
                            $_COOKIE['debug'] == 'true');
