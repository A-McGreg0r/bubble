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
                // Supplied Datasets to display
                var data1 = { "labels": ["1", "2", "3"], "datasets": [{ "label": "Contacts", "data": [20, 15, 10], "backgroundColor": "rgba(255, 99, 132, 0.2)", "borderColor": "rgba(255,99,132,1)", "borderWidth": 1 }] };
                var data2 = { "labels": ["1", "2", "3"], "datasets": [{ "label": "Contacts", "data": [10, 23, 41], "backgroundColor": "rgba(255, 99, 132, 0.2)", "borderColor": "rgba(255,99,132,1)", "borderWidth": 1 }] };
                
                // Draw the initial chart
                var kChartCanvas = $("#kontakteChart")[0].getContext('2d');
                var myChart = new Chart(kChartCanvas, {
                    type: 'bar',
                    data: data1,
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
                
                // Called on Click
                function chartContent() {
                    myChart["config"]["data"] = data2; //<--- THIS WORKS!
                    myChart.update();
                }




    </script>
h;
    return $html;
}
?>