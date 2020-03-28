<?php
//Connect to the db
require 'config.php';
require 'PepperedPasswords.php';
session_start();

//Check server has request in POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Initialize an error array.
    $errors = array();
    $A2 = NULL;
    $stmt = $db->prepare("INSERT INTO user_info (email, pass, first_name, last_name, address_l1, address_l2, postcode, energy_cost, budget) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )");
    $valuesArr = array();
    $_SESSION['email'] = trim($_POST['email']);
    $_SESSION['name'] = trim($_POST['first_name']);

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

    # Check for a adress line 1.
    if (empty($_POST['address_l1'])) {
        $errors[] = 'Enter first line of your Address';
    } else {
        $valuesArr["address_l1"] = trim($_POST['address_l1']);
    }

    # Check for a adress line 2.
    # Check for a adress line 1.
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


    # Check if email address already registered.
    if (empty($errors)) {
        $stmt2 = $db->prepare("SELECT * FROM user_info WHERE email = ?");
        $stmt2->bind_param("s", $valuesArr["email"]);
        $stmt2->execute();
        if ($stmt2->num_rows != 0) {
            $errors[] = 'Email address already registered. <a href="../index.php">Login</a>';
        }
        $stmt2->close();
    }

    # On success register user inserting into 'users' database table.
    if (empty($errors)) {
        // not posting to database
        $stmt->bind_param("sssssssdi", $valuesArr["email"], $valuesArr["password"], $valuesArr["first_name"], $valuesArr["last_name"], $valuesArr["address_l1"], $valuesArr["address_l2"], $valuesArr["postcode"], $valuesArr["energy_cost"], $valuesArr["budget"]);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } 

        if($stmt->affected_rows === 1){
            load("../index.php?action=registerComplete");
        }else{
            load("../index.php?action=registerFailed");
        }
        # Close database connection.
        $db->close();
        
        exit();
    } else { #Or report errors
        echo '<div class="container"><h1>Error!</h1><p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</p></div>';

        # Close database connection.
        $db->close();
    }
}
?>
