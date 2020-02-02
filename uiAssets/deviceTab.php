<!-- Card deck -->
<?php
include_once '/var/www/html/bubble/required/config.php';

function generateDeviceTab(){
    $html = '';
    global $db;
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
        
        $stmt = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
        $stmt->bind_param("s", $hub_id);
        $stmt->execute();
        if ($stmt->num_rows > 0) {
            $result = $stmt->get_result();
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
                        <div class="d-flex flex-column">  
                            $device_name
                        </div>
                        
                        <div class="d-flex flex-column">
                        <!-- Default switch -->
                            <div class="custom-control custom-switch">
                                <form onsubmit="toggleDevice($device_id);" method="POST">
                                    <input type="checkbox" class="custom-control-input" id="roomSwitch">
                                </form>
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
    return $html;
}
   
?>