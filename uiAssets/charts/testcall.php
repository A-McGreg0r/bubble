<?php
//TODO remove once data base it implmented
//randome genarated grapth (temp)
$days = array(1, 2, 3, 4, 5);
$randData = array(1, 2, 3, 4, 5);
$arrayAvg = array(1, 2, 3, 4, 5);
?>
<canvas id="myChart"></canvas>
<script>
    const name = "testing";
    let col = "<?php echo json_encode($days); ?>";
    let data = "<?php echo json_encode($randData);?>";
    let avg = "<?php echo json_encode($arrayAvg); ?>";

    new AdaptiveLineChart(name, col, data, avg);
</script>


