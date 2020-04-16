<?php
include_once '../config.php';
global $db;

$year = date("Y");
$month = date("m");
$day = date("d");
$leap = date("L");

$stmt8 = $db->prepare("SELECT * FROM device_info");
$stmt8->execute();
$result8 = $stmt8->get_result();
$num_rows8 = $result8->num_rows;
if ($num_rows8 >= 1) {
    $all8 = $result8->fetch_all(MYSQLI_ASSOC);
    foreach($all8 as $row8){
        $id = $row8['device_id'];
        $zero = 0;
        if($month == 12){
            $day_data = 0;
            $stmt9 = $db->prepare("UPDATE device_info SET day_data = ?, month_data = ? WHERE device_id = ?");
            $stmt9->bind_param("iii", $zero, $day_data, $id);
            $stmt9->execute();
        }

        $stmt10 = $db->prepare("UPDATE device_info SET day_data = ? WHERE device_id = ?");
        $stmt10->bind_param("ii", $zero, $id);
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

        $monthly_energy = 0;

        $stmt4 = $db->prepare("SELECT * FROM daily_data WHERE hub_id = ?");
        $stmt4->bind_param("i", $hub_id);
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        $num_rows = $result4->num_rows;
        if ($num_rows >= 1) {
            $all4 = $result4->fetch_all(MYSQLI_ASSOC);
            foreach($all4 as $row4){
                $monthly_energy = $monthly_energy + $row4['energy_usage'];
            }
                
            $stmt5 = $db->prepare("INSERT INTO monthly_data (hub_id, entry_year, entry_month, energy_usage) VALUES (?, ?, ?, ?)");
            $stmt5->bind_param("iiii", $hub_id, $year, $month, $monthly_energy);
            $stmt5->execute();

            $stmt6 = $db->prepare("SELECT * FROM monthly_data WHERE hub_id = ?");
            $stmt6->bind_param("i", $hub_id);
            $stmt6->execute();
            $result6 = $stmt6->get_result();
            $num_row6 = $result6->num_rows;
            if ($num_row6 >= 12) {
                $all6 = $result6->fetch_all(MYSQLI_ASSOC);
                foreach($all6 as $row6){
                    $num_row6 = $num_row6 - 1;
                    if ($num_row6 >= 12) {
                        $stmt7 = $db->prepare("DELETE FROM monthly_data WHERE entry_id = ?");
                        $stmt7->bind_param("i", $row6['entry_id']);
                        $stmt7->execute();
                    }
                }
            }
        }


        $stmt11 = $db->prepare("SELECT * FROM daily_gen WHERE hub_id = ?");
        $stmt11->bind_param("i", $hub_id);
        $stmt11->execute();
        $result11 = $stmt11->get_result();
        $num_rows11 = $result11->num_rows;
        if ($num_rows11 >= 1) {
            $all11 = $result11->fetch_all(MYSQLI_ASSOC);
            foreach($all11 as $row11){
                $monthly_gen = $monthly_gen + $row11['energy_gen'];
            }
                
            $stmt12 = $db->prepare("INSERT INTO monthly_gen (hub_id, entry_year, entry_month, energy_gen) VALUES (?, ?, ?, ?)");
            $stmt12->bind_param("iiid", $hub_id, $year, $month, $monthly_gen);
            $stmt12->execute();

            $stmt13 = $db->prepare("SELECT * FROM monthly_gen WHERE hub_id = ?");
            $stmt13->bind_param("i", $hub_id);
            $stmt13->execute();
            $result13 = $stmt13->get_result();
            $num_row13 = $result13->num_rows;
            if ($num_row13 >= 12) {
                $all13 = $result13->fetch_all(MYSQLI_ASSOC);
                foreach($all13 as $row13){
                    $num_row13 = $num_row13 - 1;
                    if ($num_row13 >= 12) {
                        $stmt14 = $db->prepare("DELETE FROM monthly_gen WHERE entry_id = ?");
                        $stmt14->bind_param("i", $row13['entry_id']);
                        $stmt14->execute();
                    }
                }
            }
        }
    }
}
$stmt->close();