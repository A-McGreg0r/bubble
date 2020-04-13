<?php

echo shell_exec("/../email/myemail.py");


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
    $energy_cost = 0;
    if (isset($_POST['energy_cost'])) $energy_cost = $_POST['energy_cost'];
    $budget = '';
    if (isset($_POST['budget'])) $budget = $_POST['budget'];
    $allow_emails = '';
    if (isset($_POST['allow_emails'])) $allow_emails = $_POST['allow_emails'];

    $html = <<<htmlPage
    <!--Modal cascading tabs-->
    <div class="container justify-content-center text-centre text-light max-width:80%">
        <table style="width:100%;" >
            <tr>
                <td class="align-middle">
                    <div class="text-center">
                        <img class="front-img" src="img/favicon.png">
                        <h2>Bubble.</h2>
                        <h4>The simple smart home.</h4>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  tabs-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link login-links active" data-toggle="tab" href="#panel1" role="tab">
                                <i class="fas fa-user mr-1"></i><br>Login
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link login-links" data-toggle="tab" href="#panel2" role="tab">
                                <i class="fas fa-user-plus mr-1"></i><br>Sign up
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link login-links" data-toggle="tab" href="#panel3" role="tab">
                                <i class="fas fa-user-plus mr-1"></i><br>Reset
                            </a>
                        </li>
                    </ul>


                    <!-- Tab panels -->
                    <div class="tab-content ">
                        <!--Panel 1 login Tab panel -->
                        <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
                        <div class="text-center">
                            <h5 id="loginErrorDisplay"></h5>
                        </div>
                            <!--Body-->
                            <div class="modal-body mb-1">

                                <!-- Form -->

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
                                    </div>

                                    <!-- Sign in button -->
                                    <button id="login_button" onclick="sendLoginRequest()" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" value="submit">Log in</button>

                            </div>
                        </div>
                        <!--Panel 1 login Tab -->


                        <!--Panel 2 register-->
                        <div class="tab-pane fade" id="panel2" role="tabpanel">

                            <!--Body-->
                            <!--Card content-->
                            <div class="card-body px-lg-5 pt-0">

                                <!-- Form -->
                                <form class="text-center" style="color: rgb(39,104,88);" action="required/action_register.php" method="POST">
                                    <!-- Email -->
                                    <div class="md-form">
                                        <label for="materialLoginFormEmail">E-mail</label>
                                        <input type="email"
                                            id="materialLoginFormEmail"
                                            class="form-control form-control-sm validate hold-back"
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
                                            <div class="md-form drop-off">
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
                                            class="form-control form-control-sm validate drop-off"
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
                                            class="form-control form-control-sm validate drop-up"
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
                                            class="form-control form-control-sm validate drop-off"
                                            aria-describedby="materialRegisterFormPasswordHelpBlock"
                                            name="pass2"
                                            required size="20"/>
                                    </div>

                                    <!-- Energy Cost -->
                                    <div class="md-form">
                                        <select name="energy_cost" class="form-control form-control-sm dropdown validate drop-up">
                                            <option value="" disabled selected>Select energy price per kWh</option>
                                            <option value="0.01">£0.01</option>
                                            <option value="0.02">£0.02</option>
                                            <option value="0.03">£0.03</option>
                                            <option value="0.04">£0.04</option>
                                            <option value="0.05">£0.05</option>
                                            <option value="0.06">£0.06</option>
                                            <option value="0.07">£0.07</option>
                                            <option value="0.08">£0.08</option>
                                            <option value="0.09">£0.09</option>
                                            <option value="0.10">£0.10</option>
                                            <option value="0.11">£0.11</option>
                                            <option value="0.12">£0.12</option>
                                            <option value="0.13">£0.13</option>
                                            <option value="0.14">£0.14</option>
                                            <option value="0.15">£0.15</option>
                                            <option value="0.16">£0.16</option>
                                            <option value="0.17">£0.17</option>
                                            <option value="0.18">£0.18</option>
                                            <option value="0.19">£0.19</option>
                                            <option value="0.20">£0.20</option>
                                            <option value="0.21">£0.21</option>
                                            <option value="0.22">£0.22</option>
                                            <option value="0.23">£0.23</option>
                                            <option value="0.24">£0.24</option>
                                            <option value="0.25">£0.25</option>
                                            <option value="0.26">£0.26</option>
                                            <option value="0.27">£0.27</option>
                                            <option value="0.28">£0.28</option>
                                            <option value="0.29">£0.29</option>
                                            <option value="0.30">£0.30</option>
                                        </select>

                                        <small class="form-text text-muted mb-4">
                                            If you are unsure about your energy cost, please select £0.15 for the average UK price
                                        </small>
                                    </div>

                                    <div class="md-form">
                                    <span class="budget-input"> <p style="margin-top:8px">£</p>
                                        <label data-error="wrong" data-success="right" for="budget">Please enter your monthly budget</label>
                                        <input type="number"
                                            id="budget"
                                            class="form-control form-control-sm validate drop-up"
                                            aria-describedby=""
                                            name="budget"
                                            required size="20"
                                            value="$budget"/>
                                        </span>
                                        <small class="form-text text-muted mb-4">
                                            If you are unsure about your budget, please select £58 for the average UK budget
                                        </small>
                                    </div>

                                    <div class="md-form">
                                        <small class="form-text text-muted mb-4"><input type="checkbox" checked="checked" name="allow_emails" value="Yes"/>&nbsp;I would like to receive email updates tailored to me</small>
                                    </div>

                                    <!-- Sign up button -->
                                    <div>
                                        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" value="submit">Sign up</button>
                                    </div>


                                    <!-- Social login -->
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <p>By clicking <em> Sign up </em> you agree to our<a href="" target="_blank"> terms of service</a> </p> <!-- Terms of service -->
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                <!-- Form -->
                            </div>
                        </div>
                        <!--Panel 3 Forgot Password Tab panel -->
                        <div class="tab-pane fade" id="panel3" role="tabpanel">

                            <!--Body-->
                            <div class="modal-body mb-1">

                                <!-- Form -->
                                <form class="text-center" style="color: rgb(39,104,88);" action="required/action_forgotPassword.php" method="POST">

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