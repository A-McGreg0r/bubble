<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';

function generateRoomTab(){
    global $db;
    $html = '<div id="room-encompass">';
    //ADD NEW ROOM CARD, GENERATE ALWAYS AT TOP!
    $html .= <<<html
        <a href="index.php?action=addroom">
            <div class="card mb-4 container">
                <!--Card image-->
                <div class="view overlay">
                    <div class="mask rgba-white-slight"></div>
                </div>
            
                <!--Card content-->
                <div class="card-body d-flex justify-content-between">
            
                <!--Title-->      
                    <div class="d-flex flex-column">  
                        <strong>Add new room</strong>
                    </div>
                    
                    <div class="d-flex flex-column">
                        <strong><i class="far fa-plus-square"></i></strong>
                    </div>
                </div>
            </div>
        </a>
html;
    //GRAB HUB ID FROM SESSION
    session_start();
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
        session_write_close();

        //GET ALL ROOMS FOR HUB ID
        $stmt = $db->prepare("SELECT * FROM room_info WHERE hub_id = ?");
        $stmt->bind_param("i", $hub_id);
        $stmt->execute();
        $result = $stmt->get_result();

        //LOOP THROUGH ALL ROOMS
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $room_id = $row['room_id'];
                $room_name = $row['room_name'];
                $icon = $row['room_icon'];

                //GET ROOM ICON FROM ROOM_TYPES ICON TABLE
                $stmt1 = $db->prepare("SELECT * FROM room_types WHERE type_id = ?");
                $stmt1->bind_param("i", $icon);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $row1 = $result1->fetch_assoc();
                $iconText = $row1['type_icon'];
                $stmt1->close();

                $colour = 'rgb(0,0,0)';
                $colour2 = 'rgb(0,0,0)';
                $colour3 = 'rgb(0,0,0)';
                $background = '';

                //GRAB ALL DEVICES 
                $stmt2 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ? AND room_id = ?");
                $stmt2->bind_param("ii", $hub_id, $room_id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $setting = "off";

                //FIGURE OUT WHETHER ALL DEVICES ARE OFF OR IF SOME ARE ON. DISPLAY COLOUR ACCORDINGLY
                if ($result2->num_rows > 0) {
                    while($rowDevice = $result2->fetch_assoc()) {
                        $status = $rowDevice['device_status'];
                        if($status >= 1){
                            $colour = 'rgb(0,0,0)';
                            $colour2 = 'transparent';
                            $background = 'rgb(226, 183, 28)';
                            $setting = "on";
                        }
                    }
                }
                $stmt2->close();
                
                //GENERATE CARD FOR ROOM
                $html .= <<<html
                <!-- Card -->
                <div id="room_reload_$room_id">
                <div class="card mb-4 container text-dark grey-out-rooms alternating-border" style="background-color:$background" id="$room_id" onclick="toggleRoom($hub_id,$room_id)">
                    <!--Card image-->
                    <div class="view overlay">
                        <div class="mask rgba-white-slight"></div>
                    </div>
              
                    <!--Card content-->
                    <div class="card-body d-flex justify-content-between">
              
                    <!--Title-->      
                        <div class="d-flex flex-column">  
                            <div class="row" style="color:$colour3">
                                <strong class="room_icon">$iconText</strong> &nbsp; <strong>$room_name</strong>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-column" style="font-size:1.5rem">
                            <!-- Default switch -->
                            <p class="onOffLabel"><strong style="color:$colour">$setting</strong></p>
                        </div>
                    </div>
                </div>
                </div>
html;
            }
        }
        $stmt->close();
    } else{
        exit("Error, user is not logged in!");
    }
    $html .= "</div>";
    return $html;

}

?>
