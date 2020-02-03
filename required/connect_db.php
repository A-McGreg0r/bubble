<?php
$db = mysqli_connect('localhost', 'u372228036_bubble', 'bubble', 'u372228036_bubbleDB');

if (!$db) {
    die('Could not connect to MySQL: ' . mysqli_error($db));
}
?>