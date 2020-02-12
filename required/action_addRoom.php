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
    $user_id = $_SESSION['user_id'];
    $hub_id = $_SESSION['hub_id'];

    //END SESSION
    session_write_close();

    $stmt = $db->prepare("INSERT INTO room_info (user_id, hub_id, room_name, room_icon) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $user_id, $hub_id, $roomName, $roomIcon);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        load("../index.php");
    }
    load("../index.php?action=addroom");







?>