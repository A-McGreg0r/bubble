<?php
include_once '../config.php';
global $db;

$year = date("Y");
$month = date("m");
$day = date("d");
$leap = date("L");

//Loop through all devices
$stmt8 = $db->prepare("SELECT * FROM device_info");
$stmt8->execute();
$result8 = $stmt8->get_result();
$num_rows8 = $result8->num_rows;
if ($num_rows8 >= 1) {
    $all8 = $result8->fetch_all(MYSQLI_ASSOC);
    foreach($all8 as $row8){
        $id = $row8['device_id'];
        $zero = 0;
        
        $day_data = $row8['day_data'] + $hour_data;

        //Delete the data stored in the month_data column of the device at the end of the month
        if($month == 4 || $month == 6 || $month == 9 || $month == 11){
            if($day == 30){
                $day_data = 0;
                $stmt9 = $db->prepare("UPDATE device_info SET hour_data = ?, day_data = ? WHERE device_id = ?");
                $stmt9->bind_param("iii", $zero, $day_data, $id);
                $stmt9->execute();
            }
        } else if ($month == 2 && $leap == 1){
            if($day == 29){
                $day_data = 0;
                $stmt9 = $db->prepare("UPDATE device_info SET hour_data = ?, day_data = ? WHERE device_id = ?");
                $stmt9->bind_param("iii", $zero, $day_data, $id);
                $stmt9->execute();
            }
        } else if ($month == 2){
            if($day == 28){
                $day_data = 0;
                $stmt9 = $$stmt9 = $db->prepare("UPDATE device_info SET hour_data = ?, day_data = ? WHERE device_id = ?");
                $stmt9->bind_param("iii", $zero, $day_data, $id);
                $stmt9->execute();
            }
        } else {
            if($day == 31){
                $day_data = 0;
                $stmt9 = $db->prepare("UPDATE device_info SET hour_data = ?, day_data = ? WHERE device_id = ?");
                $stmt9->bind_param("iii", $zero, $day_data, $id);
                $stmt9->execute();
            }
        }

        //Reset the hour_data column for the individual devices
        $stmt10 = $db->prepare("UPDATE device_info SET hour_data = ? WHERE device_id = ?");
        $stmt10->bind_param("ii", $zero, $id);
        $stmt10->execute();
    }
}

$auto_delete = 0;

//Find the end of the current month for deletion of data
if($month == 4 || $month == 6 || $month == 9 || $month == 11){
    $auto_delete = 30;
} else if ($month == 2 && $leap == 1){
    $auto_delete = 29;
} else if ($month == 2){
    $auto_delete = 28;
} else {
    $auto_delete = 31;
}

//Loop through hubs
$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach($all as $row){

        $hub_id = $row['hub_id'];

        $daily_energy = 0;

        //Delete data from hourly gen if the number of rows per hub exceeds 24
        $stmt11 = $db->prepare("SELECT * FROM hourly_gen WHERE hub_id = ?");
        $stmt11->bind_param("i", $hub_id);
        $stmt11->execute();
        $result11 = $stmt11->get_result();
        $num_rows11 = $result11->num_rows;
        if ($num_rows11 >= 1) {
            $all11 = $result11->fetch_all(MYSQLI_ASSOC);
            foreach($all11 as $row11){
                //Add up all values of hourly_gen
                $daily_gen = $daily_gen + $row11['energy_gen'];
                if($num_rows11 > 24){
                    $num_rows11 - 1;
                    $stmt17 = $db->prepare("DELETE FROM hourly_gen WHERE entry_id = ?");
                    $stmt17->bind_param("i", $row11['entry_id']);
                    $stmt17->execute();
                }
            }
                
            //Insert hourly gen data into daily gen table
            $stmt12 = $db->prepare("INSERT INTO daily_gen (hub_id, entry_month, entry_day, energy_gen) VALUES (?, ?, ?, ?)");
            $stmt12->bind_param("iiid", $hub_id, $month, $day, $daily_gen);
            $stmt12->execute();

            //Delete from daily gen so that there is only the number of rows needed per month
            $stmt13 = $db->prepare("SELECT * FROM daily_gen WHERE hub_id = ?");
            $stmt13->bind_param("i", $hub_id);
            $stmt13->execute();
            $result13 = $stmt13->get_result();
            $num_row13 = $result13->num_rows;
            if ($num_row13 >= $auto_delete) {
                $all13 = $result13->fetch_all(MYSQLI_ASSOC);
                foreach($all13 as $row13){
                    $num_row13 = $num_row13 - 1;
                    if ($num_row13 >= $auto_delete) {
                        $stmt14 = $db->prepare("DELETE FROM daily_gen WHERE entry_id = ?");
                        $stmt14->bind_param("i", $row13['entry_id']);
                        $stmt14->execute();
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