<?php
include 'server_config.php';
$db = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);

if (!$db) {
    die('Could not connect to MySQL: ' . mysqli_error($db));
}
?>