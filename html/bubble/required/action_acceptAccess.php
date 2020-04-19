<?php
//REQUIRE CONFIG FILE
include_once 'config.php';
include_once dirname(__DIR__).'/required/PepperedPasswords.php';

//GET USER EMAIL FROM POST REQUEST
$user_email = filter_input(INPUT_POST, "user_email", FILTER_SANITIZE_STRING);
$auth_key = filter_input(INPUT_POST, "auth_key", FILTER_SANITIZE_STRING);

if($user_email == FALSE || $auth_key == FALSE){
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
    $stmt = $db->prepare("SELECT * FROM hub_access_requests WHERE owner_user_id = ? AND request_user_id = ?");
    $stmt->bind_param("ii", $user_id, $request_user_id);
    if(!$stmt->execute()){
        echo("{\"error\":\"Invalid request - 2\"}");
        $stmt->close();
        exit(0);
    }
    $result = $stmt->get_result();

    //GET THE HUB ID THAT NEEDS A USER ADDED TO IT
    $row = $result->fetch_assoc();
    $hub_id = $row['hub_id'];
    $database_auth_key = $row['auth_key'];
    $stmt->close();

    //VALIDATE AUTH KEY AGAINST DATABASE AUTH KEY
    $hasher = new PepperedPasswords($pepper);

    if(!$hasher->verify($auth_key, $database_auth_key)){
        echo("{\"error\":\"Invalid request - 3\"}");
        exit(0);
    }

    //FINALLY, ALLOW THE USER TO ACCESS THE HUB!
    $stmt = $db->prepare("INSERT INTO hub_users (hub_id, user_id) VALUES (?,?)");
    $stmt->bind_param("ii", $hub_id, $request_user_id);
    if($stmt->execute()){
        $stmt->close();

        //DELETE REQUEST ROW IN TABLE
        $stmt2 = $db->prepare("DELETE FROM hub_access_requests WHERE auth_key = ?");
        $stmt2->bind_param("s", $database_auth_key);
        if($stmt2->execute()){
            echo("{\"success\":\"Successfully added new user\"}");
            $stmt2->close();
            exit(0);
        }
        echo("{\"success\":\"Successfully added new user - 2\"}");
        $stmt2->close();
        exit(0);
    }
    echo("{\"error\":\"Invalid request - 4\"}");
    $stmt->close();
    exit(0);   

}
session_write_close();
exit(0);
?>