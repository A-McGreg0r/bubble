<?php
//connextst to the db
require 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  # Initialize an error array.
  $errors = array();
  $A2 = NULL;

  # Check for a Username.
  if (empty($_POST['username'])) {
    $errors[] = 'Enter your email address.';
  } else {
    $e = mysqli_real_escape_string($link, trim($_POST['username']));
  }

# Check for a E-mail.
  if (empty($_POST['email'])) {
    $errors[] = 'Enter your email address.';
  } else {
    $e = mysqli_real_escape_string($link, trim($_POST['email']));
  }

  # Check for a first name.
  if (empty($_POST['first_name'])) {
    $errors[] = 'Enter your first name.';
  } else {
    $fn = mysqli_real_escape_string($link, trim($_POST['first_name']));
  }

  # Check for a last name.
  if (empty($_POST['surname'])) {
    $errors[] = 'Enter your last name.';
  } else {
    $ln = mysqli_real_escape_string($link, trim($_POST['surname']));
  }

  # Check for a adress line 1.
  if (empty($_POST['address_l1'])) {
    $errors[] = 'Enter first line of your Address';
  } else {
    $A1 = mysqli_real_escape_string($link, trim($_POST['address_l1']));
  }

  # Check for a adress line 2.
  # Check for a adress line 1.
  if (!empty($_POST['address_l2'])) {
    $A2 = mysqli_real_escape_string($link, trim($_POST['address_l2']));
  }
  # Check for a postcode
  if (empty($_POST['postcode'])) {
    $errors[] = 'Enter your postcode.';
  } else {
    $Pc = mysqli_real_escape_string($link, trim($_POST['postcode']));
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
    $q = "SELECT * FROM user_info WHERE email=$e";
    $r = @mysqli_query($link, $q);
    if (mysqli_num_rows($r) != 0) $errors[] = 'Email address already registered. <a href="index.php">Login</a>';
  }

  # On success register user inserting into 'users' database table.
  if (empty($errors)) {
    // not posting to database
    $q = "INSERT INTO user_info (Email, FirstName, LastName, Address_1, Address_2, Pcode, Pnum, pass, reg_date) VALUES ( '$e', '$fn', '$ln', '$A1', '$A2', '$Pc', '$Pn', SHA1('$p'), NOW() )";
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
?>
