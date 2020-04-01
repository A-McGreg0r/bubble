<?php
include_once 'config.php';

global $db;

$status = 0;
if(isset($_POST['stat'])) $status = $_POST['stat'];
$hub_id = 0;
if(isset($_POST['hubID'])) $hub_id = $_POST['hubID'];
$device_id = 0;
if(isset($_POST['id'])) $device_id = $_POST['id'];
$device_name = '';
if(isset($_POST['dev_name'])) $device_name = $_POST['dev_name'];

$set_device = 0;
$on_or_off = 'off';

if ($status == 0){
    $set_device = 1;
    $on_or_off = 'on';
}

$stmt = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ?");
$stmt->bind_param("ii", $set_device, $device_id);
$stmt->execute();


?>