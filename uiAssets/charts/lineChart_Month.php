<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<!--TODO intagrate database qurry -->


    <?php
    //TODO remove once data base it implmented
    //randome genarated grapth (temp)


    $first = strtotime('first day this month');

        for ($i = 1; $i <= $numOfDays; $i++) {
            //list of months
            array_push($days, "day :" . $i);
            //geanarat rand data for display
        }
    ?>

<?php
//TODO remove once data base it implmented
//randome genarated grapth (temp)
$dataTitle ="lineChart_Months";
$numOfDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));
$first = strtotime('first day this month');
$dataLables = array();
$dataPoints = array();
$dataAvg = array();

for ($i = $numOfDays; $i >= 0; $i--) {
    //list of months
    array_push($dataLables, date('D', strtotime("-$i day", $first)));
    //geanarat rand data for display
    array_push($dataPoints, rand(25, 100));
    //a avg of the entire contence of the array
    //todo consider changeing it to look at all past years to provide a more accurit estamit
    $dataPoints = array_filter($dataPoints);
    array_push($dataAvg, array_sum($dataPoints)/count($dataPoints));

}


?>


<script type="text/javascript">
    //converts php querry to js for graph

    const ctxL = document.getElementById("lineChart_Month").getContext('2d');
    const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
    gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
    gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
    let LineChartYear = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dataLables, JSON_NUMERIC_CHECK); ?>,
            datasets: [{
                label: "Expected Usage",
                data: <?php echo json_encode($dataAvg, JSON_NUMERIC_CHECK); ?>,
                backgroundColor: [
                    'rgba(0,0,0,0)',
                ],
                borderColor: [
                    'rgba(0, 10, 130, .1)',
                ],
                borderWidth: 2
            },
                {
                    label: "Power Used",
                    data: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
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
</script>