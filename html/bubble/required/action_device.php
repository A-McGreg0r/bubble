<?php
////////////////////////////////////// DEVICE CONTROL SCRIPT/////////////////////////////////////////////
include_once 'config.php';

//GRAB TYPE FROM POST
$type = "toggledevice";
if(isset($_POST['type'])) $status = $_POST['type'];

//GRAB RELEVANT FLAGS
$type = '';
if(isset($_POST['type'])) $type = $_POST['type'];
$scale = 0;
if(isset($_POST['scale'])) $scale = $_POST['scale'];
$state = 0;
if(isset($_POST['state'])) $state = $_POST['state'];
$hub_id = 0;
if(isset($_POST['hub_id'])) $hub_id = $_POST['hub_id'];
$id = 0;
if(isset($_POST['id'])) $id = $_POST['id'];

switch($type){
    case "toggledevice":  
        if($state == 4) {
            $state = 0;
        } else if ($state == 0) {
            $state = 4;
        }

        $chance_of_break = rand(1,1000);
        if($chance_of_break <= 1) {
            $state = 0 - 1;
        }
        
        $stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ?");

        $stmt->bind_param("ii", $state, $id);
        $stmt->execute();
        $stmt->close();

        echo("{\"status\":$state}");
    break;
    case "scaledevice":       

        if($scale < 0 || $scale > 4){
            echo("{\"error\":\"Invalid scale!\"}");
            exit(0);
        }

        $chance_of_break = rand(1,1000);
        if($chance_of_break <= 1) {
            $scale = 0 - 1;
        }

        $stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ?");

        $stmt->bind_param("ii", $scale, $id);
        $stmt->execute();
        $stmt->close();

        $stmt2 = $db->prepare("SELECT device_status FROM device_info WHERE device_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $row = $result->fetch_assoc();
        $new_status = $row['device_status'];

        echo("{\"status\":$new_status}");
    break;
    case "room":
        //GET CURRENT STATUS OF ROOM
        $stmt = $db->prepare("SELECT device_status FROM device_info WHERE hub_id = ? AND room_id = ?");
        $stmt->bind_param("ii", $hub_id, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $old_room_status = 0;
        while($row = $result->fetch_assoc()) {
            if($row['device_status'] > 0){
                $old_room_status = 4;
                break;
            }
        }
        $stmt->close();

        if($old_room_status == 0){
            $new_room_status = 4;
        }else{
            $new_room_status = 0;
        }
        $stmt2 = $db->prepare("UPDATE device_info SET device_status = IF(device_status!=-1,?,-1) WHERE hub_id = ? AND room_id = ?");
        $stmt2->bind_param("iii", $new_room_status, $hub_id, $id);
        $stmt2->execute();
        $stmt2->close();
        echo("{\"status\":$new_room_status}");

    break;
}

?>
