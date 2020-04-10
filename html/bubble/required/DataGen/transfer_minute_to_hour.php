<?php
include_once '../config.php';
global $db;

$year = date("Y");
$month = date("m");
$day = date("d");

$hour = date("H") + 1;

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