<?php
//GRAB SERVER CONFIG, THIS FILE IS NOT PUSHED TO GIT
//THE REASON FOR THIS IS SO THAT BOTH THE DEV SERVER AND THE LIVE SERVER CAN RUN OF DIFFERENT DATABASES
include 'server_config.php';

//ESTABLISH DATABASE CONNECTION
$db = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);

if (!$db) {
    die('Could not connect to MySQL: ' . mysqli_error($db));
}
?>