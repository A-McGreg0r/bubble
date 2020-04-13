<?php
//Connect to the db
require 'config.php';
require 'PepperedPasswords.php';
session_start();

//GRAB IP ADDRESS FROM CLIENT
$ipaddress = '';
if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
else if(getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
else if(getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
else if(getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
else if(getenv('HTTP_FORWARDED'))
    $ipaddress = getenv('HTTP_FORWARDED');
else if(getenv('REMOTE_ADDR'))
    $ipaddress = getenv('REMOTE_ADDR');
else
    $ipaddress = 'UNKNOWN';

//Check server has request in POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Initialize an error array.
    $errors = array();
    $A2 = NULL;
    $stmt = $db->prepare("INSERT INTO user_info (email, pass, first_name, last_name, address_l1, address_l2, postcode, energy_cost, budget, allow_emails, ip_address) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
    $valuesArr = array();
    # Check for a E-mail.
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $valuesArr["email"] = trim($_POST['email']);
    }

    # Check for a first name.
    if (empty($_POST['first_name'])) {
        $errors[] = 'Enter your first name.';
    } else {
        $valuesArr["first_name"] = trim($_POST['first_name']);
    }

    # Check for a last name.
    if (empty($_POST['last_name'])) {
        $errors[] = 'Enter your last name.';
    } else {
        $valuesArr["last_name"] = trim($_POST['last_name']);
    }

    # Check for a address line 1.
    if (empty($_POST['address_l1'])) {
        $errors[] = 'Enter first line of your Address';
    } else {
        $valuesArr["address_l1"] = trim($_POST['address_l1']);
    }

    # Check for a address line 2.
    if (!empty($_POST['address_l2'])) {
        $valuesArr["address_l2"] = trim($_POST['address_l2']);
    }
    
    # Check for a postcode
    if (empty($_POST['postcode'])) {
        $errors[] = 'Enter your postcode.';
    } else {
        $valuesArr["postcode"] = trim($_POST['postcode']);
    }


    # Check for a password and matching input passwords.
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Passwords do not match.';
        } else {
            //Using pepperedpasswords, generates a salted and peppered password to be stored in db            
            $hasher = new PepperedPasswords($pepper);
            $valuesArr["password"] = $hasher->hash(trim($_POST['pass1']));
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    if (empty($_POST['energy_cost'])) {
        $errors[] = 'Enter your energy price.';
    } else {
        $valuesArr["energy_cost"] = $_POST['energy_cost'];
    }

    if (empty($_POST['budget'])) {
        $errors[] = 'Enter your budget.';
    } else {
        $valuesArr["budget"] = $_POST['budget'];
    }

    if ($_POST['allow_emails'] == "Yes") {
        $valuesArr["allow_emails"] = "Yes";
    } else {
        $valuesArr["allow_emails"] = "No";
    }

	print_r($_POST);
	print_r($errors);
    //ENSURE EMAIL ADDRESS ISNT ALREADY REGISTERED.
    if (empty($errors)) {
        $stmt2 = $db->prepare("SELECT * FROM user_info WHERE email = ?");
        $stmt2->bind_param("s", $valuesArr["email"]);
        $stmt2->execute();
        if ($stmt2->num_rows != 0) {
            echo("{\"error\":\"Email address already registered. <a href=\"../index.php\">Login</a>\"}");
            exit(0);
        }
        $stmt2->close();
    }

    # On success register user inserting into 'users' database table.
    if (empty($errors)) {
        // not posting to database
        $stmt->bind_param("sssssssdiss", $valuesArr["email"], $valuesArr["password"], $valuesArr["first_name"], $valuesArr["last_name"], $valuesArr["address_l1"], $valuesArr["address_l2"], $valuesArr["postcode"], $valuesArr["energy_cost"], $valuesArr["budget"], $valuesArr["allow_emails"], $ipaddress);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } 

        if($stmt->affected_rows === 1){
     //       load("../index.php?action=registerComplete");
        }else{
            echo("{\"error\":\"Registration failed, try again!\"}");
        }
        # Close database connection.
        $stmt->close();
        
        exit();
    } else {
        echo("{\"error\":\"");
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo("\"}");

        # Close database connection.
        $stmt->close();
    }
}
?>
