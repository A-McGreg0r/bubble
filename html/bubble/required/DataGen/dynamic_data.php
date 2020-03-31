<?php
include_once '../config.php';
global $db;

$year = date("Y");
$month = date("m");
$day = date("d");

$day_of_week = date("D");

$hour = date("H") + 1;

$status = "";
$season = "";

if ($hour == 9 || $hour == 10 || $hour == 11 || $hour == 12 || $hour == 13 || $hour == 14 || $hour == 15 || $hour == 16 ) {
    if ($day_of_week == "Sat" || $day_of_week == "Sun"){
        $status = "busy";
    } else {
        $status = "idle";
    }
} else if ($hour == 7 || $hour == 8 || $hour == 17 || $hour == 18 || $hour == 19 || $hour == 20 || $hour == 21 || $hour == 22) {
    $status = "busy";
} else {
    $status = "idle";
}


$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach($all as $row){
        $energy_used = 0;
        $max_consumption = 0;
        $variable_consumption = 0;
        $temp = 0;

        $stmt7 = $db->prepare("SELECT * FROM hub_users WHERE hub_id = ?");
        $stmt7->bind_param("i", $row['hub_id']);
        $stmt7->execute();
        $result7 = $stmt7->get_result();
        if ($result7->num_rows >= 1) {
            extract($result7->fetch_assoc());
            $stmt8 = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
            $stmt8->bind_param("i", $user_id);
            $stmt8->execute();
            $result8 = $stmt8->get_result();
            if ($result8->num_rows === 1) {
                extract($result8->fetch_assoc());
                $ip = $ip_address;
                $latlong = explode(",", file_get_contents('https://ipapi.co/' . $ip . '/latlong/'));
                $weather = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat=' . $latlong[0] . '&lon=' . $latlong[1] . '&appid=f35e0bdca477a802831ce6202240dc8d');
                $current_weather = json_decode($weather,true);
                $temp = $current_weather['main']['temp'];
            }
        }

        $temp = $temp - 273;

        $stmt5 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
        $stmt5->bind_param("i", $row['hub_id']);
        $stmt5->execute();
        $result5 = $stmt5->get_result();
        if ($result5->num_rows >= 1) {
            $all5 = $result5->fetch_all(MYSQLI_ASSOC);
            foreach($all5 as $row5){
                $stmt4 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                $stmt4->bind_param("i", $row5['device_type']);
                $stmt4->execute();
                $result4 = $stmt4->get_result();
                if ($result4->num_rows >= 1) {
                    $all4 = $result4->fetch_all(MYSQLI_ASSOC);
                    foreach($all4 as $row4){
                        $max_consumption = $max_consumption + $row4['energy_usage'];
                        if($ip != ''){
                            if($row4['type_id'] == 2){
                                if ($temp <= 17){
                                    $variable_consumption = $variable_consumption + $row4['energy_usage'];
                                }
                            } else if ($row4['type_id'] == 3){
                                if ($temp >= 26){
                                    $variable_consumption = $variable_consumption + $row4['energy_usage'];
                                }
                            } else {
                                if($status == 'idle'){
                                    $chance = rand(0,100);
                                    if($chance >= 80){
                                        $variable_consumption = $variable_consumption + $row4['energy_usage'];
                                    }
                                } else {
                                    $chance = rand(0,100);
                                    if($chance >= 20){
                                        $variable_consumption = $variable_consumption + $row4['energy_usage'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($status == "busy") {
            if ($ip != ''){
                $energy_used = $variable_consumption + rand(0,$max_consumption/10);
                $energy_used = $energy_used + 50; //to account for the hub being on
            } else {
                $multiplier = rand(20,80)/100;
                $idle_energy = rand(0,$max_consumption/10);
                $energy_used = $max_consumption * $multiplier;
                $energy_used = $energy_used + $idle_energy;
                $energy_used = $energy_used + 50; //to account for the hub being on
            }
        } else if ($status == "idle"){
            $energy_used = rand(0,$max_consumption/10);
            $energy_used = $energy_used + 50; //to account for the hub being on
        }

        $hub_id = $row['hub_id'];

        $stmt2 = $db->prepare("SELECT * FROM hourly_data");
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $num_rows = $result2->num_rows;
        if ($num_rows >= 24) {
            $all2 = $result2->fetch_all(MYSQLI_ASSOC);
            foreach($all2 as $row2){
                if ($num_rows >= 24){
                    $num_rows = $num_rows - 1;
                    $stmt6 = $db->prepare("DELETE FROM hourly_data WHERE entry_id = ?");
                    $stmt6->bind_param("i", $row2['entry_id']);
                    $stmt6->execute();
                }
            }
        }
        

        $stmt3 = $db->prepare("INSERT INTO hourly_data (hub_id, entry_day, entry_hour, energy_usage) VALUES (?, ?, ?, ?)");
        $stmt3->bind_param("iiii", $hub_id, $day, $hour, $energy_used);
        $stmt3->execute();

        $stmt2->close();
        $stmt3->close();
    }
}
$stmt->close();

?>