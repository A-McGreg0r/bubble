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
        $on_or_off = 'off';
        
        if ($status == 0){
            $set_device = 1;
            $on_or_off = 'on';
        }
        
        $stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ?");
        $stmt->bind_param("ii", $set_device, $device_id);
        $stmt->execute();
        $stmt->close();
    break;
    case "room":
        $set_device = 0;
        $on_or_off = 'off';
        
        if ($status == 0){
            $set_device = 1;
            $on_or_off = 'on';
        }
        
        $stmt = $db->prepare("SELECT * FROM device_info WHERE hub_id = ? AND room_id = ?");
        $stmt->bind_param("ii", $hub_id, $room_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            $all = $result->fetch_all(MYSQLI_ASSOC);
            foreach($all as $row){
                $device_id = $row['device_id'];
                $stmt2 = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ?");
                $stmt2->bind_param("ii", $set_device, $device_id);
                $stmt2->execute();
                $stmt2->close();
            }
        }
        $stmt->close();


    break;
}

echo '<script language="javascript">';
echo 'alert("message successfully sent")';
echo '</script>';


?>
