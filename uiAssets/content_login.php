<?php
function generateLoginPage(){
    $email = '';
    if (isset($_POST['email'])) $email = $_POST['email'];
    $first_name = '';
    if (isset($_POST['first_name'])) $first_name = $_POST['first_name'];
    $last_name = '';
    if (isset($_POST['last_name'])) $last_name = $_POST['last_name'];
    $address_l1 = '';
    if (isset($_POST['address_l1'])) $address_l1 = $_POST['address_l1'];
    $address_l2 = '';
    if (isset($_POST['address_l2'])) $address_l2 = $_POST['address_l2'];
    $postcode = '';
    if (isset($_POST['postcode'])) $postcode = $_POST['postcode'];
    
    $html = <<<htmlPage
    <!--Modal cascading tabs-->
    <div class="col-12 col-md-auto">
        <table style="height: 100vh;">
            <tr>
                <td class="align-middle text-centre">
                    <div class="text-center">
                        <h2>Welcome to Bubble.</h2>
                        <h2>The simple smart home.</h2>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  tabs-2 elegant-color align-content-around" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">
                                <i class="fas fa-user mr-1"></i>Login
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">
                                <i class="fas fa-user-plus mr-1"></i>Sign up
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="tab" href="#panel3" role="tab">
                                <i class="fas fa-user-plus mr-1"></i>Forgot Password
                            </a>
                        </li>
                    </ul>


                    <!-- Tab panels -->
                    <div class="tab-content ">
                        <!--Panel 1 login Tab panel -->
                        <div class="tab-pane fade in show active" id="panel1" role="tabpanel">

                            <!--Body-->
                            <div class="modal-body mb-1">

                                <!-- Form -->
                                <form class="text-center elegant-color-dark " action="required/action_login.php" method="POST">

                                    <!-- Email -->
                                    <div class="md-form">
                                        <label for="materialLoginFormEmail">E-mail</label>
                                        <input type="email"
                                            id="materialLoginFormEmail"
                                            class="form-control form-control-sm validate"
                                            name="email"
                                            required size="20"
                                            value="$email"/>
                                    </div>

                                    <!-- Password -->
                                    <div class="md-form">
                                        <label for="materialLoginFormPassword">Password</label>
                                        <input type="password" id="materialLoginFormPassword" class="form-control" name="password"/>
                                    </div>

                                    <div class="d-flex justify-content-around">
                                        <div>
                                            <!-- Remember me -->
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="materialLoginFormRemember"/>
                                                <label class="form-check-label" for="materialLoginFormRemember">Remember me</label>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="">Forgot password?</a>
                                        </div>
                                    </div>

                                    <!-- Sign in button -->
                                    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" value="submit">Log in</button>

                                    
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
                            </div>
                        </div>
                        <!--Panel 1 login Tab -->


                        <!--Panel 2 register-->
                        <div class="tab-pane fade" id="panel2" role="tabpanel">

                            <!--Body-->
                            <!--Card content-->
                            <div class="card-body px-lg-5 pt-0">

                                <!-- Form -->
                                <form class="text-center" style="color: #757575;" action="required/action_register.php" method="POST">
                                    <!-- Email -->
                                    <div class="md-form">
                                        <label for="materialLoginFormEmail">E-mail</label>
                                        <input type="email"
                                            id="materialLoginFormEmail"
                                            class="form-control form-control-sm validate"
                                            name="email"
                                            required size="20"
                                            value="$email"/>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-sm form-sm mb-5">
                                            <!-- First name -->
                                            <div class="md-form">
                                                <label for="materialRegisterFormFirstName">First name</label>
                                                <input type="text"
                                                    id="materialRegisterFormFirstName"
                                                    class="form-control form-control-sm validate"
                                                    name="first_name"
                                                    required size="20"
                                                    value="$first_name"/>
                                            </div>
                                        </div>
                                        <div class="col-sm form-sm mb-5">
                                            <!-- Last name -->
                                            <div class="md-form">
                                                <label for="materialRegisterFormLastName">Last name</label>
                                                <input type="text"
                                                    id="materialRegisterFormLastName"
                                                    class="form-control form-control-sm validate"
                                                    name="last_name"
                                                    required size="20"
                                                    value="$last_name"/>
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
                                            value="$address_l1"/>
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
                                            value="$address_l2"/>
                                    </div>

                                    <div class="md-form">
                                        <label for="materialRegisterFormPostcode">Postcode</label>
                                        <input type="text"
                                            id="materialRegisterFormPostcode"
                                            class="form-control form-control-sm validate"
                                            name="postcode"
                                            required size="20"
                                            aria-describedby=""
                                            value="$postcode"/>
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
                                            size="20" type="password"/>
                                        <small id="materialRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                                            At least 8 characters and 1 digit
                                        </small>
                                    </div>

                                    <div class="md-form">
                                        <label data-error="wrong" data-success="right" for="materialRegisterFormPassword2">Confirm password</label>
                                        <input type="password"
                                            id="materialRegisterFormPassword2"
                                            class="form-control form-control-sm validate"
                                            aria-describedby="materialRegisterFormPasswordHelpBlock"
                                            name="pass2"
                                            required size="20"/>
                                    </div>


                                    <!-- Sign up button -->
                                    <div>
                                        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" value="submit">Sign up</button>
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
                                    <p>By clicking <em>Sign up</em> you agree to our <a href="" target="_blank">terms of service</a></p>

                                </form>
                                <!-- Form -->
                            </div>
                        </div>
                        <!--Panel 3 Forgot Password Tab panel -->
                        <div class="tab-pane fade in show" id="panel3" role="tabpanel">

                            <!--Body-->
                            <div class="modal-body mb-1">

                                <!-- Form -->
                                <form class="text-center elegant-color-dark " action="required/action_forgotPassword.php" method="POST">

                                    <!-- Email -->
                                    <div class="md-form">
                                        <label for="materialLoginFormEmail">E-mail</label>
                                        <input type="email"
                                            id="materialLoginFormEmail"
                                            class="form-control form-control-sm validate"
                                            name="email"
                                            required size="20"
                                            value="$email"/>
                                    </div>

                                    <!-- Sign in button -->
                                    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" value="submit">Submit</button>

                                </form>
                            </div>
                        </div>
                        <!--Panel 3 Forgot Password Tab -->
                    </div>
                </td>
            </tr>
        </table>
    </div>
htmlPage;
    return $html;
}
?>