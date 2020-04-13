<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';

function generateDeviceTab(){
    global $db;
    //ADD NEW DEVICE CARD, GENERATE ALWAYS AT TOP!
    $html = $html = '<div id="device-encompass">';

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
                        <strong>Add new device</strong>
                    </div>
                    
                    <div class="d-flex flex-column">
                        <i class="far fa-plus-square"></i>
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
                    $minutes_on = $row['minutes_on'];
                    $room_id = json_encode($row['room_id']);
                    $status = $row['device_status'];
                    $setting = "on&nbsp;";
                    $timer = "<i class='far fa-clock'></i>&nbsp;";
                    $timer_display = 'flex';
                    $timer_value = $row['turn_off'] - $minutes_on;
                    $timer_hour = $timer_value - ($timer_value % 60);
                    $timer_hours = $timer_hour / 60;
                    $timer_minutes = $timer_value % 60;
                    $timer_text = "";
                    $device_hour = $row['minute_data'] / 1000;
                    $device_day = $row['hour_data'] / 1000;
                    $device_month = $row['day_data'] / 1000;
                    $device_year = $row['month_data'] / 1000;
                    $total_usage = 0;
                    
                    $device_hour = number_format($device_hour, 3);
                    $device_day = number_format($device_day, 3);
                    $device_month = number_format($device_month, 3);
                    $device_year = number_format($device_year, 3);

                    $stmt5 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
                    $stmt5->bind_param("i", $hub_id);
                    $stmt5->execute();
                    $result5 = $stmt5->get_result();

                    //LOOP THROUGH ALL DEVICES IN THAT ROOM
                    if ($result5->num_rows > 0) {
                        while ($row5 = $result5->fetch_assoc()) {
                            $total_usage = $total_usage + $row5['day_data'];
                        }
                    }
                    $stmt5->close();

                    $total_usage = $total_usage / 1000;
                    $total_usage = $total_usage - $device_month;
                    $total_usage = number_format($total_usage,3);

                    $price = 0;

                    $stmt4 = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
                    $stmt4->bind_param("i", $user_id);
                    $stmt4->execute();
                    $result4 = $stmt4->get_result();
                    if($result4->num_rows == 1){
                        $row = $result4->fetch_assoc();
                        $price = $row['energy_cost'];
                    }

                    $price_hour = $device_hour * $price;
                    $price_day = $device_day * $price;
                    $price_month = $device_month * $price;
                    $price_year = $device_year * $price;

                    $price_hour = number_format($price_hour,2);
                    $price_day = number_format($price_day,2);
                    $price_month = number_format($price_month,2);
                    $price_year = number_format($price_year,2);

                    $hour = date("H");
                    $minute = date("i");

                    $off_hour = $hour + $timer_hours + 1;
                    $off_minute = $minute + $timer_minutes;
                    if($off_minute >= 60){
                        $off_hour = $off_hour + 1;
                        $off_minute = $off_minute - 60;
                    }

                    if ($off_minute < 10){
                        $off_minute = "0$off_minute";
                    }

                    if ($off_hour < 10){
                        $off_hour = "0$off_hour";
                    }

                    if ($timer_value >= 1){
                        $timer_text = "<strong style='color:rgb(226,183,28)'>Timer set for $off_hour : $off_minute</strong><br>";
                    }

                    if($device_type == 2 || $device_type == 4){
                        $setting = "$status&nbsp;&nbsp;&nbsp;";
                    }

                    $colour = 'rgb(0,0,0)';
                    $colour2 = 'rgb(0,0,0)';
                    $colour3 = 'rgb(0,0,0)';
                    $background = '';
                    if($status == 0){
                        $timer = "";
                        $setting = "off";
                        $timer_display = 'none';
                    } else if($status == 1){
                        $colour2 = 'transparent';
                        $background = 'linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 25%, rgb(56,56,56) 25%, rgb(56,56,56) calc(25% + 1px), transparent calc(25% + 1px)';
                    } else if($status == 2){
                        $colour2 = 'transparent';
                        $background = 'linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 50%, rgb(56,56,56) 50%, rgb(56,56,56) calc(50% + 1px), transparent calc(50% + 1px)';
                    } else if($status == 3){
                        $colour2 = 'transparent';
                        $background = 'linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 75%, rgb(56,56,56) 75%, rgb(56,56,56) calc(75% + 1px), transparent calc(75% + 1px)';
                    } else if($status == 4){
                        $colour2 = 'transparent';
                        $background = 'linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 100%, transparent 100%';
                    }

                    //GET ICON FROM ICON TABLE
                    $stmt3 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                    $stmt3->bind_param("i", $device_type);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();
                    $row3 = $result3->fetch_assoc();
                    $icon = $row3['type_icon'];
                    $stmt3->close();

                    //GENERATE CARD FOR DEVICE
                    $html .= <<<html
                    <!-- Card -->
                    <div id="reload_$device_id">
                    <div id="device_$device_id" class="card mb-4 container text-dark grey-out" style="background-image:$background" onclick="alterDevice($hub_id, $device_id, $device_type, $status)">
                        <!--Card image-->
                        <div class="view overlay">
                            <div class="mask rgba-white-slight"></div>
                        </div>
                
                        <!--Card content-->
                        <div class="card-body d-flex justify-content-between">
                    
                            <!--Title-->      
                            <div class="d-flex flex-column">  
                                <div id="device_3_$device_id" class="flex-sm-row" style="color:$colour3">
                                    <strong class="room_icon">$icon</strong> &nbsp; <strong>$device_name</strong>
                                </div>                     
                            </div>
                            
                            <div class="d-flex flex-column">
                                <!-- Default switch -->
                                <p class="onOffLabel"><strong id="device_1_$device_id" style="color:$colour">$setting</strong></p>
                            </div>
                        </div>

                        <strong class="timer_icon" id="timer_$device_id" style="color:$colour; display:$timer_display" onclick="openModal('modal_$device_id', 'modal_stats_$device_id', 'timer_$device_id', 'timer_x_$device_id', 'stats_$device_id', 'stats_x_$device_id', $status)">$timer</strong>
                        <strong class="timer_icon_x" id="timer_x_$device_id" style="color:$colour; display:none" onclick="openModal('modal_$device_id', 'modal_stats_$device_id', 'timer_$device_id', 'timer_x_$device_id', 'stats_$device_id', 'stats_x_$device_id', $status)"><i class="fas fa-times"></i></strong>
                        <i class="stats_icon fa" id="stats_$device_id" style="color:$colour;" onclick="openModal('modal_stats_$device_id', 'modal_$device_id', 'stats_$device_id', 'stats_x_$device_id', 'timer_$device_id', 'timer_x_$device_id', $status)">&#xf200;</i>
                        <i class="stats_icon_x " id="stats_x_$device_id" style="color:$colour;" onclick="openModal('modal_stats_$device_id', 'modal_$device_id', 'stats_$device_id', 'stats_x_$device_id', 'timer_$device_id', 'timer_x_$device_id', $status)"><i class="fas fa-times"></i></i>
                    </div>

                    
                    </div>
                    <div class="modalStatsWrap" id="modal_stats_$device_id">
                        <div class="modalContent modalStats" id="content_$device_id">
                            <div class="modalHeader"><strong>$device_name statistics:</strong></div>
                                <div class="modalBody">
                                    <div class="active">                           
                                        <div style="max-width:100% text-align:center">
                                    
                                            <h4 class="modalSub">Comparison</h4>
                                            
                                            <canvas class="stats-pie " style="max-width:400px display:inline-block" id="stats_doughnut_$device_id" width="924" height="426"></canvas>
                                            
                                            <table class="stats-table comparison">
                                            <tr class="stats-row">
                                                <td class="stats-left l-pad-stats tighten"><strong>
                                                    $device_name:
                                                </strong></td>
                                                <td class="stats-right r-pad-stats tighten"><strong>
                                                    $device_month kWh
                                                </strong></td>
                                            </tr>
                                            <tr class="raise">
                                                <td class="stats-left l-pad-stats tighten"><strong>
                                                    Other Devices:
                                                </strong></td>
                                                <td class="stats-right r-pad-stats tighten"><strong>
                                                    $total_usage kWh
                                                </strong></td>
                                            </tr>
                                            </table>

                                            <script>
                                                //doughnut
                                                var ctxD = document.getElementById("stats_doughnut_$device_id").getContext("2d");
                                                var myLineChart = new Chart(ctxD, {
                                                type: "doughnut",
                                                data: {
                                                labels: ["$device_name [kWh]", "Other Devices [kWh]"],
                                                datasets: [{
                                                data: [$device_month, $total_usage],
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
                                            $device_hour kWh<br>&#163; $price_hour
                                        </strong></td>
                                    </tr>
                                    <tr class="stats-row">
                                        <td class="stats-left l-pad-stats"><strong>
                                            Today:<br>Cost:
                                        </strong></td>
                                        <td class="stats-right r-pad-stats"><strong>
                                            $device_day kWh<br>&#163; $price_day
                                        </strong></td>
                                    </tr>
                                    <tr class="stats-row">
                                        <td class="stats-left l-pad-stats"><strong>
                                            This month:<br>Cost:
                                        </strong></td>
                                        <td class="stats-right r-pad-stats"><strong>
                                            $device_month kWh<br>&#163; $price_month
                                        </strong></td>
                                    </tr>
                                    <tr class="stats-row">
                                        <td class="stats-left l-pad-stats"><strong>
                                            This year:<br>Cost:
                                        </strong></td>
                                        <td class="stats-right r-pad-stats"><strong>
                                            $device_year kWh<br>&#163; $price_year
                                        </strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modalTimer" id="modal_$device_id">
                        <div class="modalContent" id="content_$device_id">
                            <div class="modalHeader"><strong>Turn $device_name off in:</strong></div>
                            <div class="timer-end" id="timer_end_$device_id"><strong>$timer_text<strong></div>
                            <form>
                                <div class="timerModal">
                                    <select id="hour_$device_id" name="energy_cost" class="form-control-sm dropdown validate drop-up">
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

                                    <select id="minute_$device_id" name="energy_cost" class="form-control-sm dropdown validate drop-up">
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
                                <p class="timerBtn btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" onclick="startTimer($device_id, 'hour_$device_id', 'minute_$device_id')">Start Timer</p>
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
    $html .= "</div>";
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

