<?php
////////////////////////////////////// DEVICE CONTROL SCRIPT/////////////////////////////////////////////
include_once 'config.php';
global $db;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$device_id = 0;
if(isset($_POST['device_id'])) $device_id = $_POST['device_id'];
$hour = 0;
if(isset($_POST['hour'])) $hour = $_POST['hour'];
$minute = 0;
if(isset($_POST['minute'])) $minute = $_POST['minute'];

$time = ($hour * 60) + $minute;
$time_on = 0;

$stmt2 = $db->prepare("SELECT * FROM device_info WHERE device_id = ?");
$stmt2->bind_param("i", $device_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
if($result2 == 1) {
    $all2 = $result2->fetch_all(MYSQLI_ASSOC);
    foreach($all2 as $row2){
        $time_on = $row2['minutes_on'];
    }
}

$time += $time_on;

$stmt = $db->prepare("UPDATE device_info SET turn_off = ? WHERE device_id = ?");
$stmt->bind_param("ii", $time, $device_id);
$stmt->execute();

?>