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

//Determine how many days are in the month to autodelete from daily table
if($month == 4 || $month == 6 || $month == 9 || $month == 11){
    $auto_delete = 30;
} else if ($month == 2 && $leap == 1){
    $auto_delete = 29;
} else if ($month == 2){
    $auto_delete = 28;
} else {
    $auto_delete = 31;
}

//Loop through all hubs
$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach($all as $row){
        $energy_used = 0;

        //Loop through all devices in the hub
        $stmt5 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
        $stmt5->bind_param("i", $row['hub_id']);
        $stmt5->execute();
        $result5 = $stmt5->get_result();
        if ($result5->num_rows >= 1) {
            $all5 = $result5->fetch_all(MYSQLI_ASSOC);
            foreach($all5 as $row5){

                //Find if it's on, how long it's been on, and if there's a timer set
                $energy_setting = $row5['device_status'];
                $minutes_on = $row5['minutes_on'];
                $turn_off = $row5['turn_off'];
                $id = $row5['device_id'];

                //Loop through device types to find the energy usage of device
                $stmt4 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                $stmt4->bind_param("i", $row5['device_type']);
                $stmt4->execute();
                $result4 = $stmt4->get_result();
                if ($result4->num_rows >= 1) {
                    $all4 = $result4->fetch_all(MYSQLI_ASSOC);
                    foreach($all4 as $row4){

                        //if the energy setting is one then there's only a 25% output
                        if($energy_setting == 1){
                            //Run every minute so hourly output is divided into minutes
                            $energy_used = $energy_used + ($row4['energy_usage'] / 4);
                            $nrg = $row5['minute_data'] + (($row4['energy_usage'] / 4) / 60);
                            $nrg_hour = $row5['hour_data'] + (($row4['energy_usage'] / 4) / 60);
                            $nrg_day = $row5['day_data'] + (($row4['energy_usage'] / 4) / 60);
                            $nrg_month = $row5['month_data'] + (($row4['energy_usage'] / 4) / 60);

                            //Device info is updated to reflect new data
                            $stmt10 = $db->prepare("UPDATE device_info SET minute_data = ?, hour_data = ?, day_data = ?, month_data = ? WHERE device_id = ?");
                            $stmt10->bind_param("ddddi", $nrg, $nrg_hour, $nrg_day, $nrg_month, $id);
                            $stmt10->execute();
                        } else if($energy_setting == 2){
                            //if the energy setting is 2 then there's only a 50% output
                            $energy_used = $energy_used + ($row4['energy_usage'] / 2);
                            $nrg = $row5['minute_data'] + (($row4['energy_usage'] / 2) / 60);
                            $nrg_hour = $row5['hour_data'] + (($row4['energy_usage'] / 2) / 60);
                            $nrg_day = $row5['day_data'] + (($row4['energy_usage'] / 2) / 60);
                            $nrg_month = $row5['month_data'] + (($row4['energy_usage'] / 2) / 60);

                            $stmt10 = $db->prepare("UPDATE device_info SET minute_data = ?, hour_data = ?, day_data = ?, month_data = ? WHERE device_id = ?");
                            $stmt10->bind_param("ddddi", $nrg, $nrg_hour, $nrg_day, $nrg_month, $id);
                            $stmt10->execute();
                        } else if($energy_setting == 3){
                            //if the energy setting is 3 then there's only a 75% output
                            $energy_used = $energy_used + ($row4['energy_usage'] / 4 * 3);
                            $nrg = $row5['minute_data'] + ((($row4['energy_usage'] / 4) * 3) / 60);
                            $nrg_hour = $row5['hour_data'] + ((($row4['energy_usage'] / 4) * 3) / 60);
                            $nrg_day = $row5['day_data'] + ((($row4['energy_usage'] / 4) * 3) / 60);
                            $nrg_month = $row5['month_data'] + ((($row4['energy_usage'] / 4) * 3) / 60);

                            $stmt10 = $db->prepare("UPDATE device_info SET minute_data = ?, hour_data = ?, day_data = ?, month_data = ? WHERE device_id = ?");
                            $stmt10->bind_param("ddddi", $nrg, $nrg_hour, $nrg_day, $nrg_month, $id);
                            $stmt10->execute();
                        } else if($energy_setting == 4){
                            //if the energy setting is 4 then there's only a 100% output
                            $energy_used = $energy_used + $row4['energy_usage'];
                            $nrg = $row5['minute_data'] + ($row4['energy_usage'] / 60);
                            $nrg_hour = $row5['hour_data'] + ($row4['energy_usage'] / 60);
                            $nrg_day = $row5['day_data'] + ($row4['energy_usage'] / 60);
                            $nrg_month = $row5['month_data'] + ($row4['energy_usage'] / 60);
                            
                            $stmt10 = $db->prepare("UPDATE device_info SET minute_data = ?, hour_data = ?, day_data = ?, month_data = ? WHERE device_id = ?");
                            $stmt10->bind_param("ddddi", $nrg, $nrg_hour, $nrg_day, $nrg_month, $id);
                            $stmt10->execute();
                        }
                    }
                }

                $zero = 0;
                $turn_off_on_minute = $minutes_on + 1;
                
                //if the device is on and it matches the timer time, turn device off
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
                } else if ($energy_setting == 0){
                    //If the device is off reset timer and minutes_on
                    $stmt9 = $db->prepare("UPDATE device_info SET minutes_on = ?, turn_off = ? WHERE device_id = ?");
                    $stmt9->bind_param('iii', $zero, $zero, $id);
                    $stmt9->execute();
                }
            }
        }

        $hub_id = $row['hub_id'];

        //Delete from minute data so that a hub only ever has an hour's worth of data each
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

        //Insert the minute's energy usage into the minute data table
        $stmt3 = $db->prepare("INSERT INTO minute_data (hub_id, entry_hour, entry_minute, energy_usage) VALUES (?, ?, ?, ?)");
        $stmt3->bind_param("iiid", $hub_id, $hour, $minute, $energy_used);
        $stmt3->execute();

        //Update hourly data every minute with the new data, insert new statement if new hour and delete hours so there's only ever 24 per hub
        $stmt11 = $db->prepare("SELECT * FROM hourly_data WHERE hub_id = ? AND entry_day = ? AND entry_hour = ?");
        $stmt11->bind_param("iii", $hub_id, $day, $hour);
        $stmt11->execute();
        $result11 = $stmt11->get_result();
        if($result11->num_rows == 0){
            //Create new if row doesn't already exist
            $stmt12 = $db->prepare("INSERT INTO hourly_data (hub_id, entry_day, entry_hour, energy_usage, entry_month) VALUES (?, ?, ?, ?, ?)");
            $stmt12->bind_param("iiidi", $hub_id, $day, $hour, $energy_used, $month);
            $stmt12->execute();

            //Delete rows if the call exceeds 24 rows
            $stmt17 = $db->prepare("SELECT * FROM hourly_data WHERE hub_id = ?");
            $stmt17->bind_param("i", $hub_id);
            $stmt17->execute();
            $result17 = $stmt17->get_result();
            $num_rows17 = $result17->num_rows;
            if($num_rows17 > 24){
                $all17 = $result17->fetch_all(MYSQLI_ASSOC);
                foreach($all17 as $row17){
                    if($num_rows17 > 24){
                        $num_rows17 = $num_rows17 - 1;
                        $stmt18 = $db->prepare("DELETE FROM hourly_data WHERE entry_id = ?");
                        $stmt18->bind_param("i", $row17['entry_id']);
                        $stmt18->execute();
                    }
                }
            }
        } else {
            $all11 = $result11->fetch_all(MYSQLI_ASSOC);
            foreach($all11 as $row11){
                $energy_used_day = $energy_used + $row11['energy_usage'];
                $stmt12 = $db->prepare("UPDATE hourly_data SET energy_usage = ? WHERE hub_id = ? AND entry_day = ? AND entry_hour = ? AND entry_month = ?");
                $stmt12->bind_param("diiii", $energy_used_day, $hub_id, $day, $hour, $month);
                $stmt12->execute();
            }
        }

        //Update daily data every minute with the new data, insert new statement if new day and delete hours so there's only ever a month's worth per hub
        $stmt13 = $db->prepare("SELECT * FROM daily_data WHERE hub_id = ? AND entry_month = ? AND entry_day = ?");
        $stmt13->bind_param("iii", $hub_id, $month, $day);
        $stmt13->execute();
        $result13 = $stmt13->get_result();
        if($result13->num_rows == 0){
            //Create new if row doesn't already exist
            $stmt14 = $db->prepare("INSERT INTO daily_data (hub_id, entry_month, entry_day, energy_usage) VALUES (?, ?, ?, ?)");
            $stmt14->bind_param("iiid", $hub_id, $month, $day, $energy_used);
            $stmt14->execute();

            //Delete so there's only a month's worth of data retained
            $stmt19 = $db->prepare("SELECT * FROM daily_data WHERE hub_id = ?");
            $stmt19->bind_param("i", $hub_id);
            $stmt19->execute();
            $result19 = $stmt19->get_result();
            $num_rows19 = $result19->num_rows;
            if($num_rows19 > $auto_delete){
                $all19 = $result19->fetch_all(MYSQLI_ASSOC);
                foreach($all19 as $row19){
                    if($num_rows19 > $auto_delete){
                        $num_rows19 = $num_rows19 - 1;
                        $stmt20 = $db->prepare("DELETE FROM daily_data WHERE entry_id = ?");
                        $stmt20->bind_param("i", $row19['entry_id']);
                        $stmt20->execute();
                    }
                }
            }
        } else {
            $all13 = $result13->fetch_all(MYSQLI_ASSOC);
            foreach($all13 as $row13){
                //Update to add in the additonal minute's data
                $energy_used_month = $energy_used + $row13['energy_usage'];
                $stmt14 = $db->prepare("UPDATE daily_data SET energy_usage = ? WHERE hub_id = ? AND entry_month = ? AND entry_day = ?");
                $stmt14->bind_param("diii", $energy_used_month, $hub_id, $month, $day);
                $stmt14->execute();
            }
        }

        //Update monthly data every minute with the new data, insert new statement if new month and delete months so there's only ever 12 per hub
        $stmt15 = $db->prepare("SELECT * FROM monthly_data WHERE hub_id = ? AND entry_year = ? AND entry_month = ?");
        $stmt15->bind_param("iii", $hub_id, $year, $month);
        $stmt15->execute();
        $result15 = $stmt15->get_result();
        if($result15->num_rows == 0){
            //Create new if row doesn't already exist
            $stmt16 = $db->prepare("INSERT INTO monthly_data (hub_id, entry_year, entry_month, energy_usage) VALUES (?, ?, ?, ?)");
            $stmt16->bind_param("iiid", $hub_id, $year, $month, $energy_used);
            $stmt16->execute();

            //Delete any over the number of 12
            $stmt21 = $db->prepare("SELECT * FROM monthly_data WHERE hub_id = ?");
            $stmt21->bind_param("i", $hub_id);
            $stmt21->execute();
            $result21 = $stmt21->get_result();
            $num_rows21 = $result21->num_rows;
            if($num_rows21 > 12){
                $all21 = $result21->fetch_all(MYSQLI_ASSOC);
                foreach($all21 as $row21){
                    if($num_rows21 > 12){
                        $num_rows21 = $num_rows21 - 1;
                        $stmt22 = $db->prepare("DELETE FROM monthly_data WHERE entry_id = ?");
                        $stmt22->bind_param("i", $row21['entry_id']);
                        $stmt22->execute();
                    }
                }
            }
        } else {
            $all15 = $result15->fetch_all(MYSQLI_ASSOC);
            foreach($all15 as $row15){
                //Update to add in the additonal minute's data
                $energy_used_year = $energy_used + $row15['energy_usage'];
                $stmt16 = $db->prepare("UPDATE monthly_data SET energy_usage = ? WHERE hub_id = ? AND entry_year = ? AND entry_month = ?");
                $stmt16->bind_param("diii", $energy_used_year, $hub_id, $year, $month);
                $stmt16->execute();
            }
        }

        $stmt2->close();
        $stmt3->close();
    }
}
$stmt->close();

?>
