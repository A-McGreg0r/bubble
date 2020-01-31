<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<!--TODO intagrate database qurry -->

    //converts php querry to js for graph
<?php
    //TODO remove once data base it implmented
    //randome genarated grapth (temp)

    $numOfHours = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));
    $name = "someString";
    $first = strtotime('first day this month');
    $days = array();
    $data = array();
    $avg = array();

for ($i = 31; $i >= 0; $i--) {
    //list of months
    array_push($months, date('M', strtotime("-$i month", $first)));
    //geanarat rand data for display
    array_push($data, rand(0, 500));
    //a avg of the entire contence of the array
    array_push($php_avg = array_sum($randData) / count($randData));
}
?>

<script>
    var name = <?php echo json_encode($name); ?>;//name of chart
    var labels = <?php echo json_encode($days); ?>;//lables
    var data = <?php echo json_encode($data); ?>;//dataset 1
    var avg = <?php echo json_encode($avg); ?>;//dataset 2 avgrege


    function AdaptiveLineChart(name, labels, data, avg) {
        //converts php querry to js for graph

        let chartId = this.name;
        let lable = this.labels
        let graphdata = this.data;
        let graphavg = this.avg;

        //coulers for all graphs
        const ctxL = document.getElementById(chartId).getContext('2d');
        const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");


        if (ranage.length > 0)//months
        {
            chartId = new Chart(ctxL, {
                type: 'line',
                data: {
                    labels: range,
                    datasets: [{
                        label: "Average Usage",
                        data: graphavg,
                        backgroundColor: [
                            'rgba(0, 137, 132, .0)',
                        ],
                        borderColor: [
                            'rgba(0, 10, 130, .1)',
                        ],
                        borderWidth: 2
                    },
                        {
                            label: "Power Used",
                            data: graphdata,
                            backgroundColor: gradientFill,
                            borderColor: gradientFill,
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true
                }
            });
        }
    }
</script>