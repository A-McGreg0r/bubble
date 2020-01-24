<?php
//TODO make database queerys
//randome genarated grapth (temp)


$range = array();
$Data = array();
$arrayAvg = array();

for ($i = count($arrayAvg); $i <= count($range); $i++) {
    array_push($arrayAvg = array_sum($randData[$i]) / (count($randData)));
}
//list x axsies
$php_range = json_encode($range);
echo "var js_days = " . $php_range . ";\n";
//dataset y axsies
$php_Data = json_encode($Data);
echo "var js_data = " . $php_Data . ";\n";
//dataset avgrege
$arrayAvg = json_encode($arrayAvg);
echo "var js_data_avg = " . $arrayAvg . ";\n";
?>

<script type="text/javascript">
    function adaptivelinechart(range, data, data_avg) {
//converts php querry to js for graph

        //coulers for all graphs
        const ctxL = document.getElementById("lineChart").getContext('2d');
        const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");


        if (ranage.length > 0)//months
        {
            let myLineChart = new Chart(ctxL, {
                type: 'line',
                data: {
                    labels: range,
                    datasets: [{
                        label: "Avrages usage",
                        data: data_avg,
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
                            data: data,
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
        }
    }
    }else
    {
        <?php
        echo "error loading";
        ?>
    }


</script>