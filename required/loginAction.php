<?php
# Open database connection.

# Get connection, load, and validate functions.

# PROCESS LOGIN ATTEMPT.
# Check form submitted.
echo "start";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "pass if";


    # Check login.
    list ($check, $data) = validate($link, $_POST['email'], $_POST['pass']);
    echo "list";
    # On success set session data and display logged in page.
    if ($check) {
        echo "pass if";
        # Access session.
        session_start();
        $_SESSION['UserID'] = $data['UserID'];
        $_SESSION['FirstName'] = $data['FirstName'];
        $_SESSION['LastName'] = $data['LastName'];
        $_SESSION['Sub'] = $data['Sub'];
        load('index.php');#need to chance index to php
    } # Or on failure set errors.
    else {
        $errors = $data;
    }

    # Close database connection.
    mysqli_close($link);
    echo "sesion info" . $_SESSION;
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
# Added to script:::Continue to display login page on failure.

include('../appCore.php');
?>