<?php
////////////////////////////////////// DEVICE CONTROL SCRIPT/////////////////////////////////////////////
include_once 'config.php';

//GRAB TYPE FROM POST
$type = "device";
if(isset($_POST['type'])) $status = $_POST['type'];

//GRAB RELEVANT FLAGS
$status = 0;
if(isset($_POST['stat'])) $status = $_POST['stat'];
$hub_id = 0;
if(isset($_POST['hubID'])) $hub_id = $_POST['hubID'];
$device_id = 0;
if(isset($_POST['id'])) $device_id = $_POST['id'];

switch($type){
    case "device":
        $set_device = 0;
        
        if ($status == 0){
            $set_device = 1;
        }
        
        $stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ?");
        $stmt->bind_param("ii", $set_device, $device_id);
        $stmt->execute();
        $stmt->close();
        echo("{status:$set_device}");
    break;
    case "room":
        $set_device = 0;
        
        if ($status == 0){
            $set_device = 1;
        }
        
        $stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE hub_id = ? AND room_id = ?");
        $stmt->bind_param("iii", $set_device, $hub_id, $room_id);
        $stmt->execute();
        $stmt->close();
    break;
}

?>
