<?php
//todo consider seting up dom
//TODO remove once data base it implmented
//randome genarated grapth (temp)
$first = strtotime('first day this month');
//todo replace with querry
$months = array();
$randData = array();
$php_avg = array();
//todo replace with querry
for ($i = 11; $i >= 0; $i--) {
    //list of months
    array_push($months, date('M', strtotime("-$i month", $first)));
    //geanarat rand data for display
    array_push($randData, rand(0, 1000));
    //a avg of the entire contence of the array
    array_push($php_avg = array_sum($randData) / count($randData));
}
//list of months
$php_labals = json_encode($months);
//dataset
$php_Data = json_encode($randData);
//dataset avgrege
$php_avg = json_encode($php_avg);
?>

<script>
    var name = <?php echo json_encode($php_labals); ?>;
    var labels = <?php echo json_encode($php_labals); ?>;
    var data = <?php echo json_encode($php_Data); ?>;
    var avg = <?php echo json_encode($php_avg); ?>;


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
