<?php
include_once dirname(__DIR__).'/required/config.php';
function generateAccount(){
    global $db;
    session_start();
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $solargen='320';
        session_write_close();
        $stmt = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            extract($result->fetch_assoc());
        
            $html = <<<html
        <!-- Page Content --> 
        <div class="container justify-content-center">
        
            <!-- Card --> 
            <div class="card justify-content-center" style="border:none!important">
            
                <!-- Card content: account details -->
                <div class="col-md justify-content-center">
                    <!--Main Col-->
                    <h4 class="bold-title">My Account</h4>
                    
              
                        <div class="row account-row ">
                            <div class="col-md">
                                <strong>&ensp;First Name:</strong>
                            </div>
                            <div class="col-md" style="margin-left: 30px">
                                <strong>$first_name&ensp;</strong>
                            </div>
                        </div>
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Last Name:</strong>
                            </div>
                            <div class="col-md" style="margin-left: 30px">
                                <strong>$last_name&ensp;</strong>
                            </div>
                        </div>
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Email Address:</strong>
                            </div>
                            <div class="col-md " style="margin-left: 30px">
                                <strong>$email&ensp;</strong>
                            </div>
                        </div>
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Address:</strong>
                            </div>
                            
                            <div class="col-md" style="margin-left: 30px">
                                <div class="flex-md-row">
                                    <strong>$address_l1&ensp;</strong>
                                </div>
                                
                                <div class="flex-md-row">
                                    <strong>$address_l2&ensp;</strong>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Postcode:</strong>
                            </div>
                            <div class="col-md" style="margin-left: 30px">
                                <strong>$postcode&ensp;</strong>
                            </div>
                        </div>
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Energy Price:</strong>
                            </div>
                            <div class="col-md" style="margin-left: 30px">
                                <strong>£$energy_cost&ensp;</strong><!--TODO make updateabul-->
                            </div>
                        </div>
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Monthly Budget:</strong>
                            </div>
                            <div class="col-sm" style="margin-left: 30px">
                                <strong>£$budget&ensp;</strong><!--TODO make updateabul-->
                            </div>
                        </div>
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Solar Panel Rating:</strong>
                            </div>
                            <div class="col-sm" style="margin-left: 30px">
                                <strong>$solargen Watts per hour&ensp;</strong><!--TODO make updateabul-->
                            </div>
                        </div>
                    
                        <div class="row" style="margin-bottom: 20px;margin-top: 20px;">
                        <!--button for deploying models-->
                            <div class="col-md">
                                <button type="button" class="btn btn-primary  btn-rounded" data-toggle="modal" data-target="#updateAccountModal">Update Account</button>
                            </div>
                            <div class="col-md">
                                <button type="button" class="btn btn-danger  btn-rounded" data-toggle="modal" data-target="#removeAccountModal">Delete Account</button>
                            </div>
                        </div>
                                            
              
                    <!--Main Col-->
                </div>

                    
                    
                        <!--Model deployed by Delete account button-->
                        <div class="modal fade" id="removeAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <!-- Dialog -->
                            <div class="modal-dialog" role="document">
                                <!-- Content -->
                                <div class="modal-content">
                                
                                    <!--Header-->
                                    <div class="modal-header">
                                        <h3>Are You sure?</h3>
                                    </div>
                                    <!--Body-->
                                    <div class="modal-body">
                                        <strong> Warning:   This will completely delete your account and can't be undone!</strong>
                                    </div>
                                    <div class="modal-footer justify-content-lg-between">
                                        <button class="btn btn-danger btn-sm btn-rounded" onclick="deleteAccount()">Yes: delete account</button>
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-dismiss="modal" >No: go back.</button>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                                                <!--Model deployed by Delete account button-->
                        <div class="modal fade" id="removeAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <!-- Dialog -->
                            <div class="modal-dialog" role="document">
                                <!-- Content -->
                                <div class="modal-content">
                                
                                    <!--Header-->
                                    <div class="modal-header">
                                        <h3>Are You sure?</h3>
                                    </div>
                                    <!--Body-->
                                    <div class="modal-body">
                                        <strong> Warning:   This will completely delete your account and can't be undone!</strong>
                                    </div>
                                    <div class="modal-footer justify-content-lg-between">
                                        <button class="btn btn-danger btn-sm btn-rounded" >Yes: delete account</button>
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-dismiss="modal" >No: go back.</button>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        <!--Model deployed by update account button-->
                        <div class="modal fade modalStatsWrap" id="updateAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <!-- Dialog -->
                            <div class="modal-dialog modal-lg" role="document">
                            <!--Header-->
                           
                                <!-- Content -->
                                <div class="modal-content ">
                                    <div class="modalHeader">
                                        <h3 class="bold-title">Update Account</h3>
                                    </div>                                
                                    <div class="col-lg" style="padding-left:15px!important;padding-right:15px!important;">
                                    <!--Body-->
                                    
                                     <!--First Name-->  
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>First Name:&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input id="ud1" class="form-control" type="text" placeholder="$first_name">
                                                </div>
                                        </div>
                                        
                                        <!--Last Name-->
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>Last Name:&ensp;</strong>
                                            </div>
                                            <div class="col-md"">
                                                <input id="ud2" class="form-control" type="text" placeholder="$last_name">
                                            </div>
                                        </div>
                                        
                                        <!--E-mail-->
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>Email Address:&ensp;</strong><!--todo fix md size alinment issue-->
                                            </div>
                                            <div class="col-md">
                                                <input id="ud3" class="form-control" type="text" placeholder="$email">
                                            </div>
                                        </div>
                                        
                                        <!--Address-->

                                                
                                                <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                                    <div class="col-md">
                                                        <strong>Address:</strong>  
                                                    </div>

                                                    <div class="col-md">
                                                        <input id="ud4" class="form-control" type="text" placeholder="$address_l1">
                                                    </div>
                                                </div>
                                                    
                                                <div class="row" style=" padding-top: 5px; padding-bottom: 5px">
                                                    <div class="col-md">
                                                        <strong></strong>
                                                    </div>
                                                    <div class="col-md">
                                                        <input id="ud5" class="form-control" type="text" placeholder="$address_l2">
                                                    </div> 
                                                </div>
                                    
                      

                                        <!--Postcode-->
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>Postcode:&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input id="ud6" class="form-control" type="text" placeholder="$postcode">
                                                </div>
                                        </div>
                                         <!--Energy Cost -->     
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>Energy Price:&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <select id="ud7" class="form-control form-control-sm dropdown validate drop-up">
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
                                                </div>
                                        </div>
                                        <!--Budget -->     
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>Monthly Budget:&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input id="ud8" class="form-control" type="number" placeholder="$budget">
                                                </div>
                                        </div>
                                        
                                        <!--Soler Rateing --> 
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>Solar rating:&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input id="ud9" class="form-control" type="number" placeholder="$solargen">
                                                </div>
                                        </div>
                                        <!--Model footer-->    
                                        <div class="modal-footer justify-content-lg-between" style="border:none!important">
                                            <div class="col-md">
                                                  <button class="btn btn-danger btn-sm btn-rounded" data-dismiss="modal" >Cancel</button>
                                        
                                            </div>
                                                <div class="col-md">
                                                    <button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="updateAccount($user_id,'ud1','ud2','ud3','ud4','ud5','ud6','ud7','ud8','ud9')" >Update</button>
                                                </div>
                                        </div>
                                                            
                                </div>
                                
                            </div>
                        </div>
                    <!--col om to center content-->
                        </div>
                <!-- modle End--> 
           
                   
            
            <!--Card with Editable table -->

        </div>
    </div>
html;
        }
        $stmt->close();
    }
    session_write_close();

    return $html;

}
?>
