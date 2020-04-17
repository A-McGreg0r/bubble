<?php
include_once dirname(__DIR__) . '/required/config.php';
function generateAccount()
{
    global $db;
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

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
                        <!--Model deployed by update account button-->
                        <div class="modal fade" id="updateAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <!-- Dialog -->
                            <div class="modal-dialog" role="document">
                            <!--Header-->
                            <div class="modal-header">
                                <h3 class="bold-title">Update Account</h3>
                            </div>
                                <!-- Content -->
                                <div class="modal-content">                                
                                    <div class="col-lg">
                                    <!--Body-->
                                    <div class="col-md">
                                        <h4>Account details</h4>
                                    </div>
                                    
                                    <div class="col-md">
                                        <h4>New details</h4>
                                    </div>
                                     <!--First Name-->  
                                        <div class="row">
                                            <div class="col-md">
                                                <strong>&ensp;First Name: $first_name&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$first_name">
                                                </div>
                                        </div>
                                        <!--Last Name-->
                                        <div class="row">
                                            <div class="col-md">
                                                <strong>&ensp;Last Name: $last_name&ensp;</strong>
                                            </div>
                                            <div class="col-md"">
                                                <input class="form-control" type="text" placeholder="$last_name">
                                            </div>
                                        </div>
                                        <!--E-mail-->
                                        <div class="row">
                                            <div class="col-md">
                                                <strong>&ensp;Email Address: $email&ensp;</strong>
                                            </div>
                                            <div class="col-md">
                                                <input class="form-control" type="text" placeholder="$email">
                                            </div>
                                        </div>
                                        
                                        <!--Address-->
                                        <div class="row">
                                            <div class="col-md">
                                                
                                                    <strong>&ensp;Address:</strong>                             

                                                <div class="row" style="padding-left: 15px">
                                                    <div class="col-md">
                                                        <strong>$address_l1</strong>
                                                    </div>
                                                        <div class="col-md">
                                                            <input class="form-control" type="text" placeholder="$address_l1">
                                                         </div>
                                                </div>
                                                
                                                <div class="row" style="padding-left: 15px">
                                                    <div class="col-md">
                                                        <strong>$address_l2</strong>
                                                    </div>
                                                        <div class="col-md">
                                                            <input class="form-control" type="text" placeholder="$address_l2">
                                                        </div>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <!--Postcode-->
                                        <div class="row">
                                            <div class="col-md">
                                                <strong>&ensp;Postcode:$postcode&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$postcode">
                                                </div>
                                        </div>
                                                
                                        <div class="row ">
                                            <div class="col-md">
                                                <strong>&ensp;Energy Price: $energy_cost&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$energy_cost">
                                                </div>
                                        </div>
                                                
                                        <div class="row ">
                                            <div class="col-md">
                                                <strong>&ensp;Monthly Budget: $budget&ensp;</strong>
                                            </div>
                                                <div class="col-md">
                                                    <input class="form-control" type="text" placeholder="$budget">
                                                </div>
                                        </div>
                                            
                                        <div class="row modal-footer justify-content-lg-between" style="margin 50px">
                                            <div class="col-md">
                                                <button type="button" class="btn-sm btn-primary  btn-rounded" data-toggle="modal" data-target="#updateAccountModal">Update Account</button>
                                            </div>
                                                <div class="col-md">
                                                    <button type="button" class="btn-sm btn-danger  btn-rounded" data-toggle="modal" data-target="#removeAccountModal">Delete Account</button>
                                                </div>
                                        </div>
                                                            
                                </div>
                                
                            </div>
                        </div>
                    <!--col om to center content-->
                        </div>
                        <!-- Card End-->     
              
                 
           
                   
            
            <!--Card with Editable table -->
            <div class="card">
                <h3 class="card-header text-center font-weight-bold text-uppercase py-4 border-upper">Devices</h3>
                <div class="card-body">
                    <div id="table" class="table-editable">
                        <span class="table-add float-right mb-3 mr-2"><a href="index.php?action=adddevice" class=""><i class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
                        <table class="table table-bordered table-responsive-md table-striped text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Device</th>
                                    <th class="text-center">Consumption</th>
                                    <th class="text-center">Room</th>
                                    <th class="text-center">Remove</th>
                                </tr>
                                </thead>
                                <tbody>
html;
            $stmt1 = $db->prepare("SELECT * FROM hub_users WHERE user_id = ?");
            $stmt1->bind_param("i", $user_id);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            //SELECT ALL HUBS FROM USERID
            if ($result1->num_rows > 0) {
                while ($row = $result1->fetch_assoc()) {
                    $hub_id = $row['hub_id'];
                    $stmt2 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
                    $stmt2->bind_param("i", $hub_id);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    //SELECT ALL DEVICES FROM HUB_ID
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $device_id = $row2['device_id'];
                            $device_name = $row2['device_name'];
                            $device_type = $row2['device_type'];
                            $device_room = $row2['room_id'];

                            $stmt3 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                            $stmt3->bind_param("i", $device_type);
                            $stmt3->execute();
                            $result3 = $stmt3->get_result();
                            $row3 = $result3->fetch_assoc();
                            $icon = $row3['type_icon'];
                            $energy_consumption = $row3['energy_usage'];

                            $stmt4 = $db->prepare("SELECT * FROM room_info WHERE room_id = ?");
                            $stmt4->bind_param("i", $device_room);
                            $stmt4->execute();
                            $result4 = $stmt4->get_result();
                            $row4 = $result4->fetch_assoc();
                            $roomName = $row4['room_name'];

                            $html .= <<<device
                                <tr>
                                    <td class="pt-3-half">$icon<br>$device_name</td>
                                    <td class="pt-3-half">$energy_consumption Wh</td>
                                    <td class="pt-3-half">
                                    <select name="moveDevice_$device_id"class="deviceLocation browser-default custom-select dropdown">
                                        <option value="0" disabled selected>Current: $roomName</option>

device;
                            $stmt5 = $db->prepare("SELECT * FROM room_info WHERE hub_id = ?");
                            $stmt5->bind_param("i", $hub_id);
                            $stmt5->execute();
                            $result5 = $stmt5->get_result();
                            while ($row5 = $result5->fetch_assoc()) {
                                $val = $row5['room_name'];
                                $room_id = $row5['room_id'];

                                $html .= "<option value=\"$room_id.$device_id\">Move to: $val</option>";
                            }
                            $html .= <<<pageHTML

                                        </select>
                                    </td>
                                    <td>
                                        <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                                    </td>
                                </tr>   
pageHTML;
                            $stmt3->close();
                            $stmt4->close();

                        }
                    }
                    $stmt2->close();
                }
            }
            $stmt1->close();
            $html .= '    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';

            $html .= '
        <script>
            const $tableID = $("#table");
            const $BTN = $("#export-btn");
            const $EXPORT = $("#export");
    
            $tableID.on("click", ".table-remove", function () {
                $(this).parents("tr").detach();
            });
    
            $tableID.on("click", ".table-up", function () {
    
                const $row = $(this).parents("tr");
    
                if ($row.index() === 1) {
                    return;
                }
    
                $row.prev().before($row.get(0));
            });

            $tableID.on("click", ".deviceLocation", function () {
                var url = "required/action_movedevice.php";
                var dataQuery = $(this).value;
                $.ajax({
                    type:\'POST\',
                    url: url,
                    data:{ data: dataQuery},
                    success:function(data){

                    },
                    error: function(data){

                    }
                });

            });
    
            $tableID.on("click", ".table-down", function () {
    
                const $row = $(this).parents("tr");
                $row.next().after($row.get(0));
            });
    
            // A few jQuery helpers for exporting only
            jQuery.fn.pop = [].pop;
            jQuery.fn.shift = [].shift;
    
            $BTN.on("click", () => {
    
                const $rows = $tableID.find("tr:not(:hidden)");
                const headers = [];
                const data = [];
    
                // Get the headers (add special header logic here)
                $($rows.shift()).find("th:not(:empty)").each(function () {
    
                    headers.push($(this).text().toLowerCase());
                });
    
                // Turn all existing rows into a loopable array
                $rows.each(function () {
                    const $td = $(this).find("td");
                    const h = {};
    
                    // Use the headers from earlier to name our hash keys
                    headers.forEach((header, i) => {
    
                        h[header] = $td.eq(i).text();
                    });
    
                    data.push(h);
                });
    
                // Output the result
                $EXPORT.text(JSON.stringify(data));
            });
        </script>
        </div>
        <!-- Page Content --> 
        ';
        }

        $stmt->close();

    }

    return $html;

}

?>
