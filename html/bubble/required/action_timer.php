<?php

include_once 'config.php';

//BEGIN SESSION
session_start();
$user_id = $_SESSION['user_id'];
$hub_id = $_SESSION['hub_id'];

//END SESSION
session_write_close();

//GATHER INFO

$device_id = filter_input(INPUT_POST, "device_id", FILTER_SANITIZE_NUMBER_INT);
$hour = filter_input(INPUT_POST, "hour", FILTER_SANITIZE_NUMBER_INT);
$minute = filter_input(INPUT_POST, "minute", FILTER_SANITIZE_NUMBER_INT);

if($device_id == FALSE || $hour == FALSE || $minute == FALSE){
    echo("{\"error\":\"Invalid request \"}");
    exit(0);
}

$time = ($hour * 60) + $minute;
$time_on = 0;

//Loop through devices
$stmt2 = $db->prepare("SELECT * FROM device_info WHERE device_id = ? AND hub_id = ?");
$stmt2->bind_param("ii", $device_id, $hub_id);
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
$stmt = $db->prepare("UPDATE device_info SET turn_off = ? WHERE device_id = ? AND hub_id = ?");
$stmt->bind_param("iii", $time, $device_id, $hub_id);
$stmt->execute();
$stmt->close();

?>