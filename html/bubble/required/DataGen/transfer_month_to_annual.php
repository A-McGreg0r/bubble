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

        $stmt2 = $db->prepare("SELECT * FROM annual_data");
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows === 0){
            $stmt3 = $db->prepare("INSERT INTO annual_data (hub_id) VALUES (?)");
            $stmt3->bind_param("i", $hub_id);
            $stmt3->execute();
        }

        $stmt4 = $db->prepare("SELECT * FROM monthly_data");
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        extract($result4->fetch_assoc());

        $monthly_energy = $day_01 + $day_02 + $day_03 + $day_04 + $day_05 + $day_06 + $day_07 + $day_08 + $day_09 + $day_10 + $day_11 + $day_12 + $day_13 + $day_14 + $day_15 + $day_16 + $day_17 + $day_18 + $day_19 + $day_20 + $day_21 + $day_22 + $day_23 + $day_24 + $day_25 + $day_26 + $day_27 + $day_28 + $day_29 + $day_30 + $day_31;
    
        $stmt5 = $db->prepare("UPDATE annual_data SET month_$month = ? WHERE hub_id = ?");
        $stmt5->bind_param("ii", $monthly_energy, $hub_id);
        $stmt5->execute();

        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
    }
}
$stmt->close();