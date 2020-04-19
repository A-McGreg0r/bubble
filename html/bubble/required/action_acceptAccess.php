<?php
//REQUIRE CONFIG FILE
include_once 'config.php';

//GET USER EMAIL FROM POST REQUEST
$user_email = filter_input(INPUT_POST, "user_email", FILTER_SANITIZE_STRING);
$auth_key = filter_input(INPUT_POST, "auth_key", FILTER_SANITIZE_STRING);

if($user_email == FALSE){
    echo("{\"error\":\"Invalid request\"}");
}

session_start();

//GET SESSION INFORMATION
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    session_write_close();

    //GET THE REQUESTING USER'S ID FROM THEIR EMAIL ADDRESS
    $stmt = $db->prepare("SELECT user_id FROM user_info WHERE email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $request_user_id = $row['user_id'];
    $stmt->close();

    //ENSURE THAT THE CORRECT USER IS LOGGED IN, AND ENSURE THAT THE AUTH KEY HAS BEEN RECIEVED BY THE EMAIL OWNER
    $stmt = $db->prepare("SELECT * FROM hub_access_requests WHERE owner_user_id = ? AND request_user_id = ? AND auth_key = ?");
    $stmt->bind_param("iis", $user_id, $request_user_id, $auth_key);
    if(!$stmt->execute()){
        echo("{\"error\":\"Invalid request - 2\"}");
        $stmt->close();
        exit(0);
    }
    $result = $stmt->get_result();

    //GET THE HUB ID THAT NEEDS A USER ADDED TO IT
    $row = $result->fetch_assoc();
    $hub_id = $row['hub_id'];
    $stmt->close();

    //FINALLY, ALLOW THE USER TO ACCESS THE HUB!
    $stmt = $db->prepare("INSERT INTO hub_users (hub_id, user_id) VALUES (?,?)");
    $stmt->bind_param("ii", $hub_id, $request_user_id);
    if($stmt->execute()){
        echo("{\"success\":\"Successfully added new user\"}");
        $stmt->close();
        exit(0);
    }
    echo("{\"error\":\"Invalid request - 3 $hub_id $request_user_id\"}");
    $stmt->close();
    exit(0);   

}
session_write_close();
exit(0);
?>