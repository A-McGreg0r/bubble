<?php
    //////////////////////////////////////////////////////////// MOVE DEVICE ACTION///////////////////////////////////////////////////
    include_once dirname(__DIR__).'/required/config.php';

    //GRAB INPUT
    $room_id = filter_input(INPUT_POST, "room_id", FILTER_SANITIZE_NUMBER_INT);
    $device_id = filter_input(INPUT_POST, "device_id", FILTER_SANITIZE_NUMBER_INT);

    //BEGIN SESSION
    session_start();
    $hub_id = $_SESSION['hub_id'];
    //END SESSION
    session_write_close();

    //ENSURE THAT ROOM IS OWNED BY THE OWNER OF THIS HUB
    $stmt = $db->prepare("SELECT * FROM room_info WHERE room_id = ? AND hub_id = ?");
    $stmt->bind_param("ii", $room_id, $hub_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if($result->num_rows != 1){
            echo("{\"error\":\"Unknown room\"}");
            $stmt->close();
            exit();
        }
    }else{
        echo("{\"error\":\"Database connection error, try again\"}");
        $stmt->close();
        exit();
    }
    $stmt->close();

    //ENSURE THAT DEVICE IS OWNED BY THE OWNER OF THIS HUB
    $stmt = $db->prepare("SELECT * FROM device_info WHERE device_id = ? AND hub_id = ?");
    $stmt->bind_param("ii", $device_id, $hub_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if($result->num_rows != 1){
            echo("{\"error\":\"Unknown device\"}");
            $stmt->close();
            exit();
        }
    }else{
        echo("{\"error\":\"Database connection error, try again\"}");
        $stmt->close();
        exit();
    }
    $stmt->close();

    //UPDATE DEVICE ROW, CHANGE ROOM ID
    $stmt = $db->prepare("UPDATE device_info SET room_id = ? WHERE hub_id = ? AND device_id = ?");
    $stmt->bind_param("iii", $room_id, $hub_id, $device_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            echo("{\"success\":\"Device moved\"}");
            $stmt->close();
            exit();
        }
    }else{
        echo("{\"error\":\"Database connection error, try again\"}");
        $stmt->close();
        exit();
    }









?>