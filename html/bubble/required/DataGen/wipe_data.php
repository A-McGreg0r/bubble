<?php
include_once '../config.php';
global $db;

$stmt8 = $db->prepare("SELECT * FROM device_info");
$stmt8->execute();
$result8 = $stmt8->get_result();
$num_rows8 = $result8->num_rows;
if ($num_rows8 >= 1) {
    $all8 = $result8->fetch_all(MYSQLI_ASSOC);
    foreach($all8 as $row8){
        $id = $row8['device_id'];
        $zero = 0;

        $stmt9 = $db->prepare("UPDATE device_info SET minute_data = ?, hour_data = ?, day_data = ?, month_data = ? WHERE device_id = ?");
        $stmt9->bind_param("iiiii", $zero, $zero, $zero, $zero, $id);
        $stmt9->execute();
    }
}
?>