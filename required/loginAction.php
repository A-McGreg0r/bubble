<?php
# Open database connection.

# Get connection, load, and validate functions.
require 'connect_db.php';
require 'db_tools.php';

# PROCESS LOGIN ATTEMPT.
# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    # Check login.
    list ($check, $data) = validateLogin($link, $_POST['email'], $_POST['password']);

    # On success set session data and display logged in page.
    if ($check) {
        # Access session.
        session_start();
        //todo get sessions set up
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];

        load('../index.php');#need to chance index to php
    } # Or on failure set errors.
    else {
        $errors = $data;
    }

}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
# Added to script:::Continue to display login page on failure.

//load('../err.php');
?>