<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<?php

function generateLineChart_Day(){
    //TODO remove once data base it implmented
    //randome genarated grapth (temp)
    $dataTitle ="lineChart_Year";

    $first = strtotime('first day this month');
    $dataLabels_Day = array();
    $dataPoints_Day = array();
    $dataAvg_Day = array();

    for ($i = 11; $i >= 0; $i--) {
        //list of months
        array_push($dataLabels_Day, date('M', strtotime("-$i month", $first)));
        //geanarat rand data for display
        array_push($dataPoints_Day, rand(0, 100));
        //a avg of the entire contence of the array
        //todo consider changeing it to look at all past years to provide a more accurit estamit
        $dataPoints_Day = array_filter($dataPoints_Day);
        array_push($dataAvg_Day, array_sum($dataPoints_Day)/count($dataPoints_Day));

    }

    $jsonEncode1_Day = json_encode($dataLabels_Day, JSON_NUMERIC_CHECK);
    $jsonEncode2_Day = json_encode($dataAvg_Day, JSON_NUMERIC_CHECK);
    $jsonEncode3_Day = json_encode($dataPoints_Day, JSON_NUMERIC_CHECK);
    $html = <<<h

    <script type="text/javascript">
        //converts php querry to js for graph

        const ctxL = document.getElementById("lineChart_Day").getContext('2d');
        const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
        let LineChartDay = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: $jsonEncode1_Day,
                datasets: [{
                    label: "Expected Usage",
                    data: $jsonEncode2_Day,
                    backgroundColor: [
                        'rgba(0,0,0,0)',
                    ],
                    borderColor: [
                        'rgba(0, 10, 130, .1)',
                    ],
                    borderWidth: ['2'],
                },
                    {
                        label: "Power Used",
                        data: $jsonEncode3_Day,
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
h;
    return $html;
}
?>