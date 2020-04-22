<?php
include_once 'config.php';

//BEGIN SESSION
session_start();
$user_id = $_SESSION['user_id'];
//END SESSION
session_write_close();

//GRAB INFORMATION SENT OVER AJAX


$type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
if($type == FALSE){
    echo("{\"error\":\"Invalid type\"}");
    exit(0);
}

if($type == "account"){
    
    //GET FIRST NAME
    $first_name = filter_input(INPUT_POST, "fn", FILTER_SANITIZE_STRING);
    if($first_name == FALSE && $_POST['fn'] != ""){
        echo("{\"error\":\"Invalid first name\"}");
        exit(0);
    }

    //GET VALID LAST NAME
    $last_name = filter_input(INPUT_POST, "ln", FILTER_SANITIZE_STRING);
    if($last_name == FALSE && $_POST['ln'] != ""){
        echo("{\"error\":\"Invalid last name\"}");
        exit(0);
    }

    //GET VALID EMAIL
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    if($email == FALSE && $_POST['email'] != ""){
        echo("{\"error\":\"Invalid email address\"}");
        exit(0);
    }

    //GET VALID ADDRESS LINE 1
    $adr1 = filter_input(INPUT_POST, "adl1", FILTER_SANITIZE_STRING);
    if($adr1 == FALSE && $_POST['adl1'] != ""){
        echo("{\"error\":\"Invalid address line 1\"}");
        exit(0);
    }

    //GET VALID ADDRESS LINE 2
    $adr2 = filter_input(INPUT_POST, "adl2", FILTER_SANITIZE_STRING);
    if($adr2 == FALSE && $_POST['adl2'] != ""){
        echo("{\"error\":\"Invalid address line \"}");
        exit(0);
    }

    //GET VALID POSTCODE
    $postcode = filter_input(INPUT_POST, "post", FILTER_SANITIZE_STRING);
    if($postcode == FALSE && $_POST['post'] != ""){
        echo("{\"error\":\"Invalid address postcode \"}");
        exit(0);
    }

    //GET VALID ACCEPT EMAILS
    $allow_email = filter_input(INPUT_POST, "ae", FILTER_SANITIZE_STRING);
    if($allow_email == FALSE && $_POST['ae'] != ""){
        echo("{\"error\":\"Invalid ae \"}");
        exit(0);
    }

        
    //If an edit has been made, update the user information with the new value
    if($first_name != ''){
        $stmt = $db->prepare("UPDATE user_info SET first_name = ? WHERE user_id = ?");
        $stmt->bind_param("si", $first_name, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //If an edit has been made, update the user information with the new value
    if($last_name != ''){
        $stmt = $db->prepare("UPDATE user_info SET last_name = ? WHERE user_id = ?");
        $stmt->bind_param("si", $last_name, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //If an edit has been made, update the user information with the new value
    if($email != ''){
        $stmt = $db->prepare("UPDATE user_info SET email = ? WHERE user_id = ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //If an edit has been made, update the user information with the new value
    if($adr1 != ''){
        $stmt = $db->prepare("UPDATE user_info SET address_l1 = ? WHERE user_id = ?");
        $stmt->bind_param("si", $adr1, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //If an edit has been made, update the user information with the new value
    if($adr2 != ''){
        $stmt = $db->prepare("UPDATE user_info SET address_l2 = ? WHERE user_id = ?");
        $stmt->bind_param("si", $adr2, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //If an edit has been made, update the user information with the new value
    if($postcode != ''){
        $stmt = $db->prepare("UPDATE user_info SET postcode = ? WHERE user_id = ?");
        $stmt->bind_param("si", $postcode, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    $stmt2 = $db->prepare("UPDATE user_info SET allow_emails = ? WHERE user_id = ?");
    $stmt2->bind_param("si", $allow_email, $user_id);
    $stmt2->execute();
    $stmt2->close();

    echo("{\"success\":\"Success \"}");

} elseif($type == "costings"){
    //GET VALID ENERGY COST
    $energy_cost = filter_input(INPUT_POST, "energy_cost", FILTER_SANITIZE_STRING);
    if($energy_cost == FALSE && $_POST['energy_cost'] != ""){
        echo("{\"error\":\"Invalid energy cost \"}");
        exit(0);
    }

    //GET VALID BUDGET
    $budget = filter_input(INPUT_POST, "budget", FILTER_SANITIZE_NUMBER_INT);
    if($budget == FALSE && $_POST['budget'] != ""){
        echo("{\"error\":\"Invalid budget \"}");
        exit(0);
    }

    //GET VALID solargen
    $solargen = filter_input(INPUT_POST, "solargen", FILTER_SANITIZE_STRING);
    if($solargen == FALSE && $_POST['solargen'] != ""){
        echo("{\"error\":\"Invalid solargen \"}");
        exit(0);
    }
    
    //If an edit has been made, update the user information with the new value
    if($energy_cost != ''){
        $stmt = $db->prepare("UPDATE hub_cost SET energy_cost = ? WHERE user_id = ?");
        $stmt->bind_param("di", $energy_cost, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //If an edit has been made, update the user information with the new value
    if($budget != ''){
        $stmt = $db->prepare("UPDATE hub_cost SET budget = ? WHERE user_id = ?");
        $stmt->bind_param("ii", $budget, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    //If an edit has been made, update the user information with the new value
    if($solargen != ''){
        $stmt = $db->prepare("UPDATE hub_cost SET solargen = ? WHERE user_id = ?");
        $stmt->bind_param("si", $solargen, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}else{
    echo("{\"error\":\"Invalid request \"}");

}



?>