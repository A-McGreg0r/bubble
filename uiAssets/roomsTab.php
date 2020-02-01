<!-- Card deck -->
<?php

    include_once '../required/config.php';
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        
        $stmt = $db->prepare("SELECT * FROM rooms WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        if ($stmt->num_rows > 0) {
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()) {
                $room_id = $row['room_id'];
                $room_name = $row['room_name'];
                echo <<<html
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
                            $room_name
                        </div>
                        
                        <div class="d-flex flex-column">
                        <!-- Default switch -->
                            <div class="custom-control custom-switch">
                                <form onsubmit="toggleSwitch($room_id);" method="POST">
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
?>