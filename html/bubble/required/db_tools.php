<?php
//TO USE THIS CLASS YOU JUST NEED TO include config.php!
//OTHERWISE IT WILL NOT WORK!

// FUNCTION TO NAVIGATE THE USER TO A PAGE
function load($page = 'index.php') {
    # Begin URL with protocol, domain, and current directory.
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

    # Remove trailing slashes then append page name to URL.
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;

    # Execute redirect then quit.
    header("Location: $url");
    exit();
}

/**
 * VALIDATES USER LOGIN
 * TAKES INPUT EMAIL AND PASSWORD, AND CHECKS WITH THE DATABSE THAT THE USER IS WHO THEY SAY THEY ARE
 * THIS FUNCTION USES PEPPEREDPASSWORDS
 * RETURNS:
 *      ARRAY(
 *          BOOLEAN: LOGIN SUCCESS
 *          DATA: EITHER USER INFORMATION ON SUCCESS, OR ERROR LIST ON FAILURE
 *      )
 */
function validateLogin($email, $pwd = '') {
    global $pepper, $db;
    require 'PepperedPasswords.php';
    # Initialize errors array.
    $errors = array();

    $stmt = $db->prepare("SELECT user_id, first_name, last_name, pass FROM user_info WHERE email=?");
    # Check email field.
    if (!isset($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $email = trim($email);
    }

    # Check password field.
    if (!isset($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $pwd = trim($pwd);
    }

    $hasher = new PepperedPasswords($pepper);

    # On success retrieve user_id, first_name, and last name from 'user' database.
    if (empty($errors)) {
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            $errors[] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } 
	
        $result = $stmt->get_result();
     
        if($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $checked = $hasher->verify($pwd, $row['pass']);
            if($checked){
                return array(true, $row);
            }
        }
     
        /* free results */
        $stmt->free_result();
     
        /* close statement */
        $stmt->close();
    }
    # On failure retrieve error message/s.
    return array(false, $errors);
}

/**
 * CHECKS IF THE USER HAS A HUB REGISTERED WITH THE SERVICE
 */
function userHasHub(){
    session_start();
    //IF THE USER'S SESSION ALREADY HAS A HUB ID, WE KNOW THE USER HAS A HUB
    if(isset($_SESSION['hub_id'])){
        session_write_close();
        return true;
    }

    //OTHERWISE, CHECK THE DATABASE
    global $db;
    //FIND ALL HUBS IN JOIN TABLE THAT HAVE THE USER ID AS ASSOCIATED
    $stmt = $db->prepare("SELECT hub_id FROM hub_users WHERE user_id=?");
    $stmt->bind_param("s", $_SESSION['user_id']);
    session_write_close();
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } 
    $result = $stmt->get_result();
 
    //IF STATEMENT RETURNS ZERO ROWS, THE USER HAS NO HUBS
    if($result->num_rows === 0){
        $stmt->free_result();
        $stmt->close();
       return false;
    }
    $stmt->get_result();
    $row = $result->fetch_assoc();
    //IF THE STATEMENT RETURNS ROWS, GRAB THE FIRST, SET SESSION. THIS WILL ONLY BE DONE ON INITIAL LOGIN
    session_start();

    $_SESSION['hub_id'] = $row['hub_id'];
    
    //FINISH UP, CLOSE SESSION AND STATEMENTS, RETURN
    session_write_close();
    $stmt->close();
    return true;

}


