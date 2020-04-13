<?php
include_once '../config.php';
global $db;

$year = date("Y");
$month = date("m");
$day = date("d");

$day_of_week = date("D");

$hour = date("H") + 1;
$minute = date("i");

$status = "";

$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach($all as $row){
        $energy_used = 0;

        $stmt5 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
        $stmt5->bind_param("i", $row['hub_id']);
        $stmt5->execute();
        $result5 = $stmt5->get_result();
        if ($result5->num_rows >= 1) {
            $all5 = $result5->fetch_all(MYSQLI_ASSOC);
            foreach($all5 as $row5){
                $energy_setting = $row5['device_status'];
                $minutes_on = $row5['minutes_on'];
                $turn_off = $row5['turn_off'];
                $id = $row5['device_id'];

                $stmt4 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                $stmt4->bind_param("i", $row5['device_type']);
                $stmt4->execute();
                $result4 = $stmt4->get_result();
                if ($result4->num_rows >= 1) {
                    $all4 = $result4->fetch_all(MYSQLI_ASSOC);
                    foreach($all4 as $row4){
                        if($energy_setting == 1){
                            $energy_used = $energy_used + ($row4['energy_usage'] / 4);
                        } else if($energy_setting == 2){
                            $energy_used = $energy_used + ($row4['energy_usage'] / 2);
                            $stmt11->execute();
                        } else if($energy_setting == 3){
                            $energy_used = $energy_used + ($row4['energy_usage'] / 4 * 3);
                            $stmt12->execute();
                        } else if($energy_setting == 4){
                            $energy_used = $energy_used + $row4['energy_usage'];
                        }
                    }
                }

                $zero = 0;
                $turn_off_on_minute = $minutes_on + 1;
                
                if($energy_setting >= 1){
                    if($turn_off >= 1){
                        if ($turn_off == $turn_off_on_minute){
                            $stmt8 = $db->prepare("UPDATE device_info SET device_status = ?, minutes_on = ?, turn_off = ? WHERE device_id = ?");
                            $stmt8->bind_param('iiii', $zero, $zero, $zero, $id);
                            $stmt8->execute();

                            $energy_setting = 0;
                        }
                    }

                    $minutes_on = $minutes_on + 1;
                    $stmt7 = $db->prepare("UPDATE device_info SET minutes_on = ? WHERE device_id = ?");
                    $stmt7->bind_param('ii', $minutes_on, $id);
                    $stmt7->execute();
                } else if ($energy_setting == 0 && $turn_off > 0){
                    $stmt9 = $db->prepare("UPDATE device_info SET minutes_on = ?, turn_off = ? WHERE device_id = ?");
                    $stmt9->bind_param('iii', $zero, $zero, $id);
                    $stmt9->execute();
                }
            }
        }

        $hub_id = $row['hub_id'];

        $stmt2 = $db->prepare("SELECT * FROM minute_data");
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $num_rows = $result2->num_rows;
        if ($num_rows >= 60) {
            $all2 = $result2->fetch_all(MYSQLI_ASSOC);
            foreach($all2 as $row2){
                if ($num_rows >= 60){
                    $num_rows = $num_rows - 1;
                    $stmt6 = $db->prepare("DELETE FROM minute_data WHERE entry_id = ?");
                    $stmt6->bind_param("i", $row2['entry_id']);
                    $stmt6->execute();
                }
            }
        }
        
        $energy_used = $energy_used + 50; // to account for the hub energy consumption
        $energy_used = $energy_used / 60; // run once a minute

        $stmt3 = $db->prepare("INSERT INTO minute_data (hub_id, entry_hour, entry_minute, energy_usage) VALUES (?, ?, ?, ?)");
        $stmt3->bind_param("iiid", $hub_id, $hour, $minute, $energy_used);
        $stmt3->execute();

        $stmt2->close();
        $stmt3->close();
    }
}
$stmt->close();

?>