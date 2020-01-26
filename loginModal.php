<?php
//TODO chane sql escap strings to prpared statments
//TODO spell cheack.
//TODO mach the varabuls to there corasoponding one in the database and data dictonory
//TODO mach the varabuls max lenth to the database once that fixed.
//TODO testing
# Check form submitted.
//reg script
//connects to the db
require 'required/connect_db.php';

//TODO implment sql injection preventions on all posts
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
        $q = "SELECT * FROM Berwick_users WHERE email=SHA1('$e')";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0) {
            $errors[] = 'Email address already registered. <a href="index.php">Login</a>';
        }//TODO change it to display a meesege to the user
    }

    # On success register user inserting into 'users' database table.
    if (empty($errors)) {
        // not posting to database
        $q = "INSERT INTO users_info (Email, FirstName, LastName, Address_1, Address_2, Pcode, Pnum, pass, reg_date) VALUES ( SHA1('$e'), SHA1('$fn'), SHA1('$ln'), SHA1('$A1'), SHA1('$A2'), SHA1('$Pc'), SHA1('$Pn'), SHA1('$p'), NOW() )";
        $r = @mysqli_query($link, $q);
        if ($r) {
            echo '<div class="container"><h1>Registered!</h1><p>You are now registered.</p><p><a href="index.php">Login</a></p>';
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

<?php
//login script

//connect to the db
require 'required/connect_db.php';
//body content

# DISPLAY COMPLETE LOGIN PAGE.
# Display any error messages if present.
if (isset($errors) && !empty($errors)) {
    echo '<p id="err_msg">Oops! There was a problem:<br>';
    foreach ($errors as $msg) {
        echo " - $msg<br>";
    }
    echo 'Please try again or create account.</p>';
}
?>

<form action="loginModal.php" method="post">


    <!--Modal: Login / Register Form-->
    <div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!--Content-->
            <div class="modal-content elegant-color-dark">

                <!--Modal cascading tabs-->
                <div class="modal-c-tabs">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs tabs-2 elegant-color" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#panel7" role="tab"><i
                                        class="fas fa-user mr-1"></i>
                                Login</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="tab" href="#panel8" role="tab"><i
                                        class="fas fa-user-plus mr-1"></i>
                                Register</a>
                        </li>
                    </ul>
                    <!-- login -->
                    <!-- Tab panels -->
                    <div class="tab-content ">
                        <!--Panel 7 Login -->
                        <div class="tab-pane fade in show active" id="panel7" role="tabpanel">

                            <!--Body-->
                            <div class="modal-body mb-1">

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput10">Your
                                        E-mail</label>
                                    <input type="email" id="modalLRInput10"
                                           class="form-control form-control-sm validate"
                                           name="email">
                                </div>

                                <div class="md-form form-sm mb-4">
                                    <i class="fas fa-lock prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput11">Password</label>
                                    <input type="password" id="modalLRInput11"
                                           class="form-control form-control-sm validate"
                                           name="pass">

                                </div>

                                <div class="text-center mt-2">
                                    <button class="btn btn-info">Log in <i class="fas fa-sign-in ml-1"></i></button>
                                </div>

                            </div>
                            <!--Footer-->
                            <div class="modal-footer">
                                <div class="options text-center text-md-right mt-1">
                                    <p>Not a member? <a href="#" class="blue-text">Sign Up</a></p>
                                    <p>Forgot <a href="#" class="blue-text">Password?</a></p>
                                </div>
                                <!-- TODO implment sso for gogle-->
                                <button type="button" class="btn btn-outline-info waves-effect ml-auto"
                                        data-dismiss="modal">Close
                                </button>
                            </div>

                        </div>
                        <!--/.Panel 7-->


                        <!--Panel 8 register-->
                        <div class="tab-pane fade" id="panel8" role="tabpanel">

                            <!--Body-->
                            <div class="modal-body">
                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput12">Your
                                        Email</label>
                                    <input type="email"
                                           id="modalLRInput12"
                                           class="form-control form-control-sm validate"
                                           name="Email"
                                           required size="20"
                                           value="<?php if (isset($_POST['Email'])) echo $_POST['Email']; ?>">
                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput12">Your
                                        Name</label>
                                    <input type="text"
                                           id="modalLRInput12"
                                           class="form-control form-control-sm validate"
                                           name="FirstName"
                                           required size="20"
                                           value="<?php if (isset($_POST['FirstName'])) echo $_POST['FirstName']; ?>">
                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput12">Name</label>
                                    <input type="text"
                                           id="modalLRInput12"
                                           class="form-control form-control-sm validate"
                                           name="LastName"
                                           required size="20"
                                           value="<?php if (isset($_POST['LastName'])) echo $_POST['LastName']; ?>">
                                </div>


                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput12">Address
                                        line-1</label>
                                    <input type="text"
                                           id="modalLRInput12"
                                           class="form-control form-control-sm validate"
                                           name="Address_1"
                                           required size="20"
                                           value="<?php if (isset($_POST['Address_1'])) echo $_POST['Address_1']; ?>">
                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput12">Address
                                        line-2</label>
                                    <input type="text"
                                           id="modalLRInput12"
                                           class="form-control form-control-sm validate"
                                           name="Address_2"
                                           required size="20"
                                           value="<?php if (isset($_POST['Address_2'])) echo $_POST['Address_2']; ?>">

                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput12">Postcode</label>
                                    <input type="text"
                                           id="modalLRInput12"
                                           class="form-control form-control-sm validate"
                                           name="Pcode"
                                           required size="10"
                                           value="<?php if (isset($_POST['Pcode'])) echo $_POST['Pcode']; ?>">
                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>

                                    <label data-error="wrong" data-success="right" for="modalLRInput12">Contact
                                        Number</label>
                                    <input type="text"
                                           id="modalLRInput12"
                                           class="form-control form-control-sm validate"
                                           name="Pnum"
                                           required size="20"
                                           value="<?php if (isset($_POST['Pnum'])) echo $_POST['Pnum']; ?>">
                                </div>


                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-lock prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput13">Password</label>
                                    <input type="password" id="modalLRInput13"
                                           class="form-control form-control-sm validate"
                                           name="pass1"
                                           required size="20"
                                           value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>">
                                </div>

                                <div class="md-form form-sm mb-4">
                                    <i class="fas fa-lock prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput14">Repeat
                                        password</label>
                                    <input type="password" id="modalLRInput14"
                                           class="form-control form-control-sm validate"
                                           name="pass2"
                                           required size="20"
                                           value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>">
                                </div>


                                <div class="text-center form-sm mt-2">
                                    <button class="btn btn-info">Sign up <i class="fas fa-sign-in ml-1"></i></button>
                                </div>

                            </div>
                            <!--Footer-->
                            <div class="modal-footer">
                                <div class="options text-right">
                                    <p class="pt-2">Already have an account? <a href="#" class="blue-text">Log In</a>
                                    </p>
                                </div>

                            </div>
                        </div>
                        <!--/.Panel 8-->
                    </div>

                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!--Modal: Login / Register Form-->
</form>

<div class="text-center">
    <a class="btn btn-flat btn-sm" data-toggle="modal" data-target="#modalLRForm"><i class="fas fa-sign-in-alt"></i>
        LogIn/Register</a>
</div>