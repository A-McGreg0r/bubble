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

        $month_end = 0;
        if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
            $month_end = 30;
        } else if ($month == 2 && $leap == 0) {
            $month_end = 28;
        } else if ($month == 2 && $leap == 1) {
            $month_end = 29;
        } else {
            $month_end = 31;
        }

        $stmt2 = $db->prepare("SELECT * FROM daily_data");
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $num_rows = $result2->num_rows;
        if ($num_rows >= 1) {
            $all2 = $result2->fetch_all(MYSQLI_ASSOC);
            foreach($all2 as $row2){
                if ($num_rows >= $month_end){
                    $num_rows = $num_rows - 1;
                    $stmt6 = $db->prepare("DELETE FROM daily_data WHERE entry_id = ?");
                    $stmt6->bind_param("i", $row2['entry_id']);
                    $stmt6->execute();
                }
            }
        }

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