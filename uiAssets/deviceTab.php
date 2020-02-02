<!-- Card deck -->
<?php
include_once '/var/www/html/bubble/required/config.php';

function generateDeviceTab(){
    $html = '';
    global $db;
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
        
        $stmt = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
        $stmt->bind_param("i", $hub_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $device_id = $row['device_id'];
                $device_name = $row['device_name'];
                $html .= <<<html
                <!-- Card -->
                <div class="card mb-4 container">
                    <!--Card image-->
                    <div class="view overlay">
                        <div class="mask rgba-white-slight"></div>
                    </div>
              
                    <!--Card content-->
                    <div class="card-body d-flex justify-content-between">
                
                        <!--Title-->      
                        <form onsubmit="toggleDevice($device_id);" method="POST">
                            <div class="d-flex flex-column">  
                                $device_name
                            </div>
                            
                            <div class="d-flex flex-column">
                            <!-- Default switch -->
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="roomSwitche">
                                    <label class="custom-control-label" for="roomSwitche">on/off</label>
                                </div>  
                            </div>
                        </form>

                    </div>
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