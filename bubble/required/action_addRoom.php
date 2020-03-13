<?php
    //////////////////////////////////////////////////////////// ADD ROOM ACTION///////////////////////////////////////////////////
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once dirname(__DIR__).'/required/config.php';

    $roomName = $_POST['roomName'];
    $roomIcon = $_POST['icon'];

    //BEGIN SESSION
    session_start();
    $hub_id = $_SESSION['hub_id'];

    //END SESSION
    session_write_close();
    $stmt = $db->prepare("INSERT INTO room_info (hub_id, room_name, room_icon) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $hub_id, $roomName, $roomIcon);
    if ($stmt->execute()) {
        load("../index.php");
    }
    load("../index.php?action=addroom");







?>