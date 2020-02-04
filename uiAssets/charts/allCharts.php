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
    Var dataYear={data:{labels: $jsonEncode1_Year,
                datasets: [{label: ["Expected Usage"],data: $jsonEncode2_Year,backgroundColor: ['rgba(0,0,0,0)',],borderColor: ['rgba(0, 10, 130, .1)',],borderWidth: ['2'],},{
                label: "Power Used",data: $jsonEncode3_Year,backgroundColor: gradientFill,borderColor: gradientFill,borderWidth: 2}]}}
    
    Var dataMonth={  data: {labels: $jsonEncode1_Year,
                datasets: [{"label": "Expected Usage",data: $jsonEncode2_Year,backgroundColor: ['rgba(0,0,0,0)',],borderColor: ['rgba(0, 10, 130, .1)',],borderWidth: ['2'],},{
                label: "Power Used",data: $jsonEncode3_Year,backgroundColor: gradientFill,borderColor: gradientFill,borderWidth: 2}]}}
    Var dataDay={data: {labels: $jsonEncode1_Year,
            datasets: [{label: $jsonEncode1_Year,
            data: $jsonEncode2_Year,backgroundColor: ['rgba(0,0,0,0)',], borderColor: ['rgba(0, 10, 130, .1)',],borderWidth: ['2'];},{
            label: "Power Used",data: $jsonEncode3_Year,backgroundColor: gradientFill,borderColor: gradientFill,borderWidth: ['2']}]
        //converts php querry to js for graph

        const ctxL = document.getElementById("mainLineChart").getContext('2d');
        const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");
        let mainLineChart = new Chart(ctxL, {
            type: 'line',
           data: dataYear,
            options: {
                responsive: true
            }
        });
});

    function chartContent() {
    mainLineChart["config"]["data"] = data2; //<--- THIS WORKS!
    mainLineChart.update();
     }
     $(document).ready(function() {
    $( "#chartPicker" ).on('change', function();
    if ( this.value === '1'){
          }else if( this.value === '2'){
          }else if( this.value === '3'){
          }else{
          }

    </script>
h;
    return $html;
}
?>