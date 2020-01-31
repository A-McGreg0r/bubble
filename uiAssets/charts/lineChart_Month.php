<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<!--TODO intagrate database qurry -->

<script type="text/javascript">
    //converts php querry to js for graph

    <?php
    //TODO remove once data base it implmented
    //randome genarated grapth (temp)
    $numOfDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));

    $first = strtotime('first day this month');
    $days = array();
    $randData = array();
    $arrayAvg = array();
    for ($i = 1; $i <= $numOfDays; $i++) {
        //list of months
        array_push($days, "day :" . $i);
        //geanarat rand data for display
        array_push($randData, rand(0, 500));
        //a avg of the entire contence of the array
        array_push($arrayAvg = array_sum($randData) / count($randData));
    }
    //list of months
    $php_Days = json_encode($days);
    echo "var js_days = " . $php_Days . ";\n";
    //dataset
    $php_Data = json_encode($randData);
    echo "var js_data = " . $php_Data . ";\n";
    //dataset avgrege
    $arrayAvg = json_encode($arrayAvg);
    echo "var js_data_avg = " . $arrayAvg . ";\n";
    ?>
    const ctxL = document.getElementById("lineChart_Month").getContext('2d');
    const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
    gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
    gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
    let LineChartMonth = new Chart(ctxL, {

        type: 'line',
        data: {
            labels: js_days,
            datasets: [{
                label: "Avrages usage",
                data: [js_data_avg, js_data_avg],
                backgroundColor: [
                    'rgba(0, 137, 132, .0)',
                ],
                borderColor: [
                    'rgba(0, 10, 130, .1)',
                ],
                borderWidth: 2
            },
                {
                    label: "power used",
                    data: js_data,
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