<?php
include_once dirname(__DIR__).'/required/config.php';
function generateAccount(){
    global $db;
    session_start();
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $solargen='50147';
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
            <div class="card justify-content-center">
            
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
                            
                            <div class="col-md" style="margin-left: 50px">
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
                                <strong>$energy_cost&ensp;</strong><!--TODO make updateabul-->
                            </div>
                        </div>
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Monthly Budget:</strong>
                            </div>
                            <div class="col-sm" style="margin-left: 30px">
                                <strong>$budget&ensp;</strong><!--TODO make updateabul-->
                            </div>
                        </div>
                        
                        <div class="row account-row">
                            <div class="col-md">
                                <strong>&ensp;Solar Panel Rating:</strong>
                            </div>
                            <div class="col-sm" style="margin-left: 30px">
                                <strong>$solargen&ensp;</strong><!--TODO make updateabul-->
                            </div>
                        </div>
                    
                        <div class="row" style="margin-bottom: 50px">
                        <!--button for deploying models-->
                            <div class="col-md">
                                <button type="button" class="btn-sm btn-primary  btn-rounded" data-toggle="modal" data-target="#updateAccountModal">Update Account</button>
                            </div>
                            <div class="col-md">
                                <button type="button" class="btn-sm btn-danger  btn-rounded" data-toggle="modal" data-target="#removeAccountModal">Delete Account</button>
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
                                        <strong> Warring:   This will completely delete your account and can't be undone!</strong>
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
                                        <strong> Warring:   This will completely delete your account and can't be undone!</strong>
                                    </div>
                                    <div class="modal-footer justify-content-lg-between">
                                        <button class="btn btn-danger btn-sm btn-rounded" >Yes: delete account</button>
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-dismiss="modal" >No: go back.</button>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        <!--Model deployed by update account button-->
                        <div class="modal fade" id="updateAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <!-- Dialog -->
                            <div class="modal-dialog modal-lg" role="document">
                            <!--Header-->
                           
                                <!-- Content -->
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h3 class="bold-title">Update Account</h3>
                                    </div>                                
                                    <div class="col-lg">
                                    <!--Body-->
                                    <div class="row" style="margin: 0; padding-top: 5px; padding-bottom: 5px">
                                        <div class="col-md">
                                            <h4>Account details</h4>
                                        </div>
                                        
                                        <div class="col-md">
                                            <h4>New details</h4>
                                        </div>
                                    </div>
                                    
                                     <!--First Name-->  
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>&ensp;First Name: $first_name&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$first_name">
                                                </div>
                                        </div>
                                        
                                        <!--Last Name-->
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>&ensp;Last Name: $last_name&ensp;</strong>
                                            </div>
                                            <div class="col-md"">
                                                <input class="form-control" type="text" placeholder="$last_name">
                                            </div>
                                        </div>
                                        
                                        <!--E-mail-->
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>&ensp;Email Address: $email&ensp;</strong><!--todo fix md size alinment issue-->
                                            </div>
                                            <div class="col-md">
                                                <input class="form-control" type="text" placeholder="$email">
                                            </div>
                                        </div>
                                        
                                        <!--Address-->
                                        <div class="row" style="margin-left: 0; padding-top: 5px; padding-bottom: 5px">

                                                <div class="col-md">
                                                    <div class="row" >
                                                        <strong>&ensp;Address:</strong>  
                                                    </div>
                                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                                        <div class="col-md">
                                                            <strong>$address_l1</strong>
                                                        </div>
                                                        <div class="col-md" style="margin-left: -2%;">
                                                            <input class="form-control" type="text" placeholder="$address_l1">
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="row" style=" padding-top: 5px; padding-bottom: 5px">
                                                        <div class="col-md">
                                                            <strong>$address_l2</strong>
                                                        </div>
                                                        <div class="col-md" style="margin-left: -2%;">
                                                            <input class="form-control" type="text" placeholder="$address_l2">
                                                        </div> 
                                                    </div>
                                                    
                                                </div>
                                    
                      
                                        </div>

                                        <!--Postcode-->
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>&ensp;Postcode:$postcode&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$postcode">
                                                </div>
                                        </div>
                                         <!--Energy Cost -->     
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>&ensp;Energy Price: $energy_cost&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$energy_cost">
                                                </div>
                                        </div>
                                        <!--Budget -->     
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>&ensp;Monthly Budget: $budget&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$budget">
                                                </div>
                                        </div>
                                        
                                        <!--Soler Rateing --> 
                                        <div class="row" style="padding-top: 5px; padding-bottom: 5px">
                                            <div class="col-md">
                                                <strong>&ensp;Soler rating: $solargen Watts per hour&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$solargen">
                                                </div>
                                        </div>
                                        <!--Model footer-->    
                                        <div class="modal-footer justify-content-lg-between" style="margin 50px">
                                            <div class="col-md">
                                                  <button class="btn btn-danger btn-sm btn-rounded" data-dismiss="modal" >Cancel</button>
                                        
                                            </div>
                                                <div class="col-md">
                                                    <button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="" >Update</button>
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
