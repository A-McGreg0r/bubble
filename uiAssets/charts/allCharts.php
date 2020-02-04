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

        const ctxL1 = document.getElementById("lineChart_Year").getContext('2d');
        const gradientFill = ctxL1.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
        let LineChartYear = new Chart(ctxL1, {
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
    $dataLabel_Months = array();
    $dataPoints_Month = array();
    $dataAvg_Month = array();

    for ($i = $numOfDays; $i >= 0; $i--) {
        //list of months
        array_push($dataLabel_Months, date('D', strtotime("-$i day", $first)));
        //geanarat rand data for display
        array_push($dataPoints_Month, rand(25, 100));
        //a avg of the entire contence of the array
        //todo consider changeing it to look at all past years to provide a more accurit estamit
        $dataPoints_Month = array_filter($dataPoints_Month);
        array_push($dataAvg_Month, array_sum($dataPoints_Month)/count($dataPoints_Month));

    }

    $jsonEncode1_Month = json_encode($dataLabel_Months, JSON_NUMERIC_CHECK);
    $jsonEncode2_Month = json_encode($dataAvg_Month, JSON_NUMERIC_CHECK);
    $jsonEncode3_Month = json_encode($dataPoints_Month, JSON_NUMERIC_CHECK);
    $html = <<<pageHTML
    <script type="text/javascript">
        //converts php querry to js for graph
    
        const ctxL2 = document.getElementById("lineChart_Month").getContext('2d');
        const gradientFill = ctxL2.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
        let LineChartMonth = new Chart(ctxL2, {
            type: 'line',
            data: {
                labels: $jsonEncode1_Month,
                datasets: [{
                    label: "Expected Usage",
                    data: $jsonEncode2_Month,
                    backgroundColor: [
                        'rgba(0,0,0,0)',
                    ],
                    borderColor: [
                        'rgba(0, 10, 130, .1)',
                    ],
                    borderWidth: 2,
                },
                    {
                        label: "Power Used",
                        data: $jsonEncode3_Month,
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
pageHTML;
    return $html;
}

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

        const ctxL3 = document.getElementById("mainLineChart").getContext('2d');
        const gradientFill = ctxL3.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
        let LineChartDay = new Chart(ctxL3, {
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