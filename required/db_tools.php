<?php
//not used yet
require "connect_db.php";


# LOGIN HELPER FUNCTIONS.

# Function to load specified or default URL.
function load($page = 'index.php')
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


//function regester()
//{


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Initialize an error array.
    $errors = array();
    $A2 = NULL;
# Check for a E-mail.
    if (empty($_POST['Email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($_POST['Email']));
    }

    # Check for a first name.
    if (empty($_POST['FirstName'])) {
        $errors[] = 'Enter your first name.';
        } else {
            $fn = mysqli_real_escape_string($link, trim($_POST['FirstName']));
        }

        # Check for a last name.
        if (empty($_POST['LastName'])) {
            $errors[] = 'Enter your last name.';
        } else {
            $ln = mysqli_real_escape_string($link, trim($_POST['LastName']));
        }

        # Check for a adress line 1.
        if (empty($_POST['Address_1'])) {
            $errors[] = 'Enter your Address 1';
        } else {
            $A1 = mysqli_real_escape_string($link, trim($_POST['Address_1']));
        }

        # Check for a adress line 2.
        # Check for a adress line 1.
        if (empty($_POST['Address_2'])) {
            $errors[] = 'Enter your Address 2';
        } else {
            $A2 = mysqli_real_escape_string($link, trim($_POST['Address_2']));
        }

        # Check for a postcode
        if (empty($_POST['Pcode'])) {
            $errors[] = 'Enter your postcode.';
        } else {
            $Pc = mysqli_real_escape_string($link, trim($_POST['Pcode']));
        }

        # Check for a phone nuber
        if (empty($_POST['Pnum'])) {
            $errors[] = 'Enter your phone number.';
        } else {
            $Pn = mysqli_real_escape_string($link, trim($_POST['Pnum']));
        }


        # Check for a password and matching input passwords.
        if (!empty($_POST['pass1'])) {
            if ($_POST['pass1'] != $_POST['pass2']) {
                $errors[] = 'Passwords do not match.';
            } else {
                $p = mysqli_real_escape_string($link, trim($_POST['pass1']));
            }
        } else {
            $errors[] = 'Enter your password.';
        }

        # Check if email address already registered.
        if (empty($errors)) {
            $q = "SELECT * FROM Berwick_users WHERE email=$e";
            $r = @mysqli_query($link, $q);
            if (mysqli_num_rows($r) != 0) $errors[] = 'Email address already registered. <a href="index.php">Login</a>';
        }

        # On success register user inserting into 'users' database table.
        if (empty($errors)) {
            // not posting to database
            $q = "INSERT INTO Berwick_users (Email, FirstName, LastName, Address_1, Address_2, Pcode, Pnum, pass, reg_date) VALUES ( '$e', '$fn', '$ln', '$A1', '$A2', '$Pc', '$Pn', SHA1('$p'), NOW() )";
            $r = @mysqli_query($link, $q);
            if ($r) {
                echo '<div class="container"><h1>Registered!</h1><p>You are now registered.</p><p><a href="Dogin.php">Login</a></p>';
            }
            # Close database connection.
            mysqli_close($link);
            echo 'I ran';
            exit();
        } else # Or report errors.
        {
            echo '<div class="container"><h1>Error!</h1><p id="err_msg">The following error(s) occurred:<br>';
            foreach ($errors as $msg) {
                echo " - $msg<br>";
            }
            echo 'Please try again.</p></div>';

            # Close database connection.
            mysqli_close($link);
        }


}


