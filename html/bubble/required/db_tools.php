<?php
//TO USE THIS CLASS YOU JUST NEED TO include config.php!
//OTHERWISE IT WILL NOT WORK!


# LOGIN HELPER FUNCTIONS.
# Function to load specified or default URL.
function load($page = 'login.php')
{
    # Begin URL with protocol, domain, and current directory.
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

    # Remove trailing slashes then append page name to URL.
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;

    # Execute redirect then quit.
    header("Location: $url");
    exit();
}



# Function to check email address and password.
function validateLogin($email = '', $pwd = '')
{
    global $pepper, $db;
    require 'PepperedPasswords.php';
    # Initialize errors array.
    $errors = array();

    $stmt = $db->prepare("SELECT user_id, first_name, last_name, pass FROM user_info WHERE email=?");

    # Check email field.
    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $email = trim($email);
    }

    # Check password field.
    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $pwd = trim($pwd);
    }

    $hasher = new PepperedPasswords($pepper);

    # On success retrieve user_id, first_name, and last name from 'user' database.
    if (empty($errors)) {
        echo("validated $email");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            $errors[] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } 

        $result = $stmt->get_result();
     
        if($result->num_rows === 1){
            echo("found row $email");

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

function userHasHub(){
    if(isset($_SESSION['hub_id'])){
        return true;
    }

    global $db;
    $stmt = $db->prepare("SELECT hub_id FROM hub_users WHERE user_id=?");
    session_start();
    $stmt->bind_param("s", $_SESSION['user_id']);
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } 
    $result = $stmt->get_result();
 
    if($result->num_rows === 0){
        $stmt->free_result();
        $stmt->close();
       return false;
    }
    $stmt->get_result();
    $row = $result->fetch_assoc();

    $_SESSION['hub_id'] = $row['hub_id'];
    session_write_close();
    $stmt->free_result();
    $stmt->close();
    return true;

}


