<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';



function generateDeviceTab(){
    $html = '';


    $html .= <<<html
        <a href="index.php?action=adddevice">
            <div class="card mb-4 container">
                <!--Card image-->
                <div class="view overlay">
                    <div class="mask rgba-white-slight"></div>
                </div>
        
                <!--Card content-->
                <div class="card-body d-flex justify-content-between">
        
                <!--Title-->      
                    <div class="d-flex flex-column">  
                        <strong>Add new device</strong>
                    </div>
                    
                    <div class="d-flex flex-column">
                        <i class="far fa-plus-square"></i>
                    </div>
                </div>
            </div>
        </a>
html;

    global $db;
    session_start();
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
        session_write_close();

        $stmt6 = $db->prepare("SELECT * FROM room_info");
        $stmt6->execute();
        $result6 = $stmt6->get_result();
        $y = $result6->num_rows;

        for($i = 0; $i < $y; $i++){

            $stmt5 = $db->prepare("SELECT * FROM room_info WHERE room_id = ?");
            $stmt5->bind_param("i", $i);
            $stmt5->execute();
            $result5 = $stmt5->get_result();
            if($result5->num_rows >= 1){
                $row5 = $result5->fetch_assoc();
                $room_name = $row5['room_name'];

                $stmt7 = $db->prepare("SELECT * FROM device_info WHERE room_id = ?");
                $stmt7->bind_param("i", $i);
                $stmt7->execute();
                $result7 = $stmt7->get_result();
                if($result7->num_rows >= 1){

                    $html .= <<<html
                    <div class="device_room_heading">
                        <strong class="section-title">$room_name</strong>
                    </div>
html;
                }
            }

            $stmt = $db->prepare("SELECT * FROM device_info WHERE hub_id = ? AND room_id = ?");//todo oderby room id
                    $stmt->bind_param("ii", $hub_id, $i);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    $device_id = $row['device_id'];
                    $device_name = $row['device_name'];
                    $device_type = $row['device_type'];
                    $room_id = json_encode($row['room_id']);
                    $status = $row['device_status'];

                    $colour = 'transparent!important';
                    $colour2 = '';
                    $colour3 = '';
                    $background = '';
                    if($status == 1){
                        $colour = 'rgb(56,56,56)!important';
                        $colour2 = 'transparent!important';
                        $colour3 = 'rgb(56,56,56)!important';
                        $background = 'rgb(226, 183, 28)!important';
                    }

                    $stmt3 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                    $stmt3->bind_param("i", $device_type);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();
                    $row3 = $result3->fetch_assoc();
                    $icon = $row3['type_icon'];

                    $stmt4 = $db->prepare("SELECT * FROM room_info WHERE room_id = ?");
                    $stmt4->bind_param("i", $room_id);
                    $stmt4->execute();

                    $result4 = $stmt4->get_result();
                    $row4 = $result4->fetch_assoc();
                    $room_type = $row4['room_name'];

                    //todo intagrate in to device page?

                    $html .= <<<html
                    <!-- Card -->
                    <div class="card mb-4 container text-dark grey-out" style="background-color:$background" onclick="toggleDevice($hub_id, $device_id, $status, '$device_name')">
                        <!--Card image-->
                        <div class="view overlay">
                            <div class="mask rgba-white-slight"></div>
                        </div>
                
                        <!--Card content-->
                        <div class="card-body d-flex justify-content-between">
                    
                            <!--Title-->      
                            <div class="d-flex flex-column">  
                                <div class="flex-sm-row" style="color:$colour3">
                                    <strong class="room_icon">$icon</strong> &nbsp; <strong>$device_name</strong>
                                </div>                     
                            </div>

                            
                            <div class="d-flex flex-column">
                                <!-- Default switch -->
                                <p class="onOffLabel"><strong style="color:$colour2">off</strong><strong style="color:$colour">on</strong></p>
                            </div>
                        </div>

                        <script>

                    function call_php$device_id(){

                        window.location = "index.php?action=onoff_device&hub_id=$hub_id&device_id=$device_id&status=$status&device_name=$device_name";
                    
                    }

                    </script>
                    </div>
html;
                    
                    $stmt3->close();
                }
            }
            $stmt->close();
        }
    } else{
        exit("Error, user is not logged in!");
    }
    return $html;
}

function deviceCat($device_type, $device_name)
{
    if ($device_type == "heating" || $device_type == "airCon") {
        $optionType = "<form class=\"range-field\" for=\"$device_name\"><input type=\"range\" min=\"0c\" max=\"40c\" /></form>";
        //todo add option for different temp measurements farnehight, celcus
    } else {
        $optionType = "<label class=\"custom-control-label\" for=\"$device_name\">off/on</label>";
    }
    return $optionType;
}
?>

