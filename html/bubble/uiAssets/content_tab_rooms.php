<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';

function generateRoomTab(){
    $html = '';
    global $db;
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
                            Add new room
                        </div>
                        
                        <div class="d-flex flex-column">
                            <i class="far fa-plus-square"></i>
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
                $html .= <<<html
                <!-- Card -->
                <div class="card mb-4 container text-dark grey-out">
                    <!--Card image-->
                    <div class="view overlay">
                        <div class="mask rgba-white-slight"></div>
                    </div>
              
                    <!--Card content-->
                    <div class="card-body d-flex justify-content-between">
              
                    <!--Title-->      
                        <div class="d-flex flex-column">  
                            <div class="row">
                                $iconText &nbsp; $room_name
                            </div>
                        </div>
                        
                        <div class="d-flex flex-column">
                            <!-- Default switch -->
                            <div class="custom-control custom-switch">
                                <form action="#" method="POST">
                                    <input type="checkbox" class="custom-control-input" id="$room_name" name="room+$room_id" onclick="toggleRoom($room_id)">
                                    <label class="custom-control-label" for="$room_name">off/on</label>
                                </form>
                            </div>
                            <script>
                            
                            $('input[name ="room'+$room_id+'"]').change(function() {
                              let check = $(this);
                              if (check.prop('checked' , true)){ 
                              $('input[name ="Group'+ $room_id +'"]').prop('checked' , true);
                              }else if ('checked' , false)){
                              $('input[name ="Group'+ $room_id +'"]').prop('checked' , false);
                              }
                            });
                            
                            </script>
                        </div>
                    </div>
                </div>
             
                    <script>
                    function buttonUpDate(){
                    
                    $('input[type="checkbox"]').click( function(){
                        let roomName = this.parent.name;
                        let chkId = '';
                        $('.chkNumber:checked').each(function() {
                          chkId += $(this).val() + ",";
                          
                           if($('input[type="checkbox"]').val("on")){
                                alert(roomName +"devices on");  
                                //script hear
                            }else if ($('input[type="checkbox"]').val("off")){
                                 alert(roomName +"devices off");  
                            }
                           
                          alert($(this).val()+ "test 1");  
                        });
                    alert($(this).val()+"test 2");  
                    
                      });                        
                    }

                    </script>
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
