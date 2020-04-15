<?php
//REUIQRE CONFIG FILE
include_once 'config.php';

//GET NEW HUB ID FROM POST REQUEST
$hub_id = NULL;
if(isset($_POST['hub_id'])) $hub_id = $_POST['hub_id'];

//BEGIN SESSION
session_start();
if (isset($hub_id)) {
    //GET USER ID FROM SESSION
    $user_id = $_SESSION['user_id'];
    if(isset($user_id)){
        //CHECK THAT THE USER IS ALLOWED TO ACCESS THIS HUB
        $stmt = $db->prepare("SELECT * FROM hub_users WHERE user_id = ? AND hub_id = ?");
        $stmt->bind_param("ii", $user_id, $hub_id);
        $stmt->execute();
        $result = $stmt->get_result();
        //USER IS ALLOWED TO CHANGE TO THIS NEW HUB
        if($result->num_rows > 0){
            //UPDATE HUB ID
            $_SESSION['hub_id'] = $hub_id;
            echo("{\"success\":\"Change successful\"}");
            session_write_close();
            exit();
        }
        $stmt->close();
        session_write_close();
        echo("{\"error\":\"Invalid request - Bad hub ID\"}");
        exit();
    }
    session_write_close();
    echo("{\"error\":\"Invalid request\"}");
    exit();
}
?>