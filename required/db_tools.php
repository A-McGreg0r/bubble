<?php

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
function validateLogin($link, $email = '', $pwd = '')
{
    require 'PepperedPasswords.php';
    # Initialize errors array.
    $errors = array();

    $stmt = $link->prepare("SELECT user_id, first_name, last_name, pass FROM user_info WHERE email=?");

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

    //TODO STORE THIS SOMEWHERE ELSE AND GENERATE LONG STRONG
    $config['pepper'] = hex2bin('012345679ABCDEF012345679ABCDEF012345679ABCDEF012345679ABCDEF');

    $hasher = new PepperedPasswords($config['pepper']);

    # On success retrieve user_id, first_name, and last name from 'user' database.
    if (empty($errors)) {
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } 
        $result = $stmt->get_result();

        $num_of_rows = $stmt->num_rows;
     
        if($num_of_rows === 1){
            $row = $result->fetch_assoc();
            $checked = $hasher->verify($pwd, $row['pass']);
            if($checked){
                return array(true, $row);
            }else{
                $errors[] = 'Email address and password not found.';
            }
        } else {
            echo "Error! Multiple rows when expecting 1!";
        }
 
     
        /* free results */
        $stmt->free_result();
     
        /* close statement */
        $stmt->close();
    }
    # On failure retrieve error message/s.
    return array(false, $errors);
}


