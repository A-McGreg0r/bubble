<?php
include_once '../config.php';
global $db;

$year = date("Y");
$month = date("m");
$day = date("d");

$hour = date("H") + 1;

$stmt8 = $db->prepare("SELECT * FROM device_info");
$stmt8->execute();
$result8 = $stmt8->get_result();
$num_rows8 = $result8->num_rows;
if ($num_rows8 >= 1) {
    $all8 = $result8->fetch_all(MYSQLI_ASSOC);
    foreach($all8 as $row8){
        $id = $row8['device_id'];
        $zero = 0;
        
        $hour_data = $row8['hour_data'] + $minute_data;

        if($hour == 24) {
            $hour_data = 0;
            $stmt9 = $db->prepare("UPDATE device_info SET minute_data = ?, hour_data = ? WHERE device_id = ?");
            $stmt9->bind_param("iii", $zero, $hour_data, $id);
            $stmt9->execute();
        }

        $stmt10 = $db->prepare("UPDATE device_info SET minute_data = ? WHERE device_id = ?");
        $stmt10->bind_param("iii", $zero, $id);
        $stmt10->execute();
    }
}

$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach($all as $row){

        $hub_id = $row['hub_id'];

        $stmt2 = $db->prepare("SELECT * FROM hourly_data");
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $hourly_energy = 0;

        $stmt4 = $db->prepare("SELECT * FROM minute_data WHERE hub_id = ?");
        $stmt4->bind_param("i", $hub_id);
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        $num_rows = $result4->num_rows;
        if ($num_rows >= 1) {
            $all4 = $result4->fetch_all(MYSQLI_ASSOC);
            foreach($all4 as $row4){
                $hourly_energy = $hourly_energy + $row4['energy_usage'];
            }

            $hourly_energy = intval($hourly_energy);
                
            $stmt5 = $db->prepare("INSERT INTO hourly_data (hub_id, entry_day, entry_hour, energy_usage) VALUES (?, ?, ?, ?)");
            $stmt5->bind_param("iiii", $hub_id, $day, $hour, $hourly_energy);
            $stmt5->execute();

            $stmt6 = $db->prepare("SELECT * FROM hourly_data WHERE hub_id = ?");
            $stmt6->bind_param("i", $hub_id);
            $stmt6->execute();
            $result6 = $stmt6->get_result();
            $num_row6 = $result6->num_rows;
            if ($num_row6 >= 24) {
                $all6 = $result6->fetch_all(MYSQLI_ASSOC);
                foreach($all6 as $row6){
                    $num_row6 = $num_row6 - 1;
                    if ($num_row6 >= 24) {
                        $stmt7 = $db->prepare("DELETE FROM hourly_data WHERE entry_id = ?");
                        $stmt7->bind_param("i", $row6['entry_id']);
                        $stmt7->execute();
                    }
                }
            }
        }

        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
        $stmt5->close();
    }
}
$stmt->close();

?>