<?php
    //////////////////////////////////////////////////////////// ADD ROOM ACTION///////////////////////////////////////////////////
    include_once dirname(__DIR__).'/required/config.php';

    $roomName = filter_input(INPUT_POST, "roomName", FILTER_SANITIZE_STRING);
    $icon = filter_input(INPUT_POST, "icon", FILTER_SANITIZE_NUMBER_INT);

    if($roomName == FALSE || $icon == FALSE){
        echo("{\"error\":\"Invalid request\"}");
        exit(0);
    }

    //BEGIN SESSION
    session_start();
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
    } else {
        echo("{\"error\":\"User is not logged in\"}");
        session_write_close();
        exit(0);
    }
    //END SESSION
    session_write_close();

    //CHECK THAT THE ROOM NAME HASNT ALREADY BEEN CHOSEN
    $stmt2 = $db->prepare("SELECT * FROM room_info WHERE hub_id = ? AND room_name = ?");
    $stmt2->bind_param("is", $hub_id, $roomName);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if($result2->num_rows === 0){
        //PREPARE QUERY TO BE INSERTED INTO ROOM TABLE
        $stmt2->close();
        $stmt = $db->prepare("INSERT INTO room_info (hub_id, room_name, room_icon) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $hub_id, $roomName, $icon);
        if ($stmt->execute()) {
            $stmt->close(0);
            echo("{\"success\":\"Room successfully added\"}");
            exit();
        }
        $stmt->close();
        echo("{\"error\":\"Room creation failed\"}");
        exit(0);
    }
    $stmt2->close();
    echo("{\"error\":\"Room name already chosen, please chose another\"}");

?>