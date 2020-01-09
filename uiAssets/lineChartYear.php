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
</head>


<!-- Grid container -->
<div class="container">

    <canvas id="lineChart"></canvas>

</div>


<?php
//will be change later to get data from data base
//randome genarated grapth (temp)
$first = strtotime('first day this month');
$months = array();
$randData = array();

for ($i = 12; $i >= 1; $i--) {
    array_push($months, date('M', strtotime("-$i month", $first)));
}

for ($i = 12; $i >= 1; $i--) {
    array_push($randData, rand(0, 1000));
}


$arrayTotal = array_sum($randData);


//add waning limits uppper
$arrayAvg = array_sum($randData) / (count($randData));
//add prase limit lower


echo "<br><br>";
echo "test output<br><br>";
echo $arrayTotal;
echo "<br>";
echo $arrayAvg;
?>

<script type="text/javascript">
    var js_months =<?php echo json_encode($months);?>;
    var js_array =<?php echo json_encode($randData);?>;
    var avg =<?php echo json_encode($arrayAvg);?>;

    var ctxL = document.getElementById("lineChart").getContext('2d');
    var gradientFill = ctxL.createLinearGradient(0, 0, 0, 290);
    gradientFill.addColorStop(0, "rgba(173, 53, 186, 1)");
    gradientFill.addColorStop(1, "rgba(173, 53, 186, 0.1)");

    var myLineChart = new Chart(ctxL,
        {
            type: 'line',
            data:
                {
                    labels: [js_months[0], js_months[1], js_months[2], js_months[3], js_months[4], js_months[5], js_months[6], js_months[7], js_months[8], js_months[9], js_months[10], js_months[11]],
                    datasets:
                        [
                            {
                                label: "Power Usage",
                                data: [js_array[0], js_array[1], js_array[2], js_array[3], js_array[4], js_array[5], js_array[6], js_array[7], js_array[8], js_array[9], js_array[10], js_array[11]],
                                backgroundColor: gradientFill,
                                borderColor:
                                    [
                                        '#AD35BA',
                                    ],

                                borderWidth: 3,
                                pointBorderColor: "#fff",
                                pointBackgroundColor: "rgba(173, 53, 186, 1)",
                            },

                            {
                                label: "avage power usage",
                                data: [avg, avg, avg, avg, avg, avg, avg, avg, avg, avg, avg, avg],
                                backgroundColor: 'rgba(0, 137, 132, .01)',
                                borderColor:
                                    [
                                        '#AbbABA',
                                    ],

                                borderWidth: 1,
                                pointBorderColor: "#aff",
                                pointBackgroundColor: "rgba(105,125,12,1)",
                            },

                        ]
                },
        });
</script>