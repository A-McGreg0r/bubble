
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!--icon Change me-->
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!--Scripts-->
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/js/mdb.min.js"></script>
    <!--Scripts-->

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="css/mdb.min.css" type="text/css"/>
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <title>stuff</title>
</head>

<body class="black-skin elegant-color-dark ">


<!--Content-->
<div class="container-fluid  text-light">

    <!--Modal cascading tabs-->
    <div class="col col-lg-2">

    </div>

    <div class="col-12 col-md-auto">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs  tabs-2 elegant-color align-content-around" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">
                    <i class="fas fa-user mr-1"></i>Login</a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">
                    <i class="fas fa-user-plus mr-1"></i>Sign up</a>
            </li>
        </ul>
        <!-- Nav tabs -->


        <!-- Tab panels -->
        <div class="tab-content ">
            <!--Panel 1 login Tab panel -->
            <div class="tab-pane fade in show active" id="panel1" role="tabpanel">

                <!--Body-->
                <div class="modal-body mb-1">
                    <!--modal-login-->
                    <!-- Material form login -->
                    <!--Card content-->

                    <!-- Form -->
                    <form class="text-center elegant-color-dark " action="required/loginAction.php" method="POST">

                        <!-- Email -->
                        <div class="md-form">
                            <label for="materialLoginFormEmail">E-mail</label>
                            <input type="email"
                                   id="materialLoginFormEmail"
                                   class="form-control form-control-sm validate"
                                   name="email"
                                   required size="20"
                                   value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                        </div>

                        <!-- Password -->
                        <div class="md-form">
                            <input type="password" id="materialLoginFormPassword"
                                   class="form-control">
                            <label for="materialLoginFormPassword">Password</label>
                        </div>

                        <div class="d-flex justify-content-around">
                            <div>
                                <!-- Remember me -->
                                <div class="form-check">
                                    <label class="form-check-label" for="materialLoginFormRemember">Remember me</label>
                                    <input type="checkbox"
                                           class="form-check-input"
                                           id="materialLoginFormRemember">
                                </div>
                            </div>
                            <div>
                                <!-- Forgot password -->
                                <a href="">Forgot password?</a>
                            </div>
                        </div>

                        <!-- Sign in button -->
                        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
                                type="submit" value="submit">Log in
                        </button>


                        <!-- Social login -->
                        <p>or sign in with:</p>
                        <a type="button" class="btn-floating btn-fb btn-sm">
                            <i class="fab fa-facebook-f white-text disabled"></i>
                        </a>
                        <a type="button" class="btn-floating btn-tw btn-sm">
                            <i class="fab fa-twitter white-text disabled"></i>
                        </a>
                        <a type="button" class="btn-floating btn-li btn-sm">
                            <i class="fab fa-linkedin-in white-text disabled"></i>
                        </a>
                        <a type="button" class="btn-floating btn-git btn-sm">
                            <i class="fab fa-github white-text disabled"></i>
                        </a>
                        <!--t-->
                        <a type="button" href="appCore.php" class="btn-floating btn-git btn-sm text-light">
                            <i class="far fa-arrow-alt-circle-right"></i>
                        </a>


                    </form>
                    <!-- Form -->

                    <!-- Material form login -->
                </div>
                <!--modal-footer-->
            </div>
            <!--Panel 1 login Tab -->


            <!--Panel 2 register-->
            <div class="tab-pane fade" id="panel2" role="tabpanel">

                <!--Body-->
                <!--Card content-->
                <div class="card-body px-lg-5 pt-0">

                    <!-- Form -->
                    <form class="text-center" style="color: #757575;" action="required/regScript.php" method="POST">

                        <!-- username -->
                        <div class="md-form form-sm mb-5">
                            <label data-error="wrong" data-success="right"
                                   for="materialLoginFormUsername">Username</label>
                            <input type="text"
                                   id="materialLoginFormUsername"
                                   class="form-control form-control-sm validate"
                                   name="username"
                                   required size="20"
                                   value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
                        </div>

                        <!-- Email -->
                        <div class="md-form">
                            <label for="materialLoginFormEmail">E-mail</label>
                            <input type="email"
                                   id="materialLoginFormEmail"
                                   class="form-control form-control-sm validate"
                                   name="email"
                                   required size="20"
                                   value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                        </div>

                        <div class="form-row">
                            <div class="col-sm">
                                <!-- First name -->
                                <div class="md-form form-sm mb-5">
                                    <label for="materialRegisterFormFirstName">First name</label>
                                    <input type="text"
                                           id="materialRegisterFormFirstName"
                                           class="form-control form-control-sm validate"
                                           name="first_name"
                                           required size="20"
                                           value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>">
                                </div>
                            </div>
                            <div class="col-sm form-sm mb-5">
                                <!-- Last name -->
                                <div class="md-form">
                                    <input type="text"
                                           id="materialRegisterFormLastName"
                                           class="form-control form-control-sm validate"
                                           name="surname"
                                           required size="20"
                                           value="<?php if (isset($_POST['surname'])) echo $_POST['surname']; ?>">
                                    <label for="materialRegisterFormLastName">Last name</label>
                                </div>
                            </div>
                        </div>


                        <!-- Address line 1 -->
                        <div class="md-form">
                            <label for="materialRegisterFormAddress_l1">Address line 1</label>
                            <input type="text"
                                   id="materialRegisterFormAddress_l1"
                                   class="form-control form-control-sm validate"
                                   name="address_l1"
                                   required size="20"
                                   aria-describedby="materialRegisterFormPasswordHelpBlock"
                                   value="<?php if (isset($_POST['address_l1'])) echo $_POST['address_l1']; ?>"
                        </div>

                        <!-- Address line 2 -->
                        <div class="md-form">
                            <label for="materialRegisterFormAddress_l2">Address line 2</label>
                            <input type="text"
                                   id="materialRegisterFormAddress_l2"
                                   class="form-control form-control-sm validate"
                                   name="address_l2"
                                   required size="20"
                                   aria-describedby=""
                                   value="<?php if (isset($_POST['address_l2'])) echo $_POST['address_l2']; ?>"
                        </div>

                        <div class="md-form">
                            <label for="materialRegisterFormPostcode">Postcode</label>
                            <input type="text"
                                   id="materialRegisterFormPostcode"
                                   class="form-control form-control-sm validate"
                                   name="postcode"
                                   required size="20"
                                   aria-describedby=""
                                   value="<?php if (isset($_POST['postcode'])) echo $_POST['postcode']; ?>"
                        </div>

                        <!-- Password -->
                        <div class="md-form">
                            <label data-error="wrong" data-success="right"
                                   for="materialRegisterFormPassword1">Password</label>
                            <input aria-describedby="materialRegisterFormPasswordHelpBlock"
                                   class="form-control form-control-sm validate"
                                   id="materialRegisterFormPassword1"
                                   name="pass1"
                                   required
                                   size="20" type="password"
                                   value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>">
                            <small id="materialRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                                At least 8 characters and 1 digit
                            </small>
                        </div>

                        <div class="md-form">
                            <label data-error="wrong" data-success="right"
                                   for="materialRegisterFormPassword2">Repet Password</label>
                            <input type="password"
                                   id="materialRegisterFormPassword2"
                                   class="form-control form-control-sm validate"
                                   aria-describedby="materialRegisterFormPasswordHelpBlock"
                                   name="pass2"
                                   required size="20"
                                   value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>">
                        </div>


                        <!-- Sign up button -->
                        <div>
                            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
                                    type="submit" value="submit">Sign up
                            </button>
                        </div>


                        <!-- Social register -->
                        <p>or sign up with:</p>
                        <a type="button" class="btn-floating btn-fb btn-sm">
                            <i class="fab fa-facebook-f white-text disabled"></i>
                        </a>
                        <a type="button" class="btn-floating btn-tw btn-sm">
                            <i class="fab fa-twitter white-text disabled"></i>
                        </a>
                        <a type="button" class="btn-floating btn-li btn-sm">
                            <i class="fab fa-linkedin-in white-text disabled"></i>
                        </a>
                        <a type="button" class="btn-floating btn-git btn-sm">
                            <i class="fab fa-github white-text disabled"></i>
                        </a>
                        <hr>

                        <!-- Terms of service -->
                        <p>By clicking
                            <em>Sign up</em> you agree to our
                            <a href="" target="_blank">terms of service</a>

                    </form>
                    <!-- Form -->
                </div>

                <!-- Material form register -->
            </div>
        </div>


        <!--Panel 2 register-->
    </div>
    <div class="col col-lg-2">

    </div>
</body>
<!--Modal: Login / Register Form-->


