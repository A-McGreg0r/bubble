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

            $energy_last_day = $energy_last_day / 1000;

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

            $energy_last_month = $energy_last_month / 1000;

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

            $energy_last_year = $energy_last_year / 1000;

            //-----------------------------CALCULATE DATA FOR GRAPH PLOTTING-----------------------------------
            $dataPoints = array();
            $dataPoints = array();
            $AvgPoints = array();
            $dataLabels = array();
            $count = 0;

            $stmt7 = $db->prepare("SELECT * FROM monthly_data WHERE hub_id = ?");
            $stmt7->bind_param("i", $hub_id);
            $stmt7->execute();
            $result7 = $stmt7->get_result();
            if ($result7->num_rows >= 1) {
                $n = 0;
                $all7 = $result7->fetch_all(MYSQLI_ASSOC);
                foreach($all7 as $row7){
                    $n = $n + 1;
                    $energy_usage7 = $row7['energy_usage']/1000;
                    $month7 = $row7['entry_month'];
                    $count = $count + $energy_usage7;
                    array_push($dataPoints, array($energy_usage7));
                    array_push($dataLabels, array($month7));
                }
                for($i = 0; $i < sizeof($dataPoints); $i++){
                    array_push($AvgPoints,money_format('%.3n',$count/$n));
                }
            }
            $cost_year = $energy_last_year * $energy_cost;
            $cost_year_round = number_format($cost_year,2);
            $DataLabelsYearEncoded = json_encode($dataLabels);
            $dataPointsYearEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);
            $dataAvgYearEncoded = json_encode($AvgPoints, JSON_NUMERIC_CHECK);


            $dataPoints = array();
            $dataPoints = array();
            $AvgPoints = array();
            $dataLabels = array();
            $count = 0;

            $stmt8 = $db->prepare("SELECT * FROM daily_data");
            $stmt8->execute();
            $result8 = $stmt8->get_result();
            if ($result8->num_rows >= 1) {
                $n = 0;
                $all8 = $result8->fetch_all(MYSQLI_ASSOC);
                foreach($all8 as $row8){
                    $n = $n + 1;
                    $energy_usage8 = $row8['energy_usage']/1000;
                    $day8 = $row8['entry_day'];
                    $count = $count + $energy_usage8;
                    array_push($dataPoints, array($energy_usage8));
                    array_push($dataLabels, array($day8));
                }
                for($i = 0; $i < sizeof($dataPoints); $i++){
                    array_push($AvgPoints,money_format('%.3n',$count/$n));
                }
            }
            $cost_month = $energy_last_month * $energy_cost;
            $cost_month_round = number_format($cost_month,2);
            $DataLabelsMonthEncoded = json_encode($dataLabels);
            $dataPointsMonthEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);
            $dataAvgMonthEncoded = json_encode($AvgPoints, JSON_NUMERIC_CHECK);

            $dataPoints = array();
            $dataPoints = array();
            $AvgPoints = array();
            $dataLabels = array();
            $count = 0;

            $stmt9 = $db->prepare("SELECT * FROM hourly_data");
            $stmt9->execute();
            $result9 = $stmt9->get_result();
            if ($result9->num_rows >= 1) {
                $n = 0;
                $all9 = $result9->fetch_all(MYSQLI_ASSOC);
                foreach($all9 as $row9){
                    $n = $n + 1;
                    $energy_usage9 = $row9['energy_usage']/1000;
                    $hour9 = $row9['entry_hour'];
                    $count = $count + $energy_usage9;
                    array_push($dataPoints, array($energy_usage9));
                    array_push($dataLabels, array($hour9));
                }
                for($i = 0; $i < sizeof($dataPoints); $i++){
                    array_push($AvgPoints,money_format('%.3n',$count/$n));
                }
            }
            $cost_day = $energy_last_day * $energy_cost;
            $cost_day_round = number_format($cost_day,2);
            $DataLabelsDayEncoded = json_encode($dataLabels);
            $dataPointsDayEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);
            $dataAvgDayEncoded = json_encode($AvgPoints, JSON_NUMERIC_CHECK);

            $energy_cost_round = number_format($energy_cost,2);
            $budget_round = number_format($budget,2);
            $budget_remaining = $budget - $cost_month;
            $budget_remaining_round = number_format($budget_remaining,2);

            $budget_day = $budget / 28;
            $budget_year = $budget * 12;
            $budget_day_remaining = $budget_day - $cost_day;
            $budget_year_remaining = $budget_year - $cost_year;
            $budget_day_remaining_round = number_format($budget_day_remaining,2);
            $budget_year_remaining_round = money_format('%.2n', $budget_year_remaining);

            $all_homes = "styleHome();";

            $count = 0;
            
            //-----------------------------END CALCULATE DATA FOR GRAPH PLOTTING-----------------------------------


            $s_or_not = "";
            if($count == 1){
                $s_or_not = "device";
            } else {
                $s_or_not = "devices";
            }

            //FIND ALL HUBS REGISTERED TO USER, ADD MODAL AND BUTTONS THAT ALLOW CHANGING BETWEEN HUBS

            $all_hubs = "<table style='width:100%'>";
            $stmt12 = $db->prepare("SELECT * FROM hub_users WHERE user_id = ?");
            $stmt12->bind_param("i", $user_id);
            $stmt12->execute();
            $result12 = $stmt12->get_result();
            if ($result12->num_rows > 0) {
                while ($row12 = $result12->fetch_assoc()) {
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
                                $all_homes .= "refreshDevice($device_id);";
                            }
                        }
                    }
                    if($room_on == 1){
                        $all_homes .= "toggleRoom($hub_id,$id_room);";
                        $all_homes .= "refreshRoom($id_room);";
                    }
                }
            }

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
                                <div class="col-auto mr-auto"><strong>$hub_name</strong></div>
                            </div>
                        </h3>
                    </a>
                </div>


                <!-- Card body -->
                    <table class="home-table">
                        <tr>
                            <td style="width:50%">
                                <div id="reload_device_id" class="home-left" onclick="openModalHome('hub_select')">
                            
                                    <!--Card content-->
                                    <div class="">
                                
                                        <!--Title-->      
                                        <div class="">  
                                            <div id="device_3_device_id" class=" col-md-4" style="">
                                                <strong class="room_icon"><i class="fa fa-home"></i><br></strong><strong>Change House<br><strong style="color:black">$hub_name</strong></strong>
                                            </div>                     
                                        </div>
                                    </div>
                            </div>
                        </td>
                        <td style="width:50%">
                            <div id="home_devices" class="home-right" style="text-align:center">
                        
                                <!--Card content-->
                                <div id="home_off_content" class="" onclick="$all_homes">
                            
                                    <!--Title-->      
                                    <div class=""> 
                                        <div id="home_loader" class="loader">
                                            <div id="home_button_text" class="" style="col-md-4">
                                                <strong class="room_icon"><i class="fa fa-home"></i><br></strong><strong >Turn Off Home <br><strong style="color:black">$count $s_or_not on</strong></strong>
                                            </div>                     
                                        </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <hr>
                
                <div id="collapse$hub_id" class="collapse show" role="tabpanel" aria-labelledby="heading$hub_id" data-parent="#accordionEx194">
                    <div class="card-body pt-0 justify-content-center ">
                <div class="container">   
                        <!--coll 1-->
                <div class="row"
                </div>     
                    <div class="col-lg-6 swipe" id="overview">
                        <h4 class="section-title">Overview</h4>
                        <table class="stats-table">
                            
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
                    <script>
                    document.onload(myLineChart.update();)
                    </script>
                    
                    <div class="card col-lg-6 border border-0 ">
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
                                                        //doughnut
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
                                                    //doughnut
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
                                                    responsive: true
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
                                                        //doughnut
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
                                                        responsive: true
                                                        }
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                    <!--Donut 3-->  
                                    <!--button for Donut carousel -->
                                        <a class="carousel-control-prev " href="#chart-carousel" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon " aria-hidden="false"><i class="fas fa-angle-double-left"></i></span>
                                        <span class="sr-only ">Previous</span>
                                        </a>
                                        <a class="carousel-control-next " href="#chart-carousel" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon " aria-hidden="false"><i class="fas fa-angle-double-right"></i></span>
                                        <span class="sr-only ">Next</span>
                                        </a>  
                                                
                                </div>
                                <!--Donut carousel-->
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

                    <div class="orientation">
                        <img src="../img/orientation.png" class="tilt-icon">
                        <div>Please rotate phone to view graph </div>
                    </div>
                            
                            <div class="container landscape">
                                    <!--change chart drop down-->
                                    <select id="chartPicker" class="browser-default custom-select dropdown">
                                        <option selected="selected">Choose time period</option>
                                        <option value="0">Current Year</option>
                                        <option value="1">Current Month</option>
                                        <option value="2">Today</option>
                                    </select>
                            <!--chart canvas-->        
                            <canvas id="masterLineChart"></canvas>
                            <small class="form-text text-muted mb-4" style="text-align:center">Graph will automatically populate over time</small>

                            <script type="text/javascript">
                                //todo cahe where datas comeing from                                         
                                //Supplied Datasets to display
                                //hourly 1 upto 24
                                //TODO change expected usage to power genarated once implmented
                                let data1 = { "labels": $DataLabelsYearEncoded,"label": "Expected Usage: ", "datasets": [{ "data": $dataAvgYearEncoded, "backgroundColor": "rgba(109, 171, 166, 0)", "borderColor": "rgb(226, 183, 28)", "borderWidth": 2 },{ "label": "Power Usage [kWh]", "data": $dataPointsYearEncoded, "backgroundColor": "rgb(56,56,56)", "borderColor": "rgba(56, 56, 56, 1)", "borderWidth": 1 }] };
                                //days upto 31 days
                                let data2 = { "labels": $DataLabelsMonthEncoded,"label": "Expected Usage:", "datasets": [{ "label": "Average", "data": $dataAvgMonthEncoded, "backgroundColor": "rgba(109, 171, 166, 0)", "borderColor": "rgb(226, 183, 28)", "borderWidth": 2 },{ "label": "Power Usage [kWh]", "data": $dataPointsMonthEncoded, "backgroundColor": "rgb(56,56,56)", "borderColor": "rgba(56, 56, 56, 1)", "borderWidth": 1 }] };
                                //months upto 12
                                let data3 = { "labels": $DataLabelsDayEncoded,"label": "Expected Usage: ", "datasets": [{ "label": "Average", "data": $dataAvgDayEncoded, "backgroundColor": "rgba(109, 171, 166, 0)", "borderColor": "rgb(226, 183, 28)", "borderWidth": 2 },{ "label": "Power Usage [kWh]", "data": $dataPointsDayEncoded, "backgroundColor": "rgb(56,56,56)", "borderColor": "rgba(56, 56, 56, 1)", "borderWidth": 1 }] };
                                

                                // Draw the initial chart
                                let ctxL = $("#masterLineChart")[0].getContext('2d');
                                    let masterLineChart = new Chart(ctxL, {
                                        type: 'line',
                                        data: data3,
                                        options: {
                                            scales: {
                                                yAxes: [{
                                                    ticks: {
                                                        beginAtZero: true
                                                    }
                                                }]
                                            }
                                        }
                                    });
                        
                            // Called on Change
                            $(document).ready(function(){
                                $("select.dropdown").change(function(){
                                    let selectedChart = $(this).children("option:selected").val();
                                    
                                    if (selectedChart ==0){
                                    masterLineChart["config"]["data"] = data1; //<--- THIS WORKS!
                                    masterLineChart.update();
                                    }else if (selectedChart ==1){
                                    masterLineChart["config"]["data"] = data2; //<--- THIS WORKS!
                                    masterLineChart.update();
                                    } else if (selectedChart ==2){
                                    masterLineChart["config"]["data"] = data3; //<--- THIS WORKS!
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

