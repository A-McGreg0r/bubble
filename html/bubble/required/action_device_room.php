<?php
////////////////////////////////////// DEVICE CONTROL SCRIPT/////////////////////////////////////////////
include_once 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//GRAB TYPE FROM POST
$type = "toggledevice";
if(isset($_POST['type'])) $status = $_POST['type'];

//GRAB RELEVANT FLAGS
$hub_id = 0;
if(isset($_POST['hub_id'])) $hub_id = $_POST['hub_id'];
$id = 0;
if(isset($_POST['id'])) $id = $_POST['id'];
        //GET CURRENT STATUS OF ROOM
$stmt = $db->prepare("SELECT device_status FROM device_info WHERE hub_id = ? AND room_id = ?");
$stmt->bind_param("ii", $hub_id, $id);
$stmt->execute();
$result = $stmt->get_result();
$old_room_status = 0;
while($row = $result->fetch_assoc()) {
    $device = $row['device_id'];
    echo '<script type="text/javascript">',
        '$("#reload_" + $device).load(document + " #reload_" + $device);',
        '</script>'
}
$stmt->close();
}

?>