<?php
//todo consider seting up dom
//TODO remove once data base it implmented

//todo add querry

//todo cahge avrege calculation in to data.lenth

?>

<script>
        //converts php querry to js for graph
        function AdaptiveLineChart(name, labels, data, ) {

        let chartId = this.name;
        let lable = this.labels;
        let graphdata = this.data;
        let calArray =graphdata;
        let graphavg;




        //coulers for all graphs
        const ctxL = document.getElementById(chartId).getContext('2d');
        const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
        gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
        gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");


        if (graphdata.length > 0)//months
        {
            let myLineChart = new Chart(ctxL, {
                type: 'line',
                data: {
                    labels: lable,
                    datasets: [{
                        label: "Average Usage",
                        data: graphavg,
                        backgroundColor: [
                            'rgba(0, 137, 132, .0)',
                        ],
                        borderColor: [
                            'rgba(0, 10, 130, .1)',
                        ],
                        borderWidth: 2
                    },
                        {
                            label: "Power Used",
                            data: graphdata,
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
</script>
