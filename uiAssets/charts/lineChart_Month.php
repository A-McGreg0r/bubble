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
    $dataLables_Month = array();
    $dataPoints_Month = array();
    $dataAvg_Month = array();
    
    for ($i = $numOfDays; $i >= 0; $i--) {
        //list of months
        array_push($dataLable_Months, date('D', strtotime("-$i day", $first)));
        //geanarat rand data for display
        array_push($dataPoints_Month, rand(25, 100));
        //a avg of the entire contence of the array
        //todo consider changeing it to look at all past years to provide a more accurit estamit
        $dataPoints_Month = array_filter($dataPoints_Month);
        array_push($dataAvg_Month, array_sum($dataPoints_Month)/count($dataPoints_Month));
    
    }

    $jsonEncode1_Month = json_encode($dataLable_Months, JSON_NUMERIC_CHECK);
    $jsonEncode2_Month = json_encode($dataAvg_Month, JSON_NUMERIC_CHECK);
    $jsonEncode3_Month = json_encode($dataPoints_Month, JSON_NUMERIC_CHECK);
    $html = <<<pageHTML
    <script type="text/javascript">
        //converts php querry to js for graph
    
        const ctxL = document.getElementById("lineChart_Month").getContext('2d');
        const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
        let LineChartMonth = new Chart(ctxL, {
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
//TODO remove once data base it implmented
//randome genarated grapth (temp)

?>