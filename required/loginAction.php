<?php # PROCESS LOGIN ATTEMPT.
# Open database connection.
require('connect_db.php');
# Get connection, load, and validate functions.
require('functionTesting.php');
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
        load('../appCore.php');#return to appCore.php
    } # Or on failure set errors.
    else {
        echo "error";
        $errors = $data;
    }
    # Close database connection.
    mysqli_close($link);
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
# Added to script:::Continue to display login page on failure.
load('../appCore.php');#return to appCore.php
?>