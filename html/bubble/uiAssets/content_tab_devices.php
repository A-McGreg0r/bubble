<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';



function generateDeviceTab(){
    global $db;

    $html = <<<html
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

    session_start();
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
        session_write_close();

        //GET ALL ROOMS FOR A SPECIFIC HUB
        $stmtRoom = $db->prepare("SELECT * FROM room_info WHERE hub_id = ?");
        $stmtRoom->bind_param("i", $hub_id);
        $stmtRoom->execute();
        $resultRoom = $stmtRoom->get_result();
        //GET TOTAL NUMBER OF ROOMS
        $totalRooms = $resultRoom->num_rows;

        //LOOP FOR EACH ROOM FOR THE HUB
        while ($rowRoom = $resultRoom->fetch_assoc()) {
            $room_name = $rowRoom['room_name'];
            $room_id = $rowRoom['room_id'];
            $html .= <<<html
            <div class="device_room_heading">
                <strong class="section-title">$room_name</strong>
            </div>
html;
            //GET ALL DEVICES IN THAT ROOM
            $stmtDevice = $db->prepare("SELECT * FROM device_info WHERE hub_id = ? AND room_id = ?");
            $stmtDevice->bind_param("ii", $hub_id, $room_id);
            $stmtDevice->execute();
            $resultDevice = $stmtDevice->get_result();

            //LOOP THROUGH ALL DEVICES IN THAT ROOM
            if ($resultDevice->num_rows > 0) {
                while ($row = $resultDevice->fetch_assoc()) {
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

                    //GET ICON FROM ICON TABLE
                    $stmt3 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                    $stmt3->bind_param("i", $device_type);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();
                    $row3 = $result3->fetch_assoc();
                    $icon = $row3['type_icon'];
                    $stmt3->close();

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
                    </div>
html;
                    
                }
            }
            $stmtDevice->close();
        }
        $stmtRoom->close();
    } else{
        exit("Error, user is not logged in!");
    }
    return $html;
}

function deviceCat($device_type, $device_name) {
    if ($device_type == "heating" || $device_type == "airCon") {
        $optionType = "<form class=\"range-field\" for=\"$device_name\"><input type=\"range\" min=\"0c\" max=\"40c\" /></form>";
        //todo add option for different temp measurements farnehight, celcus
    } else {
        $optionType = "<label class=\"custom-control-label\" for=\"$device_name\">off/on</label>";
    }
    return $optionType;
}
?>

