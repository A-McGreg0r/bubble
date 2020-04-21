<?php
include_once dirname(__DIR__) . '/required/config.php';

function generateHomeTab()
{
    global $db;
    $html = '<div class="accordion md-accordion z-depth-1-half" id="accordionEx194" role="tablist" aria-multiselectable="true">';
    session_start();

    //GET SESSION INFORMATION
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $hub_id = $_SESSION['hub_id'];

        session_write_close();

        //GRAB USER INFORMATION
        $stmtUser = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmtUser->bind_param("i", $user_id);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        //EXTRACT TO CURRENT NAME SPACE
        if ($resultUser->num_rows === 1) {
            extract($resultUser->fetch_assoc());
        }
        $stmtUser->close();

        //GRAB HUB COSTING INFORMATION
        $stmtHubCost = $db->prepare("SELECT * FROM hub_cost WHERE hub_id = ?");
        $stmtHubCost->bind_param("i", $hub_id);
        $stmtHubCost->execute();
        $resultHubCost = $stmtHubCost->get_result();
        //EXTRACT TO CURRENT NAME SPACE
        if ($resultHubCost->num_rows === 1) {
            extract($resultHubCost->fetch_assoc());
        }
        $stmtHubCost->close();

        //GRAB HUB INFORMATION FOR HUB ID, STORED IN SESSION
        $stmtHub = $db->prepare("SELECT * FROM hub_info WHERE hub_id = ?");
        $stmtHub->bind_param("i", $hub_id);
        $stmtHub->execute();
        $resultHub = $stmtHub->get_result();

        //CHECK ONLY ONE HUB FOR ID, SANITIZATION.
        if ($resultHub->num_rows === 1) {
            $rowHub = $resultHub->fetch_assoc();
            $hub_name = $rowHub['hub_name'];
            if (empty($hub_name)) {
                $hub_name = "My Home";
            }

            //GATHER DATA AND CALCULATE DATA FOR USER TIMEFRAMES
            $day=date("d");
            $energy_last_day = 0;

            $stmt4 = $db->prepare("SELECT * FROM hourly_data WHERE hub_id = ? AND entry_day = ?");
            $stmt4->bind_param("ii", $hub_id,$day );
            $stmt4->execute();
            $result4 = $stmt4->get_result();
            if ($result4->num_rows >= 1) {
                $all4 = $result4->fetch_all(MYSQLI_ASSOC);
                foreach($all4 as $row4){
                    $energy_last_day = $energy_last_day + $row4['energy_usage'];
                }
            }

            $energy_last_day = number_format(($energy_last_day / 1000),2,'.','');

            $month = date("m");
            $energy_last_month = 0;

            $stmt5 = $db->prepare("SELECT * FROM daily_data WHERE hub_id = ? AND entry_month = ?");
            $stmt5->bind_param("ii", $hub_id, $month);
            $stmt5->execute();
            $result5 = $stmt5->get_result();
            if ($result5->num_rows >= 1) {
                $all5 = $result5->fetch_all(MYSQLI_ASSOC);
                foreach($all5 as $row5){
                    $energy_last_month = $energy_last_month + $row5['energy_usage'];
                }
            }

            $energy_last_month = number_format(($energy_last_month / 1000),2,'.','');

            $energy_last_year = 0;

            $stmt6 = $db->prepare("SELECT * FROM monthly_data WHERE hub_id = ?");
            $stmt6->bind_param("i", $hub_id);
            $stmt6->execute();
            $result6 = $stmt6->get_result();
            if ($result6->num_rows >= 1) {
                $all6 = $result6->fetch_all(MYSQLI_ASSOC);
                foreach($all6 as $row6){
                    $energy_last_year = $energy_last_year + $row6['energy_usage'];
                }
            }

            $energy_last_year = number_format(($energy_last_year / 1000),2,'.','');

            //-----------------------------CALCULATE DATA FOR GRAPH PLOTTING-----------------------------------
            
            $dataPoints = array();
            $dataLabels = array();
            $dataGenPoints = array();

            $stmt7 = $db->prepare("SELECT * FROM monthly_data WHERE hub_id = ?");
            $stmt7->bind_param("i", $hub_id);
            $stmt7->execute();
            $result7 = $stmt7->get_result();
            if ($result7->num_rows >= 1) {
                $all7 = $result7->fetch_all(MYSQLI_ASSOC);
                foreach($all7 as $row7){
                    $energy_usage7 = number_format(($row7['energy_usage']/1000),3,'.','');
                    $year7 = $row7['entry_year'];
                    $month7 = $row7['entry_month'];
                    array_push($dataPoints, array($energy_usage7));
                    array_push($dataLabels, array($month7));
                }
            }

            $stmt14 = $db->prepare("SELECT * FROM monthly_gen WHERE hub_id = ?");
            $stmt14->bind_param("i", $hub_id);
            $stmt14->execute();
            $result14 = $stmt14->get_result();
            if ($result14->num_rows >= 1) {
                $all14 = $result14->fetch_all(MYSQLI_ASSOC);
                foreach($all14 as $row14){
                    $energy_gen14 = number_format($row14['energy_gen'] / 1000, 3);
                    array_push($dataGenPoints, array($energy_gen14));
                }
            }

            $cost_year = $energy_last_year * $energy_cost;
            $cost_year_round = number_format($cost_year,2,'.','');
            $DataLabelsYearEncoded = json_encode($dataLabels);
            $dataPointsYearEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);
            $dataGenYearEncoded = json_encode($dataGenPoints, JSON_NUMERIC_CHECK);

            $dataPoints = array();
            $dataLabels = array();
            $dataGenPoints = array();

            $stmt8 = $db->prepare("SELECT * FROM daily_data WHERE hub_id = ?");
            $stmt8->bind_param("i", $hub_id);
            $stmt8->execute();
            $result8 = $stmt8->get_result();
            if ($result8->num_rows >= 1) {
                $n = 0;
                $all8 = $result8->fetch_all(MYSQLI_ASSOC);
                foreach($all8 as $row8){
                    $n = $n + 1;
                    $energy_usage8 = number_format(($row8['energy_usage']/1000),3,'.','');
                    $day8 = $row8['entry_day'];
                    array_push($dataPoints, array($energy_usage8));
                    array_push($dataLabels, array($day8));
                }
            }

            $stmt15 = $db->prepare("SELECT * FROM daily_gen WHERE hub_id = ?");
            $stmt15->bind_param("i", $hub_id);
            $stmt15->execute();
            $result15 = $stmt15->get_result();
            if ($result15->num_rows >= 1) {
                $all15 = $result15->fetch_all(MYSQLI_ASSOC);
                foreach($all15 as $row15){
                    $energy_gen15 = number_format($row15['energy_gen'] / 1000, 3);
                    array_push($dataGenPoints, array($energy_gen15));
                }
            }

            $cost_month = $energy_last_month * $energy_cost;
            $cost_month_round = number_format($cost_month,2,'.','');
            $DataLabelsMonthEncoded = json_encode($dataLabels);
            $dataPointsMonthEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);
            $dataGenMonthEncoded = json_encode($dataGenPoints, JSON_NUMERIC_CHECK);

            $dataPoints = array();
            $dataLabels = array();
            $dataGenPoints = array();

            $stmt9 = $db->prepare("SELECT * FROM hourly_data WHERE hub_id = ?");
            $stmt9->bind_param("i", $hub_id);
            $stmt9->execute();
            $result9 = $stmt9->get_result();
            if ($result9->num_rows >= 1) {
                $n = 0;
                $all9 = $result9->fetch_all(MYSQLI_ASSOC);
                foreach($all9 as $row9){
                    $n = $n + 1;
                    $energy_usage9 = number_format(($row9['energy_usage']/1000),3,'.','');
                    $hour9 = $row9['entry_hour'];
                    array_push($dataPoints, array($energy_usage9));
                    array_push($dataLabels, array($hour9));
                }
            }

            $stmt16 = $db->prepare("SELECT * FROM hourly_gen WHERE hub_id = ?");
            $stmt16->bind_param("i", $hub_id);
            $stmt16->execute();
            $result16 = $stmt16->get_result();
            if ($result16->num_rows >= 1) {
                $all16 = $result16->fetch_all(MYSQLI_ASSOC);
                foreach($all16 as $row16){
                    $energy_gen16 = number_format($row16['energy_gen'] / 1000, 3);
                    array_push($dataGenPoints, array($energy_gen16));
                }
            }

            $cost_day = $energy_last_day * $energy_cost;
            $cost_day_round = number_format($cost_day,2,'.','');
            $DataLabelsDayEncoded = json_encode($dataLabels);
            $dataPointsDayEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);
            $dataGenDayEncoded = json_encode($dataGenPoints, JSON_NUMERIC_CHECK);

            $energy_cost_round = number_format($energy_cost,2,'.','');
            $budget_round = number_format($budget,2,'.','');
            $budget_remaining = $budget - $cost_month;
            if($budget_remaining < 0){
                $budget_remaining = 0;
            }
            $budget_remaining_round = number_format($budget_remaining,2,'.','');

            $budget_day = $budget / 28;
            $budget_year = $budget * 12;
            $budget_day_remaining = $budget_day - $cost_day;
            if($budget_day_remaining < 0){
                $budget_day_remaining = 0;
            }
            $budget_year_remaining = $budget_year - $cost_year;
            if($budget_year_remaining < 0){
                $budget_year_remaining = 0;
            }
            $budget_day_remaining_round = number_format($budget_day_remaining,2,'.','');
            $budget_year_remaining_round = number_format($budget_year_remaining,2,'.','');

            $all_homes = "styleHome();";
            $timers = "";

            $count = 0;
            
            //-----------------------------END CALCULATE DATA FOR GRAPH PLOTTING-----------------------------------


            $s_or_not = "";
            if($count == 1){
                $s_or_not = "device";
            } else {
                $s_or_not = "devices";
            }

            //ADD BUTTON THAT ALLOWS CHANGING OF COSTINGS
            $change_costings = <<<change_button
            <div class='col col-md justify-content-center' style='max-width: 575px'>
            <!--function call-->
                <div id='reload_device_id' class='home-left' style='text-align:center' onclick=''>
                    <!--left text-->
                    <div id='device_3_device_id' class='justify-content-center'>
                        <strong class='room_icon'>
                            <i class="fas fa-file-invoice-dollar"></i>
                            <br>Change Costings<br>
                            <strong style='color:black'></strong>
                        </strong>
                    </div>
                </div>
            </div>
