<?php

function generateHomeTab(){

    $html = '<div class="accordion md-accordion z-depth-1-half" id="accordionEx194" role="tablist" aria-multiselectable="true">';
    $x = 1;
    //for building more than one chart
    $chartId = "chartId" . $x . "";

    while ($x <= 1) {
        //TODO fix drop dowp fucntion
        $html .= '
        <!-- Accordion card -->
            <div class="card">
            <!-- Card header -->
                <div class="card-header" role="tab" id="heading' . $x . '">
                    <a data-toggle="collapse" data-parent="#accordionEx194" href="#collapse' . $x . '" aria-expanded="true" aria-controls="collapse4">
                        <h3 class="mb-0 mt-3 red-text">
                            <div class="row">
                                <div class="col-auto mr-auto">My Home</div>
                                <div class="col-auto"><i class="fas fa-angle-down rotate-icon fa-2x"></i></div>

                            </div>
                        </h3>
                    </a>
                </div>

                <!-- Card body -->
                <div id="collapse' . $x . '" class="collapse show" role="tabpanel" aria-labelledby="heading' . $x . '" data-parent="#accordionEx194">
                    <div class="card-body pt-0">
                        <div class="flex-sm-row justify-content-center">     
                            <div class="container">
                                <div class="row row-cols-2 mb-1">
                                    <div class="col border border-primary">
                                        <h3>Heating Usage</h3>
                                        <canvas id="heatingUsage"></canvas>
                                        <script>
                                            //doughnut
                                            var ctxD = document.getElementById("heatingUsage").getContext("2d");
                                            var myLineChart = new Chart(ctxD, {
                                            type: "doughnut",
                                            data: {
                                            labels: ["Red"],
                                            datasets: [{
                                            data: [200, 100],
                                            backgroundColor: ["#F7464A", "#FFFFFF00"],
                                            hoverBackgroundColor: ["#FF5A5E", "#FFFFFF00"]
                                            }]
                                            },
                                            options: {
                                            responsive: true
                                            }
                                            });
                                        </script>
                                    </div>
                                    <div class="col border border-primary">
                                        <h3>Heating Usage</h3>
                                        <canvas id="heatingUsage1"></canvas>
                                        <script>
                                            //doughnut
                                            var ctxD = document.getElementById("heatingUsage1").getContext("2d");
                                            var myLineChart = new Chart(ctxD, {
                                            type: "doughnut",
                                            data: {
                                            labels: ["Red"],
                                            datasets: [{
                                            data: [200, 100],
                                            backgroundColor: ["#F7464A", "#FFFFFF00"],
                                            hoverBackgroundColor: ["#FF5A5E", "#FFFFFF00"]
                                            }]
                                            },
                                            options: {
                                            responsive: true
                                            }
                                            });
                                        </script>
                                    </div>
                                    <div class="col border border-primary">
                                        <h3>Heating Usage</h3>
                                        <canvas id="heatingUsage2"></canvas>
                                        <script>
                                            //doughnut
                                            var ctxD = document.getElementById("heatingUsage2").getContext("2d");
                                            var myLineChart = new Chart(ctxD, {
                                            type: "doughnut",
                                            data: {
                                            labels: ["Red"],
                                            datasets: [{
                                            data: [200, 100],
                                            backgroundColor: ["#F7464A", "#FFFFFF00"],
                                            hoverBackgroundColor: ["#FF5A5E", "#FFFFFF00"]
                                            }]
                                            },
                                            options: {
                                            responsive: true
                                            }
                                            });
                                        </script>
                                    </div>
                                    <div class="col border border-primary">
                                        <h3>Heating Usage</h3>
                                        <canvas id="heatingUsage3"></canvas>
                                        <script>
                                            //doughnut
                                            var ctxD = document.getElementById("heatingUsage3").getContext("2d");
                                            var myLineChart = new Chart(ctxD, {
                                            type: "doughnut",
                                            data: {
                                            labels: ["Red"],
                                            datasets: [{
                                            data: [200, 100],
                                            backgroundColor: ["#F7464A", "#FFFFFF00"],
                                            hoverBackgroundColor: ["#FF5A5E", "#FFFFFF00"]
                                            }]
                                            },
                                            options: {
                                            responsive: true
                                            }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <!--Grid column-->
                            <!--Date select
                            <p class="lead align-content-center">
                                <span class="badge info-color-dark p-2">Date range</span>
                            </p>-->
                                <select class="browser-default custom-select">
                                <option selected>Choose time period</option>
                                <option value="1">Week</option>
                                <option value="2">Month</option>
                                <option value="3">Year</option>
                            </select>
                        </div>                        
                        <canvas id="lineChart_Year"></canvas>
                    </div>
                </div>
            </div>
        <!-- Accordion card -->
        ';//echo end
        $x++;//+1 to x for steting
    }

    $html .= "</div>";
    require "charts/lineChart_Year.php";
    require "charts/lineChart_Month.php";
    require "charts/lineChart_Day.php";
    $html .= generateLineChart_Year();
    $html .= generateLineChart_Month();
    $html .= generateLineChart_Day();
    
    return $html;
}

?>
