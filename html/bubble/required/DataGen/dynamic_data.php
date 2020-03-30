<?php
include_once '../config.php';
global $db;

$year = date("Y");
$month = date("m");
$day = date("d");

$day_of_week = date("D");

$hour = date("H");

$status = "";
$energy_used = 0;

if ($hour == "9" || $hour == "10" || $hour == "11" || $hour == "12" || $hour == "13" || $hour == "14" || $hour == "15" || $hour == "16" || $hour == "17") {
    if ($day_of_week == "Sat" || $day_of_week == "Sun"){
        $status = "busy";
    } else {
        $status = "idle";
    }
} else if ($hour == "7" || $hour == "8" || $hour == "18" || $hour == "19" || $hour == "20" || $hour == "21" || $hour == "22") {
    $status = "busy";
} else {
    $status = "idle";
}

if ($status == "busy") {
    $energy_used = rand(125,250);
} else if ($status == "idle"){
    $energy_used = rand(0,250/4);
}

$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach($all as $row){

        $hub_id = $row['hub_id'];

        $stmt2 = $db->prepare("SELECT * FROM daily_data");
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows === 0){
            $stmt3 = $db->prepare("INSERT INTO daily_data (hub_id) VALUES (?)");
            $stmt3->bind_param("i", $hub_id);
            $stmt3->execute();
        }
        
        if ($hour == "00") {
            $stmt4 = $db->prepare("UPDATE daily_data SET hour_24 = ? WHERE hub_id = ?");
            $stmt4->bind_param("ii", $energy_used, $hub_id);
            $stmt4->execute();
        } else {
            $stmt5 = $db->prepare("UPDATE daily_data SET hour_$hour = ? WHERE hub_id = ?");
            $stmt5->bind_param("ii", $energy_used, $hub_id);
            $stmt5->execute();
        }

        echo $hub_id;
        echo "\n";

        $stmt2->close();
        $stmt3->close();
    }
}
$stmt->close();

?>