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

        $stmt2 = $db->prepare("SELECT * FROM daily_data");
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $daily_energy = 0;

        $stmt4 = $db->prepare("SELECT * FROM hourly_data WHERE hub_id = ?");
        $stmt4->bind_param("i", $hub_id);
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        $num_rows = $result4->num_rows;
        if ($num_rows >= 1) {
            $all4 = $result4->fetch_all(MYSQLI_ASSOC);
            foreach($all4 as $row4){
                $daily_energy = $daily_energy + $row4['energy_usage'];
                if ($num_rows >= 25){
                    $num_rows = $num_rows - 1;
                    $stmt6 = $db->prepare("DELETE FROM hourly_data WHERE entry_id = ?");
                    $stmt6->bind_param("i", $row4['entry_id']);
                    $stmt6->execute();
                }
            }
                
            $stmt5 = $db->prepare("INSERT INTO daily_data (hub_id, entry_month, entry_day, energy_usage) VALUES (?, ?, ?, ?)");
            $stmt5->bind_param("iiii", $hub_id, $month, $day, $daily_energy);
            $stmt5->execute();
        }

        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
        $stmt5->close();
    }
}
$stmt->close();