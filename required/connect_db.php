<?php
$db = mysqli_connect('localhost', 'bubble', 'bubble', 'bubble-db');

if (!$db) {
    die('Could not connect to MySQL: ' . mysqli_error($db));
}
?>