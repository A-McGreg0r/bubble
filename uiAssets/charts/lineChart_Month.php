<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<!--TODO intagrate database qurry -->


<?php

function generateLineChart_Month(){
    $first = strtotime('first day this month');
    $numOfDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));
    $days = array();

    for ($i = 1; $i <= $numOfDays; $i++) {
        //list of months
        array_push($days, "day :" . $i);
        //geanarat rand data for display
    }

    //TODO remove once data base it implmented
    //randome genarated grapth (temp)
    $dataTitle ="lineChart_Months";
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

    $jsonEncode1 = json_encode($dataLables, JSON_NUMERIC_CHECK);
    $jsonEncode2 = json_encode($dataAvg, JSON_NUMERIC_CHECK);
    $jsonEncode3 = json_encode($dataPoints, JSON_NUMERIC_CHECK);
    $html = <<<pageHTML
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
            
            // Set the listener for the click function
            $(document).ready(function() {
                $("#control1").click(chartContent);
            });
            
    
            
    </script>
pageHTML;
    return $html;


}
//TODO remove once data base it implmented
//randome genarated grapth (temp)

?>