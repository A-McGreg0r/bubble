<?php
////////////////////////////////////// DEVICE CONTROL SCRIPT/////////////////////////////////////////////
include_once 'config.php';

//GRAB TYPE FROM POST
$type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);

//GRAB RELEVANT FLAGS
$state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_NUMBER_INT);
$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

//CHECK THAT REQUIRED INPUTS ARE VALID
if($type == FALSE || $id == FALSE){
    echo("{\"error\":\"Invalid params, try again!\"}");
    exit();
}


//GET HUB ID FROM SESSION
session_start();
if(isset($_SESSION['hub_id'])){
    $hub_id = $_SESSION['hub_id'];
}else{
    echo("{\"error\":\"User is not logged in\"}");
    session_write_close();
    exit();
}
session_write_close();

//SWITCH ACCORDING TO DEVICE CHANGE TYPE
switch($type){
    //TOGGLE A DEVICE, EITHER 4 OR 0 = ON OR OFF
    case "toggledevice":  
        //GRAB EXISTING DEVICE STATE
        if($state == 4) {
            $state = 0;
        } else if ($state == 0) {
            $state = 4;
        }
        //---------------------SIMULATION--------------------
        //SIMULATE CHANCE OF DEVICE BREAKING
        $chance_of_break = rand(1,1000);
        if($chance_of_break <= 1) {
            $state = 0 - 1;
        }
        //---------------------\SIMULATION--------------------

        //PREPARE UPDATE STATEMENT
        /**
         * HUB_ID IS INCLUDED IN THIS STATEMENT. THIS IS TO ENSURE THAT ONLY THE LOGGED IN USER CAN TOGGLE A CERTAIN DEVICE, 
         * AS HUB_ID IS STORED IN THE SERVER SIDE SESSION BANK
         * THEREFOR, THIS ENSURES ONLY THE RIGHT USERS CAN CHANGE DEVICES
         */
        $stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ? AND hub_id = ?");

        //BIND AND EXECUTE QUERY
        $stmt->bind_param("iii", $state, $id, $hub_id);
        if($stmt->execute()){
            echo("{\"status\":$state}");
        }else{
            echo("{\"error\":\"Update failed\"}");
        }
        $stmt->close();

    break;
    //SCALE DEVICE, FOR DEVICES THAT HAVE MORE THAN ON OR OFF POWER SETTINGS
    case "scaledevice":       
        //ENSURE STATE DATA IS WITHIN RANGE
        if($state < 0 || $state > 4){
            echo("{\"error\":\"Invalid scale!\"}");
            exit(0);
        }

        //---------------------SIMULATION--------------------
        //SIMULATE CHANCE OF DEVICE BREAKING
        $chance_of_break = rand(1,1000);
        if($chance_of_break <= 1) {
            $state = -1;
        }
        //---------------------\SIMULATION--------------------

        //PREPARE UPDATE STATEMENT
        /**
         * HUB_ID IS INCLUDED IN THIS STATEMENT. THIS IS TO ENSURE THAT ONLY THE LOGGED IN USER CAN TOGGLE A CERTAIN DEVICE, 
         * AS HUB_ID IS STORED IN THE SERVER SIDE SESSION BANK
         * THEREFOR, THIS ENSURES ONLY THE RIGHT USERS CAN CHANGE DEVICES
         */
        $stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ? AND hub_id = ?");
        
        //BIND AND EXECUTE QUERY
        $stmt->bind_param("iii", $state, $id, $hub_id);
        if($stmt->execute()){
            echo("{\"status\":$state}");
        }else{
            echo("{\"error\":\"Update failed\"}");
        }
        $stmt->close();

    break;
    case "room":
        //GET CURRENT STATUS OF ROOM ACCORDING TO EXISTING DEVICES
        $stmt = $db->prepare("SELECT device_status FROM device_info WHERE hub_id = ? AND room_id = ?");
        $stmt->bind_param("ii", $hub_id, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $old_room_status = 0;
        //IF ANY DEVICE IS ON IN THE ROOM, THE ROOM IS ON. OTHERWISE, THE ROOM IS OFF
        while($row = $result->fetch_assoc()) {
            if($row['device_status'] > 0){
                $old_room_status = 4;
                break;
            }
        }
        $stmt->close();


        //TOGGLE ROOM STATUS
        if($old_room_status == 0){
            $new_room_status = 4;
        }else{
            $new_room_status = 0;
        }

        //PREPARE UPDATE STATEMENT
        /**
         * HUB_ID IS INCLUDED IN THIS STATEMENT. THIS IS TO ENSURE THAT ONLY THE LOGGED IN USER CAN TOGGLE A CERTAIN DEVICE, 
         * AS HUB_ID IS STORED IN THE SERVER SIDE SESSION BANK
         * THEREFOR, THIS ENSURES ONLY THE RIGHT USERS CAN CHANGE DEVICES
         * 
         * ALSO ENSURE THAT ANY BROKEN DEVICES STAY BROKEN WHEN TOGGLING ROOMS
         */
        $stmt2 = $db->prepare("UPDATE device_info SET device_status = IF(device_status!=-1,?,-1) WHERE hub_id = ? AND room_id = ?");
       
        //BIND AND EXECUTE QUERY
        $stmt2->bind_param("iii", $new_room_status, $hub_id, $id);
        if($stmt2->execute()){
            echo("{\"status\":$new_room_status}");
        }else{
            echo("{\"error\":\"Update failed\"}");
        }
        $stmt2->close();

    break;
}

?>
