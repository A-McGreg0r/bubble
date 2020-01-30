<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<!--TODO intagrate database qurry -->
<script type="text/javascript">
    //converts php querry to js for graph
    <?php
    //TODO remove once data base it implmented
    //randome genarated grapth (temp)

    $numOfHours = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));

    $first = strtotime('first day this month');
    $days = array();
    $randData = array();
    $arrayAvg = array();
    for ($i = 1; $i <= $numOfHours; $i++) {
        //list of months
        array_push($days, "day :" . $i);
        //geanarat rand data for display
        array_push($randData, rand(0, 100));
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
    const ctxL = document.getElementById("lineChart_Day").getContext('2d');
    const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
    gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
    gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
    let myLineChart = new Chart(ctxL, {
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

    function f() {
        // Grasp the inputs
        var form1 = $('#form1')
        var form2 = $('#form2')
        var form3 = $('#form3')
        var form4 = $('#form4')

// Create a submit function and prevent it from reloading the page
        $('#myForm').submit(function (e) {
            e.preventDefault();

// Then input a new data object, with form values as data
            myChart.data = {
                labels: ["Red", "Blue", "Yellow", "Green"],
                datasets: [{
                    label: '# of Votes',
                    data: [form1.val(), form2.val(), form3.val(), form4.val()],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            }
// Finally, update the chart with
            myChart.update();
        });

    }

</script>