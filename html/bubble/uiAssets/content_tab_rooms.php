<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';

ob_start();
include 'required/on_off_room_function.php';
ob_get_clean();

function generateRoomTab(){
    global $db;
    $html = '';
    session_start();
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
        session_write_close();

        $stmt = $db->prepare("SELECT * FROM room_info WHERE hub_id = ?");
        $stmt->bind_param("i", $hub_id);
        $stmt->execute();
        $result = $stmt->get_result();


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
        //rooms
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $room_id = $row['room_id'];
                $room_name = $row['room_name'];
                $icon = $row['room_icon'];
                $stmt1 = $db->prepare("SELECT * FROM room_types WHERE type_id = ?");
                $stmt1->bind_param("i", $icon);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $row1 = $result1->fetch_assoc();
                $iconText = $row1['type_icon'];

                $colour = 'transparent';
                $colour2 = '';
                $colour3 = '';
                $background = '';

                $stmt2 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ? AND room_id = ?");
                $stmt2->bind_param("ii", $hub_id, $room_id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $num_rows2 = $result2->num_rows;
                if ($num_rows2 >= 1) {
                    $all2 = $result2->fetch_all(MYSQLI_ASSOC);
                    foreach($all2 as $row2){
                        $status = $row2['device_status'];
                        $room_id = $row2['room_id'];

                        if($status == 1){
                            $colour = 'rgb(56,56,56)';
                            $colour2 = 'transparent';
                            $colour3 = 'rgb(56,56,56)';
                            $background = 'rgb(226, 183, 28)';
                        }
                    }
                }
                
                $html .= <<<html
                <!-- Card -->
                <div class="card mb-4 container text-dark grey-out-rooms alternating-border" style="background-color:$background" id="$room_id" onclick="toggleRoom($hub_id,$room_id,$status,'$room_name')">
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
                            <p class="onOffLabel"><strong style="color:$colour2">off</strong><strong style="color:$colour">on</strong></p>
                        </div>
                    </div>

                    <script>

                    function call_php_room$room_id(){

                        if($status == 0){
                            document.getElementById("$room_id").style.backgroundColor = "rgb(227, 184, 28)";
                            document.getElementById("$room_id").style.color = "rgb(56, 56, 56)";
                        } else if ($status == 1){
                            if($room_id % 2 == 1){
                                document.getElementById("$room_id").style.backgroundColor = "rgb(56, 56, 56)";
                                document.getElementById("$room_id").style.color = "rgb(227, 184, 28)";
                            } else {
                                document.getElementById("$room_id").style.backgroundColor = "transparent";
                            }
                        }

                        window.location = "index.php?action=onoff_room&hub_id=$hub_id&room_id=$room_id&status=$status&room_name=$room_name";
                    
                    }

                    function call_php() {
                        alert("No devices associated with room");
                    }

                    </script>
                </div>

html;
            }
        }
        $stmt->close();
    } else{
        exit("Error, user is not logged in!");
    }
    return $html;

}

?>
