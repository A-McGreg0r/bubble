<?php
$stmt2 = $db->prepare("SELECT * FROM test_data WHERE hub_id = ?");
$stmt2->bind_param("i", $hub_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2->num_rows === 1) {
    $row2 = $result2->fetch_assoc();
    $cost_day = $row2['cost_day'];
    $cost_month = $row2['cost_month'];
    $cost_total = $row2['cost_total'];
    $cost_variance = $cost_total - $cost_month;
}

$html .= <<<html

<div id="chart-carousel" class="carousel slide" data-ride="carousel" >
    <!--Donut carousel-->
    <div class="carousel-inner">

        <!--Donut 1-->
        <div class="carousel-item active">
            <div class="col border border-primary rounded m-2">
                <h4 class="text-centre justify-content-center text-dark">Daily</h4>

                <canvas style="max-width:50% min-width:30%" id="heatingUsage"></canvas>

                <script>
                    //doughnut
                    var ctxD = document.getElementById("heatingUsage").getContext("2d");
                    var myLineChart = new Chart(ctxD, {
                        type: "doughnut",
                        data: {
                            labels: ["Spent [£]", "Remaining [£]"],
                            datasets: [{
                                data: [$cost_day, $cost_variance],
                                backgroundColor: ["#F7464A", "#D3D3D3"],
                                hoverBackgroundColor: ["#FF5A5E", "#D3D3D3"]
                            };]
                        },
                        {
                            true
                        }
                    })
                </script>
            </div>
        </div>
        <!--Donut 1-->

        <!--Donut 2-->
        <div class="carousel-item">
            <div class="col border border-primary rounded m-2">

                <h4 class="text-centre align-middle text-dark">Monthly</h4>

                <canvas style="max-width:50% min-width:30%" id="heatingUsage1"></canvas>

                <script>
                    //doughnut
                    var ctxD = document.getElementById("heatingUsage1").getContext("2d");
                    var myLineChart = new Chart(ctxD, {
                        type: "doughnut",
                        data: {
                            labels: ["Spent [£]", "Remaining [£]"],
                            datasets: [{
                                data: [$cost_month, $cost_variance],
                                backgroundColor: ["#F7464A", "#D3D3D3"],
                                hoverBackgroundColor: ["#FF5A5E", "#D3D3D3"]
                            };]
                        },
                        {
                            true
                        }
                    })
                </script>
            </div>

        </div>
        <!--Donut 2-->

        <!--Donut 3-->
        <div class="carousel-item">
            <div class="col border border-primary rounded m-2">
                <h4 class="text-centre align-middle text-dark">Variance</h4>
                <canvas style="max-width:50% min-width:30%" id="heatingUsage2"></canvas>
                <script>
                    //doughnut
                    var ctxD = document.getElementById("heatingUsage2").getContext("2d");
                    var myLineChart = new Chart(ctxD, {
                        type: "doughnut",
                        data: {
                            labels: ["Budget [£]", "Variance [£]"],
                            datasets: [{
                                data: [$cost_total, $cost_variance],
                                backgroundColor: ["#F7464A", "#D3D3D3"],
                                hoverBackgroundColor: ["#FF5A5E", "#D3D3D3"]
                            };]
                        },
                        {
                            true
                        }
                    })
                </script>
            </div>
        </div>
        <!--Donut 3-->
    </div>
    <!--Donut carousel-->
    <script>
        //enabling touch controls
        $('.carousel').carousel({
            touch: true // default
        });
    </script>
</div>
<!--Carousel Container-->
html;
$stmt2->close();

$html .= "</div>";

return $html;