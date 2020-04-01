<?php
include_once 'config.php';

global $db;

$status = 0;
if(isset($_POST['stat'])) $status = $_POST['stat'];
$hub_id = 0;
if(isset($_POST['hubID'])) $hub_id = $_POST['hubID'];
$device_id = 0;
if(isset($_POST['id'])) $room_id = $_POST['id'];
$device_name = '';
if(isset($_POST['rooom_name'])) $room_name = $_POST['dev_name'];

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
    }
}

?>