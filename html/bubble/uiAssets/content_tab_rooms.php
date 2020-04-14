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
        $user_id = $_SESSION['user_id'];
        session_write_close();
        $price = 0;

        $stmt4 = $db->prepare("SELECT energy_cost FROM user_info WHERE user_id = ?");
        $stmt4->bind_param("i", $user_id);
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        while($row4 = $result4->fetch_assoc()) {
            $price = $row4['energy_cost'];
        }

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

                $total_usage = 0;
                $stmt5 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
                $stmt5->bind_param("i", $hub_id);
                $stmt5->execute();
                $result5 = $stmt5->get_result();
                if ($result5->num_rows > 0) {
                    while($rowDevice5 = $result5->fetch_assoc()) {
                        $total_usage = $total_usage + $rowDevice5['month_data'];
                    }
                }
                
                //GENERATE CARD FOR ROOM
                $html .= <<<html
                <!-- Card -->
                <div id="room_reload_$room_id">
                <div class="card mb-4 container text-dark grey-out-rooms alternating-border" style="background-color:$background" id="$room_id" onclick="
html;
                $room_hour = 0;
                $room_day = 0;
                $room_month = 0;
                $room_year = 0;
                $stmt3 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ? AND room_id = ?");
                $stmt3->bind_param("ii", $hub_id, $room_id);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                if ($result3->num_rows > 0) {
                    while($rowDevice3 = $result3->fetch_assoc()) {
                        $id = $rowDevice3['device_id'];
                        $room_hour = $room_hour + $rowDevice3['minute_data'];
                        $room_day = $room_day + $rowDevice3['hour_data'];
                        $room_month = $room_month + $rowDevice3['day_data'];
                        $room_year = $room_year + $rowDevice3['month_data'];
                        $html .= "device_refresh($id);";
                    }
                }
                $total_usage = number_format(($total_usage / 1000),3);
                $room_hour = number_format(($room_hour / 1000),3);
                $room_day = number_format(($room_day / 1000),3);
                $room_month = number_format(($room_month / 1000),3);
                $room_year = number_format(($room_year / 1000),3);

                $price_hour = number_format(($room_hour * $price),2);
                $price_day = number_format(($room_day * $price),2);
                $price_month = number_format(($room_month * $price),2);
                $price_year = number_format(($room_year * $price),2);

                $total_usage = $total_usage - $room_month;

                $html .= <<<html
                    toggleRoom($hub_id,$room_id);refreshHomeButton();">
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
                    
                <i class="stats_icon fa" id="room_stats_$room_id" style="color:$colour;" onclick="openModalRoom('modal_room_stats_$room_id','room_stats_$room_id', 'room_stats_x_$room_id')"><i class="fas fa-info-circle"></i></i>
                </div>
                
                </div>
                <div class="modal modalStatsWrap" id="modal_room_stats_$room_id">
                    <div class="modalContent modalStats" id="content_$room_id">
                        <div class="x-adjust"><i class="stats_icon_x " id="room_stats_x_$room_id" style="color:$colour;" onclick="openModalRoom('modal_room_stats_$room_id','room_stats_x_$room_id','room_stats_$room_id')"><i class="fas fa-times"></i></i></div>
                        <div class="modalHeader"><strong>$room_name Statistics:</strong></div>
                            <div class="modalBody">
                                <div class="active">                           
                                    <div style="max-width:100% text-align:center">
                                
                                        <h4 class="modalSub">Comparison</h4>
                                        
                                        <canvas class="stats-pie " style="max-width:400px display:inline-block" id="room_stats_doughnut_$room_id" width="924" height="426"></canvas>
                                        
                                        <table class="stats-table comparison">
                                        <tr class="stats-row">
                                            <td class="stats-left l-pad-stats tighten"><strong>
                                                $room_name:
                                            </strong></td>
                                            <td class="stats-right r-pad-stats tighten"><strong>
                                                $room_month kWh
                                            </strong></td>
                                        </tr>
                                        <tr class="raise">
                                            <td class="stats-left l-pad-stats tighten"><strong>
                                                Other Rooms:
                                            </strong></td>
                                            <td class="stats-right r-pad-stats tighten"><strong>
                                                $total_usage kWh
                                            </strong></td>
                                        </tr>
                                        </table>

                                        <script>
                                            //doughnut
                                            var ctxD = document.getElementById("room_stats_doughnut_$room_id").getContext("2d");
                                            var myLineChart = new Chart(ctxD, {
                                            type: "doughnut",
                                            data: {
                                            labels: ["$room_name [kWh]", "Other Rooms [kWh]"],
                                            datasets: [{
                                            data: [$room_month, $total_usage],
                                            backgroundColor: ["rgb(226, 183, 28)", "rgb(56,56,56)"],
                                            hoverBackgroundColor: ["rgb(246, 203, 48)", "rgb(76,76,76)"]
                                            }]
                                            },
                                            options: {
                                                responsive: [true],
                                                
                                                }
                                            });
                                        </script>
                                    </div>
                            </div>      
                            <hr>
                            <div class="modalSub">
                                Energy Used
                            </div>
                            <table class="stats-table">
                                <tr class="stats-row">
                                    <td class="stats-left l-pad-stats"><strong>
                                        This hour:<br>Cost:
                                    </strong></td>
                                    <td class="stats-right r-pad-stats"><strong>
                                        $room_hour kWh<br>&#163; $price_hour
                                    </strong></td>
                                </tr>
                                <tr class="stats-row">
                                    <td class="stats-left l-pad-stats"><strong>
                                        Today:<br>Cost:
                                    </strong></td>
                                    <td class="stats-right r-pad-stats"><strong>
                                        $room_day kWh<br>&#163; $price_day
                                    </strong></td>
                                </tr>
                                <tr class="stats-row">
                                    <td class="stats-left l-pad-stats"><strong>
                                        This month:<br>Cost:
                                    </strong></td>
                                    <td class="stats-right r-pad-stats"><strong>
                                        $room_month kWh<br>&#163; $price_month
                                    </strong></td>
                                </tr>
                                <tr class="stats-row">
                                    <td class="stats-left l-pad-stats"><strong>
                                        This year:<br>Cost:
                                    </strong></td>
                                    <td class="stats-right r-pad-stats"><strong>
                                        $room_year kWh<br>&#163; $price_year
                                    </strong></td>
                                </tr>
                            </table>
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
