<?php
include_once 'config.php';
global $db;

//Find info sent over ajax
$id = 0;
if(isset($_POST['id'])) $id = $_POST['id'];
$first_name = '';
if(isset($_POST['fn'])) $first_name = $_POST['fn'];
$last_name = '';
if(isset($_POST['ln'])) $last_name = $_POST['ln'];
$email = '';
if(isset($_POST['email'])) $email = $_POST['email'];
$adr1 = '';
if(isset($_POST['adl1'])) $adr1 = $_POST['adl1'];
$adr2 = '';
if(isset($_POST['adl2'])) $adr2 = $_POST['adl2'];
$postcode = '';
if(isset($_POST['post'])) $postcode = $_POST['post'];
$energy_price = 0;
if(isset($_POST['ep'])) $energy_price = $_POST['ep'];
$budget = 0;
if(isset($_POST['mb'])) $budget = $_POST['mb'];
$solar = 0;
if(isset($_POST['sp'])) $solar = $_POST['sp'];

//Loop through devices
if($first_name != ''){
    $stmt1 = $db->prepare("UPDATE user_info SET first_name = ? WHERE user_id = ?");
    $stmt1->bind_param("si", $first_name, $id);
    $stmt1->execute();
}

if($last_name != ''){
    $stmt1 = $db->prepare("UPDATE user_info SET last_name = ? WHERE user_id = ?");
    $stmt1->bind_param("si", $last_name, $id);
    $stmt1->execute();
}

if($email != ''){
    $stmt1 = $db->prepare("UPDATE user_info SET email = ? WHERE user_id = ?");
    $stmt1->bind_param("si", $email, $id);
    $stmt1->execute();
}

if($adr1 != ''){
    $stmt1 = $db->prepare("UPDATE user_info SET address_l1 = ? WHERE user_id = ?");
    $stmt1->bind_param("si", $adr1, $id);
    $stmt1->execute();
}

if($adr2 != ''){
    $stmt1 = $db->prepare("UPDATE user_info SET address_l2 = ? WHERE user_id = ?");
    $stmt1->bind_param("si", $adr2, $id);
    $stmt1->execute();
}

if($postcode != ''){
    $stmt1 = $db->prepare("UPDATE user_info SET postcode = ? WHERE user_id = ?");
    $stmt1->bind_param("si", $postcode, $id);
    $stmt1->execute();
}

if($energy_price != 0){
    $stmt1 = $db->prepare("UPDATE user_info SET energy_cost = ? WHERE user_id = ?");
    $stmt1->bind_param("di", $energy_price, $id);
    $stmt1->execute();
}

if($budget != 0){
    $stmt1 = $db->prepare("UPDATE user_info SET budget = ? WHERE user_id = ?");
    $stmt1->bind_param("ii", $budget, $id);
    $stmt1->execute();
}

?>