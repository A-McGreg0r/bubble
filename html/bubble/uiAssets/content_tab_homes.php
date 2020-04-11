<?php
include_once dirname(__DIR__) . '/required/config.php';

function generateHomeTab()
{
    global $db;
    $html = '<div class="accordion md-accordion z-depth-1-half" id="accordionEx194" role="tablist" aria-multiselectable="true">';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        session_write_close();
        $stmt3 = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmt3->bind_param("i", $user_id);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        if ($result3->num_rows === 1) {
            extract($result3->fetch_assoc());
        }

        $stmt = $db->prepare("SELECT * FROM hub_users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hub_id = $row['hub_id'];
                $stmt1 = $db->prepare("SELECT * FROM hub_info WHERE hub_id = ?");
                $stmt1->bind_param("i", $hub_id);
                $stmt1->execute();
                $result1 = $stmt1->get_result();

                if ($result1->num_rows === 1) {
                    $row1 = $result1->fetch_assoc();
                    $hub_name = $row1['hub_name'];
                    if (empty($hub_name)) {
                        $hub_name = "My Home";
                    }



                    $day = date("d");
                    $energy_last_day = 0;

                    $stmt4 = $db->prepare("SELECT * FROM hourly_data WHERE hub_id = ? AND entry_day = ?");
                    $stmt4->bind_param("ii", $hub_id, $day);
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

                    $dataPoints = array();
                    $dataPoints = array();
                    $AvgPoints = array();
                    $dataLabels = array();

                    $energy_last_year = 0;

                    $stmt6 = $db->prepare("SELECT * FROM monthly_data WHERE hub_id = ?");
                    $stmt6->bind_param("i", $hub_id);
                    $stmt6->execute();
                    $result6 = $stmt6->get_result();
                    if ($result6->num_rows >= 1) {
                        $count=0;
                        $n = 0;
                        $all6 = $result6->fetch_all(MYSQLI_ASSOC);

                        foreach($all6 as $row6){
                            $energy_last_year = $energy_last_year + $row6['energy_usage'];

                            $n = $n + 1;
                            $energy_usage7 = $row6['energy_usage']/1000;
                            $month7 = $row6['entry_month'];
                            $count = $count + $energy_usage7;
                            array_push($dataPoints, array($energy_usage7));
                            array_push($dataLabels, array($month7));
                        }
                        for($i = 0; $i < sizeof($dataPoints); $i++){
                            array_push($AvgPoints,money_format('%.3n',$count/$n));
                        }
                    }
                    $energy_last_year = $energy_last_year / 1000;
                    $cost_year = $energy_last_year * $energy_cost;//bug?

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
                    $DataSumMonthEncoded = json_encode(array_sum($dataPoints), JSON_NUMERIC_CHECK);
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

                    $command = escapeshellcmd('/required/email/myemail.py');
                    $output = shell_exec($command);
                    echo $output;

                    $html .= <<<html
                    <!-- Accordion card -->
                    
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
                        <div id="collapse$hub_id" class="collapse show" role="tabpanel" aria-labelledby="heading$hub_id" data-parent="#accordionEx194">
                            <div class="card-body pt-0 justify-content-center ">
                        <div class="container">   
                             <!--coll 1-->
                        <div class="row"
                        </div>     
                            <div class="col-lg-6">
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
                           
                            <div class="card col-lg-6 border border-0">
                            <!--Carousel Container--> 
                                <h4 class="section-title">Expenditure</h4>
                                    <div id="chart-carousel" class="carousel slide" data-ride="carousel">
                                        <!--Donut carousel-->
                                        <div class="carousel-inner">
                                        
                                            <!--Donut 1-->
                                                  <div class="carousel-item active">                           
                                                        <div class="col" style="max-width:100%">
                                                            <h4 class="text-centre text-dark centre-text">Daily</h4>
                                                            
                                                            <canvas style="max-width:50% min-width:30%" id="heatingUsage"></canvas>
                                                            
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
                                                                hoverBackgroundColor: ["rgb(246, 203, 48)", "rgb(76,76,76)"],
                                                                pointHitRadius: [10]
                                                                }]
                                                                },
                                                                options: {
                                                                responsive:true
                                                                }
                                                                });
                                                            </script>
                                                        </div>
                                                  </div>      
                                            <!--Donut 1-->                                                    
                                             
                                            <!--Donut 2-->             
                                                  <div class="carousel-item">
                                                        <div class="col">
                                                        
                                                        <h4 class="text-centre text-dark centre-text">Monthly</h4>
                                                        <canvas style="max-width:50% min-width:30%" id="heatingUsage1"></canvas>
                                                        
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
                                                  <div class="carousel-item">
                                                        <div class="col" style="max-width:100%">
                                                            <h4 class="text-centre text-dark centre-text">Yearly</h4>
                                                            <canvas style="max-width:50% min-width:30%" id="heatingUsage2"></canvas>
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
                                              <a class="carousel-control-prev" href="#chart-carousel" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                              </a>
                                              <a class="carousel-control-next" href="#chart-carousel" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                              </a>  
                                                       
                                        </div>
                                        <!--Donut carousel-->
                                        <script>
                                             //enabling touch controls
                                                $('.carousel').carousel({
                                                touch: true // default
                                                });
                                         </script>

                                         <small class="form-text text-muted mb-4" style="text-align:center">Budget of £$budget_round per Month</small>
                                    </div>
                                    <!--Carousel Container-->
                            </div>
                            <!--col 2-->
                            
                            <hr id="separater2">

                            <!--col 3-->

                            <div class="col-lg">
                            <h4 class="section-title overview">Power Usage</h4>
                                    
                                    <div class="container">
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
                $stmt1->close();

            }
        }

        $stmt->close();
    }

    $html .= "</div>";

    return $html;

}

?>

