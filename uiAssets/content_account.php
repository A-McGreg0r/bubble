<?php
include_once dirname(__DIR__).'/required/config.php';
function generateAccount(){
    global $db;
    session_start();
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];

        session_write_close();
        $stmt = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            extract($result->fetch_assoc());

            $html = <<<html
        <div class="container-fluid justify-content-center text-dark">
        <!-- Card --> 
            <div class="card">
            
            <!-- Card Title-->
            <h4 class="card-title mb-0 mt-3">
                <strong>My Account</strong>
            </h4>
            
            <!-- Card content -->
                <div class="card-body">
                    <!--Email-->
                    <div class="row-md-12">
                        <p class="h6">Email: $email</p> 
                    </div>
                    <!--Name Details-->
                    <div class="row-md-12">
                        <div class="col-md-6">
                            <p class="h6">First Name: $first_name  </p>    
                        </div>
                        
                        <div class="col-md-6">
                            <p class="h6"> First Name: $last_name  </p> 
                        </div>
                    </div>  
                        
                    <!--Address details-->
                    <div class="row-md-12">
                        <div class="col-md-6">
                            <p class="h6">Address:  $address_l1 $address_l2   </p>    
                        </div>
                        
                        <div class="col-md-6">
                            <p class="h6"> Postcode: $postcode  </p> 
                        </div>
                    </div>  

                    <!--Button to delete account  will change to have conformation-->          
                    <button class="btn btn-danger btn-rounded" onclick="deleteAccount()">Delete my account</button>
                    
                </div>
                
            </div>
            <!-- Card -->    
    
    
            <!-- Editable table -->
            <div class="card">
                <h3 class="card-header text-center font-weight-bold text-uppercase py-4 text-dark">Devices</h3>
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
                while($row = $result1->fetch_assoc()) {
                    $hub_id = $row['hub_id'];
                    $stmt2 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
                    $stmt2->bind_param("i", $hub_id);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    //SELECT ALL DEVICES FROM HUB_ID
                    if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) {
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

                            $stmt4 = $db->prepare("SELECT * FROM room_info WHERE room_id = ?");
                            $stmt4->bind_param("i", $device_room);
                            $stmt4->execute();
                            $result4 = $stmt4->get_result();
                            $row4 = $result4->fetch_assoc();
                            $roomName = $row4['room_name'];

                            $html .= <<<device
                                <tr>
                                    <td class="pt-3-half">$icon $device_name</td>
                                    <td class="pt-3-half">8w</td>
                                    <td class="pt-3-half">
                                    <select class="deviceLocation browser-default custom-select dropdown">
                                        <option value="0" disabled selected>Current: $roomName</option>

device;
                                        $stmt5 = $db->prepare("SELECT * FROM room_info WHERE hub_id = ?");
                                        $stmt5->bind_param("i", $hub_id);
                                        $stmt5->execute();
                                        $result5 = $stmt5->get_result();
                                        while($row5 = $result5->fetch_assoc()) {
                                            $val = $row5['room_name'];
                                            $inc = $row5['room_id'];

                                            $html .= "<option value=\"$inc.$device_id\">Move to: $val</option>";
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
        ';
        }

        $stmt->close();

    }

    return $html;

}
?>
