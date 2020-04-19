<?php
    //////////////////////////////////////////////////////////// REMOVE ACTION///////////////////////////////////////////////////
    include_once dirname(__DIR__).'/required/config.php';

    $room_id = filter_input(INPUT_POST, "roomId", FILTER_SANITIZE_NUMBER_INT);

    if($room_id == FALSE){
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

    //DELETE ROW, ENSURING THAT THE HUB_ID IS PASSED IN.
    //THIS ENSURES THE USER IS WHO THEY SAY THEY ARE
    $stmtDeleteRoom = $db->prepare("DELETE FROM room_info WHERE room_id = ? AND hub_id = ?");
    $stmtDeleteRoom->bind_param("ii", $room_id, $hub_id);
    if(!$stmtDeleteRoom->execute()){
        echo("{\"error\":\"Room deletion failed\"}");
    }else{
        echo("{\"success\":\"Room successfully deleted\"}");
    }
    $stmtDeleteRoom->close();
    exit(0);

?>