<?php
$link = mysqli_connect('localhost', 'bubble', 'bubble', 'bubbleDB');

if (!$link) {

    die('Could not connect to MySQL: ' . mysqli_error($link));

}
