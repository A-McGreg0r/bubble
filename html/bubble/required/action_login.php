<?php
//REQUIRE CONFIG FILE
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //GATHER INPUT FROM POST DATA, VALIDATE AND SANITIZE
    $userEmail = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $userPassword = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
	
    //IF DATA INVALID
    if($userEmail == FALSE || $userPassword == FALSE){
        echo("{\"error\":\"Invalid username or password\"}");
        exit(0);
    }
    //VALIDATE PROVIDED LOGIN INFORMATION
    list ($check, $data) = validateLogin($userEmail, $userPassword);

    //IF SUCCESSFUL, BEGIN SESSION< STORE DATA
    if ($check) {
        # Access session.
        session_start();
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        session_write_close();
        echo("{\"success\":\"Login successful\"}");
        exit(0);
    } else {
        echo("{\"error\":\"Unknown username or password\"}");
        exit(0);
    }

}
echo("{\"error\":\"Login failed\"}");
exit(0);
?>
