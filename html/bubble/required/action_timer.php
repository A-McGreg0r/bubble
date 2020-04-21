<?php

include_once 'config.php';
global $db;

//Find info sent over ajax
$device_id = 0;
if(isset($_POST['device_id'])) $device_id = $_POST['device_id'];
$hour = 0;
if(isset($_POST['hour'])) $hour = $_POST['hour'];
$minute = 0;
if(isset($_POST['minute'])) $minute = $_POST['minute'];

$time = ($hour * 60) + $minute;
$time_on = 0;

//Loop through devices
$stmt2 = $db->prepare("SELECT * FROM device_info WHERE device_id = ?");
$stmt2->bind_param("i", $device_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
if($result2 == 1) {
    $all2 = $result2->fetch_all(MYSQLI_ASSOC);
    foreach($all2 as $row2){
        //Find how long device has been turned on for
        $time_on = $row2['minutes_on'];
    }
}

//Add timer to current time device has been on
$time += $time_on;

//Update device info with timer details
$stmt = $db->prepare("UPDATE device_info SET turn_off = ? WHERE device_id = ?");
$stmt->bind_param("ii", $time, $device_id);
$stmt->execute();
$stmt->close();

?>