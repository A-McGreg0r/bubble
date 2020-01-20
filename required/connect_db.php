<?php
$link = mysqli_connect('localhost', 'pi', 'Bringerdeath@22', 'HNDSOFTS2A29');
if (!$link) {
    die('Could not connect to MySQL: ' . mysqli_error());
}