change_button;
            //FIND ALL HUBS REGISTERED TO USER, ADD MODAL AND BUTTONS THAT ALLOW CHANGING BETWEEN HUBS

            $change_button = "";
            $home_button_style = "<div class='col col-md justify-content-center' style='max-width: 1050px'>";

            $all_hubs = "<table style='width:100%'>";
            $stmt12 = $db->prepare("SELECT * FROM hub_users WHERE user_id = ?");
            $stmt12->bind_param("i", $user_id);
            $stmt12->execute();
            $result12 = $stmt12->get_result();
            if ($result12->num_rows > 0) {
                while ($row12 = $result12->fetch_assoc()) {
                    if($result12->num_rows > 1){
                        $change_button = <<<change_button
                        <div class='col col-md justify-content-center' style='max-width: 575px'>
                        <!--function call-->
                            <div id='reload_device_id' class='home-left' style='text-align:center' onclick='openModalHome("hub_select")'>
                                <!--left text-->
                                <div id='device_3_device_id' class='justify-content-center'>
                                    <strong class='room_icon'>
                                        <i class='fa fa-home'></i>
                                        <br>Change House<br>
                                        <strong style='color:black'>$hub_name </strong>
                                    </strong>
                                </div>
                            </div>
                        </div>
change_button;
                        $home_button_style = "<div class='col col-md justify-content-center' style='max-width: 575px'>";
                    }
                    $row_id = $row12['hub_id'];
                    $stmt13 = $db->prepare("SELECT * FROM hub_info WHERE hub_id = ?");
                    $stmt13->bind_param("i", $row_id);
                    $stmt13->execute();
                    $result13 = $stmt13->get_result();
                    if ($result13->num_rows > 0) {
                        while ($row13 = $result13->fetch_assoc()) {
                            $name = $row13['hub_name'];
                            $all_hubs .= "<tr style='text-align:center' onclick='changeHub($row_id)'><td class='hub_row'>$name</td></tr>";
                        }
                    }
                }
            }
            $all_hubs .= "</table>";
            $icon = "none";

            //GET ROOMS LINKED TO HUB_ID AND ADD TURN OFF ALL DEVICES BUTTON

            $stmt11 = $db->prepare("SELECT * FROM room_info WHERE hub_id = ?");
            $stmt11->bind_param("i", $hub_id);
            $stmt11->execute();
            $result11 = $stmt11->get_result();
            if ($result11->num_rows >= 1) {
                $all11 = $result11->fetch_all(MYSQLI_ASSOC);
                foreach($all11 as $row11){
                    $id_room = $row11['room_id'];
                    $room_on = 0;

                    $stmt10 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ? AND room_id = ?");
                    $stmt10->bind_param("ii", $hub_id, $id_room);
                    $stmt10->execute();
                    $result10 = $stmt10->get_result();
                    if ($result10->num_rows >= 1) {
                        $all10 = $result10->fetch_all(MYSQLI_ASSOC);
                        foreach($all10 as $row10){
                            $device_id = $row10['device_id'];
                            if($row10['device_status'] > 0){
                                $room_on = 1;
                                $count++;
                                $timers .= "startTimer($device_id, 'hour_home', 'minute_home');";
                                $all_homes .= "refreshDevice($device_id);";
                            }
                        }
                    }
                    if($room_on == 1){
                        $icon = "flex";
                        $all_homes .= "toggleRoom($hub_id,$id_room);";
                        $all_homes .= "refreshRoom($id_room);";
                    }
                }
            }
            $timer = "<i class='far fa-clock'></i>&nbsp;";

            $all_homes .= "refreshHomeButton();";


            //MAIN SCREEN PRINTING
            $html .= <<<html
            <!-- Accordion card -->
            
            <div class="modal modalStatsWrap" id="hub_select">
                <div class="modalContent modalStats" id="">
                    <div class="x-adjust"><i class="stats_icon_x " id="" style="display:flex" onclick="openModalHome('hub_select')"><i class="fas fa-times"></i></i>
                    </div>
                    <div class="modalHeader"><strong>Change Hub</strong></div>
                    <div class="modalBody">
                    </div>
                    <!-- a list of hubs-->
                    <div class="modalSub">
                        Available Hubs
                    </div>
                    $all_hubs
                </div>
            </div>

            <div class="card col-lg">
            <!-- Card header -->
                <div class="card-header" role="tab" id="heading$hub_id">
                    <a data-toggle="collapse" data-parent="#accordionEx194" aria-expanded="true" aria-controls="collapse4">
                        <h3 class="mb-0 mt-3 red-text">
                            <div class="row">
                            <!--hub names-->
                                <div class="col-auto mr-auto"><strong>$hub_name</strong></div>
                            </div>
                        </h3>
                    </a>
                </div>





                <!-- new buttons -->
                    <div class="row justify-content-center" id="top-buttons" style="padding: 20px;padding-bottom: 5px;">
                        <!--left col-->
                        $change_button
                        
                        <!--left col-->
                        $change_costings

                        <!--right col-->
                        $home_button_style
                            <div id="home_devices" class="home-right" style="text-align:center;">
                          
                            <!--right button-->
                            <!--function call-->
                                <div id="home_off_content" onclick="$all_homes">
                                        
                                    <div id="home_loader" class="loader"></div>
                                                
                                    <!--right text-->
                                    <div id="home_button_text">
                                    <!--method for turning all device off in a home-->
                                        <strong class="room_icon">    
                                            <i class="fa fa-home"></i>
                                            <br>Turn Off Home <br>
                                            <strong style="color:black">$count $s_or_not on </strong>
                                            <strong class="timer_icon" id="timer_home" style="display:$icon;color:black;margin-right:15px;" onclick="openModal('modal_timer_home', 'timer_x_home')">$timer</strong>
                                        </strong>
                                                    
                                    </div> 
                                </div>   
                            </div>
                        </div>
                        <!--right col end -->   
                    </div>     
                <!-- new buttons -->

            <div class="modal modalTimer" id="modal_timer_home">
                <!--todo comment this-->                   
                <div class="modalContent modalContentTimer" id="content_timer_home"> 
                    <div class="x-adjust">
                        <strong class="timer_icon_x" id="timer_x_home" onclick="openModal('modal_timer_home','timer_x_home')"><i class="fas fa-times"></i></strong></div>
                        <div class="modalHeader"><strong>Turn off<br><strong style="font-size:20px">Home</strong></strong></div>
                        <div class="modalMain" id="timer_none">
                            <div class="timer-end" id="timer_end_home"><strong></strong></div>
                                <form>
                                    <div class="timerModal">
                                        <select id="hour_home" name="energy_cost" class="form-control-sm dropdown validate drop-up">
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

                                        <select id="minute_home" name="energy_cost" class="form-control-sm dropdown validate drop-up">
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
                                    <p class="timerBtn btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" onclick="$timers;styleHomeTimer();">Start Timer</p>
                                </div>

                                        

                            </div>
                            <i class="fas fa-check" id="timer-tick" style="margin-left:calc(50% - 40px);width:90px;height:80px;color:black;font-size:75px;display:none;"></i>
                        </div>
                    </div>

            <hr id="button_seperator" style="margin-bottom: 0;">

                <!-- Card body -->               
                <div id="collapse$hub_id" class="collapse show" role="tabpanel" aria-labelledby="heading$hub_id" data-parent="#accordionEx194">
                    <div class="card-body pt-0 justify-content-center ">
                <div class="container">   
                        <!--coll 1-->
                <div class="row"
                </div>     
                    <div class="col-lg-6 swipe" id="overview">
                        <h4 class="section-title">Cost Overview</h4>
                        <table class="stats-table">
                            <!--energy costing-->
                            <tr class="stats-row">
                                <td class="stats-left"><strong>&ensp;Daily Usage:</strong></td>
                                <td class="stats-right">$energy_last_day kWh&ensp;</td>
                            </tr>
                            <tr class="stats-row">
                                <td class="stats-left"><strong>&ensp;Cost:</strong></td>
                                <td class="stats-right"><strong>£$cost_day_round&ensp;</strong></td>
                            </tr>
                            <tr class="stats-row">
                                <td class="stats-left"><strong>&ensp;Monthly Usage:&ensp;&ensp;</strong></td>
                                <td class="stats-right">$energy_last_month kWh&ensp;</td>
                            </tr>
                            <tr class="stats-row">
                                <td class="stats-left"><strong>&ensp;Cost:</br>&ensp;Remaining Budget:</strong></td>
                                <td class="stats-right double-stat"><strong>£$cost_month_round&ensp;</br>£$budget_remaining_round&ensp;</strong></td>
                            </tr>
                            <tr class="stats-row">
                                <td class="stats-left"><strong>&ensp;Annual Usage:</strong></td>
                                <td class="stats-right">$energy_last_year kWh&ensp;</td>
                            </tr>
                            <tr class="stats-row">
                                <td class="stats-left"><strong>&ensp;Cost:</strong></td>
                                <td class="stats-right"><strong>£$cost_year_round&ensp;</strong></td>
                            </tr>
                        </table>
                        <small class="form-text text-muted mb-4" style="text-align:center">Costing at £$energy_cost_round per kWh</small>                
                    </div>
                    
                    <!--col 1-->
                    
                    <hr id="separater1">
                    
                    <!--col 2-->
                    <!--force doughnuts to update on page load -->
                    <script>
                    document.onload(myLineChart.update();)
                    </script>
                    <!--energy costing-->
                    <div class="card col-lg-6 border border-0 " id="expenditure">
                    <!--Carousel Container--> 
                        <h4 class="section-title ">Expenditure</h4>
                            <div id="chart-carousel" class="carousel slide " data-ride="carousel">
                                <!--Donut carousel-->
                                <div class="carousel-inner ">
                                
                                    <!--Donut 1-->
                                            <div class="carousel-item  active">                           
                                                <div class="col " style="max-width:100%">
                                                    <h4 class="text-centre text-dark centre-text">Daily</h4>
                                                    
                                                    <canvas class="" style="max-width:50% min-width:30%" id="heatingUsage"></canvas>
                                                    
                                                    <script>
                                                        //doughnut chart script
                                                        var ctxD = document.getElementById("heatingUsage").getContext("2d");
                                                        var myLineChart = new Chart(ctxD, {
                                                        type: "doughnut",
                                                        data: {
                                                        labels: ["Spent [£]", "Remaining [£]"],
                                                        datasets: [{
                                                        data: [$cost_day_round, $budget_day_remaining_round],
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
                                    <!--Donut 1-->                                                    
                                        
                                    <!--Donut 2-->             
                                            <div class="carousel-item ">
                                                <div class="col ">
                                                
                                                <h4 class="text-centre text-dark centre-text ">Monthly</h4>
                                                <canvas class="" style="max-width:50% min-width:30%" id="heatingUsage1"></canvas>
                                                
                                                <script>
                                                    //doughnut chart script
                                                    var ctxD = document.getElementById("heatingUsage1").getContext("2d");
                                                    var myLineChart = new Chart(ctxD, {
                                                    type: "doughnut",
                                                    data: {
                                                    labels: ["Spent [£]", "Remaining [£]"],
                                                    datasets: [{
                                                    data: [$cost_month_round, $budget_remaining_round],
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
                                    <!--Donut 2-->    
                                    
                                    <!--Donut 3-->             
                                            <div class="carousel-item ">
                                                <div class="col " style="max-width:100%">
                                                    <h4 class="text-centre text-dark centre-text ">Yearly</h4>
                                                    <canvas class="" style="max-width:50% min-width:30%" id="heatingUsage2"></canvas>
                                                    <script>
                                                        //doughnut chart script
                                                        var ctxD = document.getElementById("heatingUsage2").getContext("2d");
                                                        var myLineChart = new Chart(ctxD, {
                                                        type: "doughnut",
                                                        data: {
                                                        labels: ["Spent [£]", "Budget [£]"],
                                                        datasets: [{
                                                        data: [$cost_year_round, $budget_year_remaining_round],
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
                                    <!--Donut 3--> 
                                     
                                    <!--buttons for Donut carousel -->
                                        <a class="carousel-control-prev " href="#chart-carousel" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon ">
                                                    <i class="fas fa-angle-double-left"></i></span>
                                                <span class="sr-only ">Previous</span>
                                        </a>
                                        
                                        <a class="carousel-control-next " href="#chart-carousel" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon ">
                                                <i class="fas fa-angle-double-right"></i></span>
                                            <span class="sr-only ">Next</span>
                                        </a>  
                                                
                                </div>
                                <!--Donut carouse endl-->
                                <script>
                                    //enabling touch controls
                                    $('.carousel').carousel({
                                    touch: true // default
                                    });
                                </script>

                                    <small class="form-text text-muted mb-4 text" style="text-align:center">Budget of £$budget_round per Month</small>
                            </div>
                            <!--Carousel Container-->
                    </div>
                    <!--col 2-->
                    
                    <hr id="separater2">

                    <!--col 3-->

                    <div class="col-lg swipe" id="graph">
                    <h4 class="section-title overview">Power Usage</h4>
                    <!--Place holder for large graph if screen is to small-->
                    <div class="orientation">
                        <img src="../img/orientation.png" class="tilt-icon">
                        <div>Please rotate phone to view graph </div>
                    </div>
                            
                            <div class="container landscape">
                                    <!--change chart drop down-->
                                    <select id="chartPicker" class="browser-default custom-select dropdown">
                                        <option selected="selected" value="2">Time period: Today</option>
                                        <option value="1">Time period: Current Month</option>
                                        <option value="0">Time period: Current Year</option>
                                    </select>
                            <!--chart canvas-->        
                            <canvas id="masterLineChart"></canvas>
                            <small class="form-text text-muted mb-4" style="text-align:center">Graph will automatically populate over time</small>

                            <script type="text/javascript">                                      
                                //Supplied Datasets to display
                                //hourly 1 upto 24
                                let data1 = { "labels": $DataLabelsYearEncoded,"label": "Expected Usage: ", "datasets": [{ "label": "Energy Generated [kWh]", "data": $dataGenYearEncoded, "backgroundColor": "rgba(226, 183, 28, 0.4)", "borderColor": "rgb(226, 183, 28)", "borderWidth": 2 },{ "label": "Energy Used [kWh]", "data": $dataPointsYearEncoded, "backgroundColor": "rgb(56,56,56)", "borderColor": "rgba(56, 56, 56, 1)", "borderWidth": 1 }] };
                                let axis1 = { elements: {point:{radius: 0}}, tooltips: {enabled: false}, scales: { yAxes: [{ scaleLabel: { display: true, fontSize: 20, labelString: 'Energy [ kWh ]'}}], xAxes: [{ scaleLabel: { display: true, fontSize: 20, labelString: 'Months'}}]} }
                                
                                //days upto 31 days
                                let data2 = { "labels": $DataLabelsMonthEncoded,"label": "Expected Usage:", "datasets": [{ "label": "Energy Generated [kWh]", "data": $dataGenMonthEncoded, "backgroundColor": "rgba(226, 183, 28, 0.4)", "borderColor": "rgb(226, 183, 28)", "borderWidth": 2 },{ "label": "Energy Used [kWh]", "data": $dataPointsMonthEncoded, "backgroundColor": "rgb(56,56,56)", "borderColor": "rgba(56, 56, 56, 1)", "borderWidth": 1 }] };
                                let axis2 = { elements: {point:{radius: 0}}, tooltips: {enabled: false}, scales: { yAxes: [{ scaleLabel: { display: true, fontSize: 20, labelString: 'Energy [ kWh ]'}}], xAxes: [{ scaleLabel: { display: true, fontSize: 20, labelString: 'Days'}}]} }
                                
                                //months upto 12
                                let data3 = { "labels": $DataLabelsDayEncoded,"label": "Expected Usage: ", "datasets": [{ "label": "Energy Generated [kWh]", "data": $dataGenDayEncoded, "backgroundColor": "rgba(226, 183, 28, 0.4)", "borderColor": "rgb(226, 183, 28)", "borderWidth": 2 },{ "label": "Energy Used [kWh]", "data": $dataPointsDayEncoded, "backgroundColor": "rgb(56,56,56)", "borderColor": "rgba(56, 56, 56, 1)", "borderWidth": 1 }] };
                                let axis3 = { elements: {point:{radius: 0}}, tooltips: {enabled: false}, scales: { yAxes: [{ scaleLabel: { display: true, fontSize: 20, labelString: 'Energy [ kWh ]'}}], xAxes: [{ scaleLabel: { display: true, fontSize: 20, labelString: 'Hours'}}]} }

                                // Draw the initial chart
                                let ctxL = $("#masterLineChart")[0].getContext('2d');
                                    let masterLineChart = new Chart(ctxL, {
                                        type: 'line',
                                        data: data3,
                                        options: axis3
                                    });
                        
                            // Called on Change :used to swap between diffrent data sets
                            $(document).ready(function(){
                                $("select.dropdown").change(function(){
                                    let selectedChart = $(this).children("option:selected").val();
                                    
                                    if (selectedChart ==0){
                                    masterLineChart["config"]["data"] = data1; //<--- THIS WORKS!
                                    masterLineChart["options"] = axis1;
                                    masterLineChart.update();
                                    }else if (selectedChart ==1){
                                    masterLineChart["config"]["data"] = data2; //<--- THIS WORKS!
                                    masterLineChart["options"] = axis2;
                                    masterLineChart.update();
                                    } else if (selectedChart ==2){
                                    masterLineChart["config"]["data"] = data3; //<--- THIS WORKS!
                                    masterLineChart["options"] = axis3;
                                    masterLineChart.update();
                                    }
                                });
                            });

                        </script>
                        
                        </div>
                    </div>
                    
                    
                            
                    
                    <!--col 3-->
                </div>
                        </div> 
                    </div>
                </div>
            </div>
        
        
                            
            <!-- Accordion card -->
html;
        }
        $stmtHub->close();

            


    }

    $html .= "</div>";

    return $html;

}

?>

