function AdaptiveLineChart(name, labels, data) {
    //converts php querry to js for graph

    let chartId = this.name;//id of the chart
    let label = this.labels;//array labels for the tracked data
    let graphData = this.data;//array data input
    let graphAvg = this.data;//array data to be reduced to get avg of data
    let arrAvg = graphAvg => graphAvg.reduce((a, b) => a + b, 0) / graphAvg.length;

    while (graphAvg.length < graphAvg.length) {
        graphAvg.push(arrAvg);
    }//used to set the avvrige accrose the entire grapth

    //coulers for all graphs
    const ctxL = document.getElementById(chartId).getContext('2d');
    const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
    gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
    gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");


    if (graphData.length > 0)//months
    {
        chartId = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: "Average Usage",
                    data: arrAvg,
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
                        data: graphData,
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





