<?php
//TODO chane sql escap strings to prpared statments
//TODO spell cheack.
//TODO mach the varabuls to there corasoponding one in the database and data dictonory
//TODO mach the varabuls max lenth to the database once that fixed.
//todo get buttons working at the bottom of the page
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
    if (empty($_POST['username'])) {
        $errors[] = 'Enter A username.';
    } else {
        $ur = mysqli_real_escape_string($link, trim($_POST['username']));
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($_POST['email']));
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

    # Check for a first name.
    if (empty($_POST['first_name'])) {
        $errors[] = 'Enter your first name.';
    } else {
        $fn = mysqli_real_escape_string($link, trim($_POST['first_name']));
    }

    # Check for a last name.
    if (empty($_POST['surname'])) {
        $errors[] = 'Enter your surname.';
    } else {
        $ln = mysqli_real_escape_string($link, trim($_POST['surname']));
    }

    # Check for a adress line 1.
    if (empty($_POST['address_l1'])) {
        $errors[] = 'Enter your Address 1';
    } else {
        $A1 = mysqli_real_escape_string($link, trim($_POST['address_l1']));
    }

    # Check for a adress line 2.
    # Check for a adress line 1.
    if (empty($_POST['address_l2'])) {
        $errors[] = 'Enter your Address 2';
    } else {
        $A2 = mysqli_real_escape_string($link, trim($_POST['address_l2']));
    }

    # Check for a postcode
    if (empty($_POST['postcode'])) {
        $errors[] = 'Enter your postcode.';
    } else {
        $Pc = mysqli_real_escape_string($link, trim($_POST['postcode']));
    }



    # Check if email address already registered.
    if (empty($errors)) {
        $q = "SELECT * FROM user_info WHERE email=SHA1('$e')";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0) {
            $errors[] = 'Email address already registered. <a href="index.php">Login</a>';
        }//TODO change it to display a meesege to the user
    }

    # On success register user inserting into 'users' database table.
    if (empty($errors)) {
        // not posting to database
        $q = "INSERT INTO users_info (username,email, pass, first_name, surname,address_l1, address_l2, postcode, reg_date) VALUES ( SHA1('$ur'),SHA1('$e'), SHA1('$p'), SHA1('$fn'), SHA1('$ln'), SHA1('$A1'), SHA1('$A2'), SHA1('$Pc'), NOW() )";
        $r = @mysqli_query($link, $q);
        if ($r) {
            echo '<div class="container"><h1>Registered!</h1><p>You are now registered.</p><p><a href="index.php">Login</a></p>';
        }
        # Close database connection.
        mysqli_close($link);
        echo 'I ran';
        exit();
    } else # Or report errors.
    {//todo redirect with pop up or other way to display info
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
                                    <input type="email"
                                           id="modalLRInput10"
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
                                        Username</label>
                                    <input type="text"
                                           id="modalLRInput12"
                                           class="form-control form-control-sm validate"
                                           name="username"
                                           required size="20"
                                           value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput13">Your
                                        Email</label>
                                    <input type="email"
                                           id="modalLRInput13"
                                           class="form-control form-control-sm validate"
                                           name="email"
                                           required size="20"
                                           value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput14">Your
                                        Name</label>
                                    <input type="text"
                                           id="modalLRInput14"
                                           class="form-control form-control-sm validate"
                                           name="first_name"
                                           required size="20"
                                           value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?> ">
                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput15">Name</label>
                                    <input type="text"
                                           id="modalLRInput15"
                                           class="form-control form-control-sm validate"
                                           name="surname"
                                           required size="20"
                                           value="<?php if (isset($_POST['surname'])) echo $_POST['surname']; ?>">
                                </div>


                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput16">Address
                                        line-1</label>
                                    <input type="text"
                                           id="modalLRInput16"
                                           class="form-control form-control-sm validate"
                                           name="address_l1"
                                           required size="20"
                                           value="<?php if (isset($_POST['address_l1'])) echo $_POST['address_l1']; ?>">
                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput17">Address
                                        line-2</label>
                                    <input type="text"
                                           id="modalLRInput17"
                                           class="form-control form-control-sm validate"
                                           name="address_l2"
                                           required size="20"
                                           value="<?php if (isset($_POST['address_l2'])) echo $_POST['address_l2']; ?>">

                                </div>

                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-envelope prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput18">Postcode</label>
                                    <input type="text"
                                           id="modalLRInput18"
                                           class="form-control form-control-sm validate"
                                           name="postcode"
                                           required size="12"
                                           value="<?php if (isset($_POST['postcode'])) echo $_POST['postcode']; ?>">
                                </div>


                                <div class="md-form form-sm mb-5">
                                    <i class="fas fa-lock prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput19">Password</label>
                                    <input type="password"
                                           id="modalLRInput19"
                                           class="form-control form-control-sm validate"
                                           name="pass1"
                                           required size="20"
                                           value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>">
                                </div>

                                <div class="md-form form-sm mb-4">
                                    <i class="fas fa-lock prefix"></i>
                                    <label data-error="wrong" data-success="right" for="modalLRInput20">Repeat
                                        password</label>
                                    <input type="password"
                                           id="modalLRInput20"
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
                                    <p class="pt-2">Already have an account?<br>
                                        <a href="#" class="blue-text">Log In</a>
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