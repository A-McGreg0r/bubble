<?php
include_once '../config.php';
global $db;

$year = date("Y");
$month = date("m");
$day = date("d");

$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach($all as $row){

        $hub_id = $row['hub_id'];

        $stmt2 = $db->prepare("SELECT * FROM monthly_data");
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows === 0){
            $stmt3 = $db->prepare("INSERT INTO monthly_data (hub_id) VALUES (?)");
            $stmt3->bind_param("i", $hub_id);
            $stmt3->execute();
        }

        $stmt4 = $db->prepare("SELECT * FROM daily_data");
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        extract($result4->fetch_assoc());

        $daily_energy = $hour_01 + $hour_02 + $hour_03 + $hour_04 + $hour_05 + $hour_06 + $hour_07 + $hour_08 + $hour_09 + $hour_10 + $hour_11 + $hour_12 + $hour_13 + $hour_14 + $hour_15 + $hour_16 + $hour_17 + $hour_18 + $hour_19 + $hour_20 + $hour_21 + $hour_22 + $hour_23 + $hour_24;
    
        $stmt5 = $db->prepare("UPDATE monthly_data SET day_$day = ? WHERE hub_id = ?");
        $stmt5->bind_param("ii", $daily_energy, $hub_id);
        $stmt5->execute();

        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
        $stmt5->close();
    }
}
$stmt->close();