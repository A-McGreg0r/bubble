<?php
    //////////////////////////////////////////////////////////// ADD ROOM ACTION///////////////////////////////////////////////////
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once dirname(__DIR__).'/required/config.php';

    $roomName = filter_input(INPUT_POST, "roomName", FILTER_SANITIZE_STRING);
    $icon = filter_input(INPUT_POST, "icon", FILTER_SANITIZE_NUMBER_INT);

    if($roomName == FALSE || $icon == FALSE){
        load("../index.php?action=addroom&error=0");
    }

    //BEGIN SESSION
    session_start();
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
    } else {
        load("../index.php?action=addroom&error=1");
    }
    //END SESSION
    session_write_close();

    $stmt2 = $db->prepare("SELECT * FROM room_info WHERE hub_id = ? AND room_name = ?");
    $stmt2->bind_param("is", $hub_id, $roomName);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if($result2->num_rows === 0){
        $stmt = $db->prepare("INSERT INTO room_info (hub_id, room_name, room_icon) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $hub_id, $roomName, $roomIcon);
        if ($stmt->execute()) {
            $stmt2->close();
            $stmt->close();
            load("../index.php?action=addroom&success=1");
        }
        $stmt->close();
    }
    $stmt2->close();
    load("../index.php?action=addroom&error=2");

?>