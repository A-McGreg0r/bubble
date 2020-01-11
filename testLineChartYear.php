<!-- TODO remove header as elaments will not be need after completion -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!--icon Change me-->
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!--Scripts-->
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/js/mdb.min.js"></script>
    <!--Scripts-->

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="css/mdb.min.css" type="text/css"/>
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <title>testing</title>
</head>
<?php
//TODO remove once data base it implmented
//will be change later to get data from data base
//randome genarated grapth (temp)
$first = strtotime('first day this month');
$months = array();
$randData = array();

for ($i = 11; $i >= 0; $i--) {
    array_push($months, date('M', strtotime("-$i month", $first)));
    //geanarat rand data for display
    array_push($randData, rand(0, 1000));
}

//a sum of the entire contence of the array
$arrayTotal = array_sum($randData);
//a avg of the entire contence of the array
$arrayAvg = array_sum($randData) / count($randData);

?><!--TODO intagrate database qurry -->
<canvas id="lineChart"></canvas>
<script type="text/javascript">
    //line
    <?php
    //list of months
    $php_Months = json_encode($months);
    echo "var js_months = " . $php_Months . ";\n";
    //dataset
    $php_Data = json_encode($randData);
    echo "var js_data = " . $php_Data . ";\n";
    //dataset avgrege
    $arrayAvg = json_encode($arrayAvg);
    echo "var js_data_avg = " . $arrayAvg . ";\n";

    ?>



    var ctxL = document.getElementById("lineChart").getContext('2d');

    var gradientFill = ctxL.createLinearGradient(0, 0, 0, 750);
    gradientFill.addColorStop(0, "rgba(242, 38, 19, 1)");
    gradientFill.addColorStop(1, "rgba(0, 230, 64, 1)");

    var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: js_months,
            datasets: [{
                label: "My First dataset",
                data: js_data,
                backgroundColor: gradientFill,
                borderColor: [
                    'rgba(200, 99, 132, .7)',
                ],
                borderWidth: 2
            },
                {
                    label: "My Second dataset",
                    data: [js_data_avg, js_data_avg, js_data_avg, js_data_avg, js_data_avg, js_data_avg, js_data_avg, js_data_avg, js_data_avg, js_data_avg, js_data_avg, js_data_avg,],
                    backgroundColor: [
                        'rgba(0, 137, 132, .1)',
                    ],
                    borderColor: [
                        'rgba(0, 10, 130, .4)',
                    ],
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true
        }
    });


</script>