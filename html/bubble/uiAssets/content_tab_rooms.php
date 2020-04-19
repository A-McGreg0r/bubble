<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';

function generateRoomTab(){
    global $db;
    $html = '<div id="room-encompass">';
    //ADD NEW ROOM CARD, GENERATE ALWAYS AT TOP!
    $html .= <<<html
        <a onclick='$("#addRoomModal").modal();'>
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
        $stmt4->close();

        $device_output = array();
        $output_names = array();

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
                $timers = "";
                $timer = "<i class='far fa-clock'></i>&nbsp;";
                $timer_display = "none";
                $device_add = 0;

                //FIGURE OUT WHETHER ALL DEVICES ARE OFF OR IF SOME ARE ON. DISPLAY COLOUR ACCORDINGLY
                if ($result2->num_rows > 0) {
                    while($rowDevice = $result2->fetch_assoc()) {
                        $status = $rowDevice['device_status'];
                        $id_device = $rowDevice['device_id'];
                        if($status >= 1){
                            $colour = 'rgb(0,0,0)';
                            $colour2 = 'transparent';
                            $background = 'rgb(226, 183, 28)';
                            $setting = "on";
                            $timers .= "startTimer($id_device, 'room_hour_$room_id', 'room_minute_$room_id');";
                            $timer_display = "flex";

                            $device_add = $device_add + $rowDevice['day_data'];
                        }
                    }
                }

                
                array_push($output_names, $room_name);

                $total_usage = 0;
                $stmt5 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
                $stmt5->bind_param("i", $hub_id);
                $stmt5->execute();
                $result5 = $stmt5->get_result();
                if ($result5->num_rows > 0) {
                    while($rowDevice5 = $result5->fetch_assoc()) {
                        $total_usage = $total_usage + $rowDevice5['day_data'];
                    }
                }
                
                //GENERATE CARD FOR ROOM
                $html .= <<<html
                <!-- Card -->
                <div id="room_reload_$room_id">
                    <div class="card mb-4 container text-dark grey-out-rooms alternating-border" style="background-color:$background" id="$room_id" onclick="toggleRoom($hub_id,$room_id);
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
                        $html .= "refreshDevice($id);";
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

                array_push($device_output, $price_month);

                $total_usage = $total_usage - $room_month;
                $total_price = number_format($total_usage * $price, 2);

                $percent = 0;

                $graph = '<strong style="color:red">Graph will generate shortly.</strong>';

                if(($total_price + $price_month) != 0){
                    $percent = number_format(((100 / ($total_price + $price_month)) * $price_month), 1);
                    $graph = <<<graph
                        <canvas class="stats-pie " style="max-width:400px display:inline-block" id="room_stats_doughnut_$room_id" width="924" height="426"></canvas>
                                            
                        <table class="stats-table comparison">
                        <tr class="stats-row">
                            <td class="stats-left l-pad-stats tighten"><strong>
                                $room_name:
                            </strong></td>
                            <td class="stats-right r-pad-stats tighten"><strong>
                                £$price_month
                            </strong></td>
                        </tr>
                        <tr class="raise">
                            <td class="stats-left l-pad-stats tighten"><strong>
                                Other Rooms:
                            </strong></td>
                            <td class="stats-right r-pad-stats tighten"><strong>
                                £$total_price
                            </strong></td>
                        </tr>
                        <tr class="raise">
                            <td class="stats-left l-pad-stats tighten"><strong>
                                Percentage:
                            </strong></td>
                            <td class="stats-right r-pad-stats tighten"><strong>
                                $percent %
                            </strong></td>
                        </tr>
                        </table>
graph;
                }

                $html .= <<<html
                        refreshRoom($room_id);refreshHomeButton();">
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
                                <p class="onOffLabel"><strong id="room_setting_$room_id" style="color:$colour">$setting</strong><div id="room_loader_$room_id" class="loader"></div></p>
                            </div>
                        </div>
                        
                        <strong class="timer_icon" id="room_timer_$room_id" style="color:black;display:$timer_display;" onclick="openModal('modal_room_$room_id', 'timer_room_x_$room_id')">$timer</strong>
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
                                
                                        <h4 class="modalSub">Month's Comparison</h4>
                                        
                                        $graph

                                        <script>
                                            //doughnut
                                            var ctxD = document.getElementById("room_stats_doughnut_$room_id").getContext("2d");
                                            var myLineChart = new Chart(ctxD, {
                                            type: "doughnut",
                                            data: {
                                            labels: ["$room_name [£]", "Other Rooms [£]"],
                                            datasets: [{
                                            data: [$price_month, $total_price],
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmDeleteRoom_$room_id">
                                Delete Room
                            </button>
                            <div class="modal fade" id="confirmDeleteRoom_$room_id" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteRoomModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteRoomModalLabel">Confirm Delete Room</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, go back</button>
                                            <button id="confirmDeleteRoomModalButton" type="button" onclick="confirmDeleteRoomModalConfirm($room_id)" class="btn btn-primary">Delete Room</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="modal modalTimer" id="modal_room_$room_id">
                        <div class="modalContent modalContentTimer modalRoomTimer" id="content_room_timer_$room_id">
                            <div class="x-adjust">
                            <strong class="timer_icon_x" id="timer_room_x_$room_id" onclick="openModal('modal_room_$room_id','timer_room_x_$room_id')"><i class="fas fa-times"></i></strong></div>
                            <div class="modalHeader"><strong>Turn off<br><strong style="font-size:20px">$room_name</strong></strong></div>
                            <div class="modalMain" id="time_button_room_text_$room_id">
                            
                            <form>
                                <div class="timerModal">
                                    <select id="room_hour_$room_id" name="energy_cost" class="form-control-sm dropdown validate drop-up">
                                        <option value="0" selected>00</option>
                                        <option value="1">01</option>
                                        <option value="2">02</option>
                                        <option value="3">03</option>
                                        <option value="4">04</option>
                                        <option value="5">05</option>
                                        <option value="6">06</option>
                                        <option value="7">07</option>
                                        <option value="8">08</option>
                                        <option value="9">09</option>
                                        <option value="10">10</option>
                                    </select>
                                    
                                    <p class="shiftSub"><strong>&nbsp;hour(s)&nbsp;</strong></p>
                                    <p><strong><h4>:&nbsp;</h4></strong></p>

                                    <select id="room_minute_$room_id" name="energy_cost" class="form-control-sm dropdown validate drop-up">
                                        <option value="0" selected>00</option>
                                        <option value="1">01</option>
                                        <option value="2">02</option>
                                        <option value="3">03</option>
                                        <option value="4">04</option>
                                        <option value="5">05</option>
                                        <option value="6">06</option>
                                        <option value="7">07</option>
                                        <option value="8">08</option>
                                        <option value="9">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                        <option value="42">42</option>
                                        <option value="43">43</option>
                                        <option value="44">44</option>
                                        <option value="45">45</option>
                                        <option value="46">46</option>
                                        <option value="47">47</option>
                                        <option value="48">48</option>
                                        <option value="49">49</option>
                                        <option value="50">50</option>
                                        <option value="51">51</option>
                                        <option value="52">52</option>
                                        <option value="53">53</option>
                                        <option value="54">54</option>
                                        <option value="55">55</option>
                                        <option value="56">56</option>
                                        <option value="57">57</option>
                                        <option value="58">58</option>
                                        <option value="59">59</option>
                                    </select>

                                    <p class="shiftSub"><strong>&nbsp;minute(s)</strong></p>
                                </div>
                            </form>

                            <div style="display:block">
                                <p class="timerBtn btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" onclick="$timers;styleRoomTimer($room_id);">Start Timer</p>
                            </div>
                            </div>
                            <i class="fas fa-check" id="timer-tick-room-$room_id" style="margin-left:calc(50% - 40px);width:90px;height:80px;color:black;font-size:75px;display:none;"></i>
                        </div>
                    </div>
html;
            }
        }
        $stmt->close();
    } else{
        exit("Error, user is not logged in!");
    }

    //CREATE ADD ROOM MODAL AND CONTROl
    $html .= <<<html
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add a new room to your house</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="col-lg-12">
                            <div class="row alter-display align-middle reduce-space">
                                <p id="roomErrorDisplay"></p>
                                <!-- Room Name -->
                                <div class="md-form">
                                    <label for="roomFormName">Room Name</label>
                                    <input type="text"
                                        id="roomFormName"
                                        class="form-control form-control-sm"
                                        name="roomName"
                                        required size="3"
                                        value=""/>
                                        <small class="form-text text-muted mb-4" style="text-align:center">Room must have a unique name</small>
                                </div>
        
                                <!-- Icon dropdown -->
                                <div class="md-form">
                                    <select id="roomFormIcon" name="icon" class="browser-default custom-select dropdown">
                                        <option value="" disabled selected>Choose your icon</option>
html;
                                        $stmt = $db->prepare("SELECT * FROM room_types");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $inc = 0;
                                        while($row = $result->fetch_assoc()) {
                                            $inc++;
                                            $val = $row['type_description'];
                                            $html .= "<option value=\"$inc\">$val</option>";
                                        }
                                        $html .= <<<html
        
                                    </select>
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="addRoomModalSubmit()" class="btn btn-secondary">Add Room</button>
                </div>
            </div>
        </div>
    </div>
html;
    return $html;

}

?>
