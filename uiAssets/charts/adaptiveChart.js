function AdaptiveLineChart(name, labels, data, avg) {
    //converts php querry to js for graph

    let chartId = this.name;
    let lable = this.labels
    let graphdata = this.data;
    let graphavg = this.avg;

    //coulers for all graphs
    const ctxL = document.getElementById(chartId).getContext('2d');
    const gradientFill = ctxL.createLinearGradient(0, 0, 0, 350);
    gradientFill.addColorStop(0, "rgba(242,38,19,0.5)");
    gradientFill.addColorStop(1, "rgba(0,230,64,0.5)");


    if (ranage.length > 0)//months
    {
        chartId = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: range,
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





