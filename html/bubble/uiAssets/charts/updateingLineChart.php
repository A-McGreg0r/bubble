<div calss="container border border-primary">
    <!--change chart drop down-->
    <select id="chartPicker" class="browser-default custom-select dropdown" onchange="chartSelect()">
        <option selected="selected">Choose time period</option>
        <option value="0">Year</option>
        <option value="1">Month</option>
        <option value="2">Day</option>
    </select>
    <!--chart canvas-->
    <canvas id="masterLineChart"></canvas>

    <script type="text/javascript">
        //todo cahe where datas comeing from
        //Supplied Datasets to display
        //hourly 1 upto 24
        let data1 = {
            "labels": $DataLabelsEncoded,
            "label": "Expected Usage: ",
            "datasets": [{
                "label": "avg",
                "data": $dataAvgEncoded,
                "backgroundColor": "rgba(101, 209, 159, 0.6)",
                "borderColor": "rgba(101, 209, 159,1)",
                "borderWidth": 1
            }, {
                "label": "Power usage",
                "data": $dataPointsEncoded,
                "backgroundColor": "rgba(93, 176, 201, 0.6)",
                "borderColor": "rgba(0, 10, 130, .4)",
                "borderWidth": 1
            }]
        };
        //days upto 31 days
        let data2 = {
            "labels": $DataLabelsEncoded,
            "label": "Expected Usage:",
            "datasets": [{
                "label": "avg",
                "data": $dataAvgEncoded,
                "backgroundColor": "rgba(101, 0, 0, 0.6)",
                "borderColor": "rgba(101, 209, 159,1)",
                "borderWidth": 1
            }, {
                "label": "Power usage",
                "data": $dataPointsEncoded,
                "backgroundColor": "rgba(255, 255, 255, 0.6)",
                "borderColor": "rgba(0, 10, 130, .4)",
                "borderWidth": 1
            }]
        };
        //months upto 12
        let data3 = {
            "labels": $DataLabelsEncoded,
            "label": "Expected Usage: ",
            "datasets": [{
                "label": "avg",
                "data": $dataAvgEncoded,
                "backgroundColor": "rgba(101, 209, 159, 0.6)",
                "borderColor": "rgba(101, 209, 159,1)",
                "borderWidth": 1
            }, {
                "label": "Power usage",
                "data": $dataPointsEncoded,
                "backgroundColor": "rgba(93, 176, 201, 0.6)",
                "borderColor": "rgba(0, 10, 130, .4)",
                "borderWidth": 1
            }]
        };


        // Draw the initial chart
        let ctxL = $("#masterLineChart")[0].getContext('2d');
        let masterLineChart = new Chart(ctxL, {
            type: 'line',
            data: data1,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Called on Change
        $(document).ready(function () {
            $("select.dropdown").change(function () {
                let selectedChart = $(this).children("option:selected").val();

                if (selectedChart == 0) {
                    masterLineChart["config"]["data"] = data1; //<--- THIS WORKS!
                    masterLineChart.update();
                }

                if (selectedChart == 1) {
                    masterLineChart["config"]["data"] = data2; //<--- THIS WORKS!
                    masterLineChart.update();
                }

                if (selectedChart == 2) {
                    masterLineChart["config"]["data"] = data3; //<--- THIS WORKS!
                    masterLineChart.update();
                }
            });
        });

    </script>

</div>
