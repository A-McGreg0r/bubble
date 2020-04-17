<?php
//REQUIRE CONFIG FILE
include_once 'config.php';

//GET NEW HUB ID FROM POST REQUEST
$new_hub_id = NULL;
if(isset($_POST['hub_id'])) $new_hub_id = filter_input(INPUT_POST, "hub_id", FILTER_SANITIZE_NUMBER_INT);;

//BEGIN SESSION
session_start();
if (isset($new_hub_id)) {
    //GET USER ID FROM SESSION
    $user_id = $_SESSION['user_id'];
    if(isset($user_id)){
        //CHECK THAT THE USER IS ALLOWED TO ACCESS THIS HUB
        $stmt = $db->prepare("SELECT * FROM hub_users WHERE user_id = ? AND hub_id = ?");
        $stmt->bind_param("ii", $user_id, $new_hub_id);
        $stmt->execute();
        $result = $stmt->get_result();
        //USER IS ALLOWED TO CHANGE TO THIS NEW HUB
        if($result->num_rows > 0){
            //UPDATE HUB ID
            $_SESSION['hub_id'] = $new_hub_id;
            session_write_close();
            echo("{\"success\":\"Change successful\"}");
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