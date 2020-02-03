<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<?php

function generateLineChart_Year(){
    //TODO remove once data base it implmented
    //randome genarated grapth (temp)
    $dataTitle ="lineChart_Year";
    $first_Year = strtotime('first day this month');
    $dataLabels_Year = array();
    $dataPoints_Year = array();
    $dataAvg_Year = array();

    for ($i = 11; $i >= 0; $i--) {
        //list of months
        array_push($dataLabels_Year, date('M', strtotime("-$i month", $first_Year)));
        //geanarat rand data for display
        array_push($dataPoints_Year, rand(100, 1000));
        //a avg of the entire contence of the array
        //todo consider changeing it to look at all past years to provide a more accurit estamit
        $dataPoints_Year = array_filter($dataPoints_Year);
        array_push($dataAvg_Year, array_sum($dataPoints_Year)/count($dataPoints_Year));

    }

    $jsonEncode1_Year = json_encode($dataLabels_Year, JSON_NUMERIC_CHECK);
    $jsonEncode2_Year = json_encode($dataAvg_Year, JSON_NUMERIC_CHECK);
    $jsonEncode3_Year = json_encode($dataPoints_Year, JSON_NUMERIC_CHECK);
    $html = <<<h

    <script type="text/javascript">
        //converts php querry to js for graph

        const ctxL = document.getElementById("lineChart_Year").getContext('2d');
        const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
        let LineChartYear = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: $jsonEncode1_Year,
                datasets: [{
                    label: "Expected Usage",
                    data: $jsonEncode2_Year,
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
                        data: $jsonEncode3_Year,
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