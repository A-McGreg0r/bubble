<?php

# Function to check email address and password.

# Initialize errors array.
$errors = array();

if (isset($link)) {

    # Check email field.
    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($email));
    }

    # Check password field.
    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $p = mysqli_real_escape_string($link, trim($pwd));
    }

    # On success retrieve user_id, first_name, and last name from 'user' database.
    if (empty($errors)) {
        $q = "SELECT UserID, FirstName, LastName FROM Berwick_users WHERE email='$e' AND pass=SHA1('$p')";
        $r = mysqli_query($link, $q);
        if (@mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            return array(true, $row);
        } # Or on failure set error message.
        else {
            $errors[] = 'Email address and password not found.';
        }
    }
    # On failure retrieve error message/s.
    return array(false, $errors);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Check login.
    list ($check, $data) = validate($link, $_POST['email'], $_POST['pass']);

    # On success set session data and display logged in page.
    if ($check) {
        # Access session.
        session_start();
        $_SESSION['UserID'] = $data['UserID'];
        $_SESSION['FirstName'] = $data['FirstName'];
        $_SESSION['LastName'] = $data['LastName'];
        $_SESSION['Sub'] = $data['Sub'];
        load('http://bubble.myddns.me/GroupWork-Site/');#return to appCore.php
    } # Or on failure set errors.
    else {
        echo "error";
        $errors = $data;
    }
    # Close database connection.
    mysqli_close($link);
}


function validate($link, $email = '', $pwd = '')
{
    # Initialize errors array.
    $errors = array();

    # Check email field.
    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($email));
    }

    # Check password field.
    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $p = mysqli_real_escape_string($link, trim($pwd));
    }

    # On success retrieve user_id, first_name, and last name from 'user' database.
    if (empty($errors)) {
        $q = "SELECT user_id, first_name, surname FROM user_info WHERE email='$e' AND pass=SHA1('$p')";
        $r = mysqli_query($link, $q);
        if (@mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            return array(true, $row);
        } # Or on failure set error message.
        else {
            $errors[] = 'Email address and/or password not found.';
        }
    }
    # On failure retrieve error message/s.
    return array(false, $errors);
}