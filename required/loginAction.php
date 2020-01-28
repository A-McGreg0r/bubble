<?php # PROCESS LOGIN ATTEMPT.
# Open database connection.
require('connect_db.php');
# Get connection, load, and validate functions.
require('loginTools.php');
# Check form submitted.

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
        load('index.php');#return to index.php
    } # Or on failure set errors.
    else {
        $errors = $data;
    }

    # Close database connection.
    mysqli_close($link);
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
# Added to script:::Continue to display login page on failure.
include('index.php');
?>