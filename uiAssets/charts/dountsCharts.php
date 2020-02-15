<!--todo test?-->
<!-- Wrapper for slides -->
<div class="carousel-inner">
    <div class="carousel-item active">
        <div id="chartContainer1" class="chart" style="width:100%;height: 300px"></div>
    </div>
    <div class="carousel-item">
        <div id="chartContainer2" class="chart" style="width:100%; height: 300px"></div>
    </div>
    <div class="carousel-item">
        <div id="chartContainer3" class="chart" style="width:100%; height:300px;"></div>
    </div>
</div>

<!-- Left and right controls -->
<a class="carousel-control-prev" href="#chart-carousel" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#chart-carousel" data-slide="next">
    <span class="carousel-control-next-icon"></span>
</a>
<canvas style="max-width:50% min-width:30%" id="heatingUsage"></canvas>
<script>

</script>

<div class="col border border-primary rounded m-2">
    <h4 class="text-centre align-middle">Monthly</h4>
    <canvas style="max-width:50% min-width:30%" id="heatingUsage1"></canvas>
    <script>

    </script>

</div>
<div class="col border border-primary rounded m-2">
    <h4 class="text-centre align-middle">Variance</h4>
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


</div>
<!-- Carousel -->

<script>

    var charts = [];
    var chart;

    $('.carousel').carousel({
        interval: 2000
    });

    $('.carousel').on('slide.bs.carousel', function (e) {
        $(".carousel-inner").height(parseFloat(charts[e.to].container.style.height));
    });

    $('.carousel').on('slid.bs.carousel', function (e) {
        charts[e.to].render();
    });

    //doughnut
    var ctxD = document.getElementById("heatingUsage").getContext("2d");
    var heaingChart1 = new Chart(ctxD, {
        type: "doughnut",
        data: {
            labels: ["Spent [£]", "Remaining [£]"],
            datasets: [{
                data: [$cost_day, $cost_variance],
                backgroundColor: ["#F7464A", "#D3D3D3"],
                hoverBackgroundColor: ["#FF5A5E", "#D3D3D3"]
            }]
        },
        options: {
            responsive: true
        }
    });
    heaingChart1.render();
    charts.push(heaingChart1);

    //doughnut
    var ctxD = document.getElementById("heatingUsage1").getContext("2d");
    var heaingChart2 = new Chart(ctxD, {
        type: "doughnut",
        data: {
            labels: ["Spent [£]", "Remaining [£]"],
            datasets: [{
                data: [$cost_month, $cost_variance],
                backgroundColor: ["#F7464A", "#D3D3D3"],
                hoverBackgroundColor: ["#FF5A5E", "#D3D3D3"]
            }]
        },
        options: {
            responsive: true
        }
    });
    charts.push(heaingChart2);

    var chart3 = new CanvasJS.Chart("chartContainer3",
        {
            title: {
                text: "Column Chart 3"
            },
            data: [{
                type: "column",
                dataPoints: [
                    {x: 10, y: 71},
                    {x: 20, y: 55},
                    {x: 30, y: 50},
                    {x: 40, y: 65},
                    {x: 50, y: 95},
                    {x: 60, y: 68},
                    {x: 70, y: 28},
                    {x: 80, y: 34},
                    {x: 90, y: 14}
                ]
            }
            ]
        });
    charts.push(chart3);

</script>