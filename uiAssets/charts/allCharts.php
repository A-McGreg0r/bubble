<!-- TODO spelling and gramer check -->
<!-- TODO remove header as elaments html tag and doc type as required after completion -->
<?php

function generateLineChart_All()
{
    //TODO remove once data base it implmented
    $dataPoints = array();
    $y = 40;
    for ($i = 0; $i < 1000; $i++) {
        $y += rand(0, 10) - 5;
        array_push($dataPoints, array("x" => $i, "y" => $y));
    }
    $dataPointsEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);


    $html = <<<h

     <script>
      window.onload = function () {
      var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        animationEnabled: true,
        zoomEnabled: true,
            title: {
            text: "Try Zooming and Panning"
            },
            data: [{
             type: "area",     
             dataPoints: $dataPointsEncoded
              }]
              });
         chart.render();
         }
    </script>

h;
    return $html;
}

?>