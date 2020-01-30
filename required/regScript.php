<?php
//Connect to the db
require 'connect_db.php';
require 'db_tools.php';

//Check server has request in POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Initialize an error array.
    $errors = array();
    $A2 = NULL;
    $stmt = $link->prepare("INSERT INTO user_info (email, pass, first_name, surname, address_l1, address_l2, postcode) VALUES ( ?, ?, ?, ?, ?, ?, ? )");
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
    if (empty($_POST['surname'])) {
        $errors[] = 'Enter your last name.';
    } else {
        $valuesArr["surname"] = trim($_POST['surname']);
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
            use Netsilik/Lib/PepperedPasswords;
            //TODO STORE THIS SOMEWHERE ELSE AND GENERATE LONG STRONG
            $config['pepper'] = hex2bin('012345679ABCDEF012345679ABCDEF012345679ABCDEF012345679ABCDEF');
            $hasher = new PepperedPasswords($config['pepper']);
            $valuesArr["postcode"] = $hasher->hash(trim($_POST['password']));
        }
    } else {
        $errors[] = 'Enter your password.';
    }


    # Check if email address already registered.
    if (empty($errors)) {
        $stmt2 = $link->prepare("SELECT * FROM user_info WHERE email = ?");
        $stmt2->bind_param("s", $valuesArr["email"]);
        $stmt2->execute();
        if ($stmt2->num_rows != 0) {
            $errors[] = 'Email address already registered. <a href="../appCore.php">Login</a>';
        }
    }

    # On success register user inserting into 'users' database table.
    if (empty($errors)) {
        // not posting to database
        $stmt->bind_param("ssssss", $valuesArr["email"], $valuesArr["password"], $valuesArr["first_name"], $valuesArr["surname"], $valuesArr["address_l1"], $valuesArr["address_l2"], $valuesArr["postcode"]);
        $stmt->execute();   
        if($stmt->affected_rows === 1){
            echo "r passed";
            echo '<div class="container"><h1>Registered!</h1><p>You are now registered.</p><p><a href="../index.php">Login</a></p>';
        }
        # Close database connection.
        $link->close();
        
        exit();
    } else { #Or report errors
        echo '<div class="container"><h1>Error!</h1><p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</p></div>';

        # Close database connection.
        $link->close();
    }
}
?>
