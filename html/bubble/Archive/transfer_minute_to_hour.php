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
        $stmt10->bind_param("ii", $zero, $id);
        $stmt10->execute();
    }
}
$stmt->close();

?>