<?php
    //////////////////////////////////////////////////////////// REMOVE DEVICE ACTION///////////////////////////////////////////////////
    include_once dirname(__DIR__).'/required/config.php';

    $device_id = filter_input(INPUT_POST, "deviceId", FILTER_SANITIZE_NUMBER_INT);

    if($device_id == FALSE){
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
    $stmtDeleteDevice = $db->prepare("DELETE FROM device_info WHERE device_id = ? AND hub_id = ?");
    $stmtDeleteDevice->bind_param("ii", $device_id, $hub_id);
    if(!$stmtDeleteDevice->execute()){
        echo("{\"error\":\"Device deletion failed\"}");
    }else{
        echo("{\"success\":\"Device successfully deleted\"}");
    }
    $stmtDeleteDevice->close();
    exit(0);

?>