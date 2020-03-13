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
                        Add new device
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

        $stmt = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");//todo oderby room id
        $stmt->bind_param("i", $hub_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $device_id = $row['device_id'];
                $device_name = $row['device_name'];
                $device_type = $row['device_type'];
                $device_room_id = $row['room_id'];
                $deviceLocation = json_encode($device_room_id);

                $stmt3 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                $stmt3->bind_param("i", $device_type);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                $row3 = $result3->fetch_assoc();
                $icon = $row3['type_icon'];

                $stmt4 = $db->prepare("SELECT * FROM room_info WHERE room_id = ?");
                $stmt4->bind_param("i", $device_room_id);
                $stmt4->execute();

                $result4 = $stmt4->get_result();
                $row4 = $result4->fetch_assoc();
                $room_type = $row4['room_name'];

                //todo intagrate in to device page?
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


                $html .= <<<html
                <!-- Card -->
                <div class="card mb-4 container text-dark">
                    <!--Card image-->
                    <div class="view overlay">
                        <div class="mask rgba-white-slight"></div>
                    </div>
              
                    <!--Card content-->
                    <div class="card-body d-flex justify-content-between">
                
                        <!--Title-->      
                        <div class="d-flex flex-column">  
                            <div class="flex-sm-row">
                                $icon &nbsp; $device_name
                                 </div>
                            <div class="flex-sm-row">
                                room: &nbsp; $room_type
                            </div>                                
                            
                        </div>

                        
                        <div class="d-flex flex-column">
                            <!-- Default switch -->
                            <div class="custom-control custom-switch">
                               <form action="#" method="POST">
                                    <input type="checkbox" class="custom-control-input" id="$device_name">
                                    <label class="custom-control-label" for="$device_name">off/on</label>
                               </form>
                               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                               <script>
                                $('#$device_name').change(function() {
                                    let check = $(this);
                                    $(this).load("alert.php");                               
                                    if (check.prop('checked') === true){
                                        alert('ON $device_id');
                                        $(this).load("alert.php");  
                                    }
				                    else {
				                        alert('OFF $device_id');
                                        $(this).load("alert.php");  
				                    }  
                                 });
                               </script>
                            </div>
                        </div>
                    </div>
                </div>
html;
                $stmt3->close();
            }
        }
        $stmt->close();
    } else{
        exit("Error, user is not logged in!");
    }
    return $html;
}
?>
