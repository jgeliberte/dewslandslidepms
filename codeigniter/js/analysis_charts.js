
let BULLETIN_DATA = [];
let EWI_DATA = [];

$(document).ready(() => {
    getBulletinTimeliness();
    plotTimeliness();
    $("#selection-area").on("change", () => {
        plotTimeliness();
    });
});

function getTimelinessInfo () {
    return $.getJSON("/Analysis_charts/getTimelinessResult");
}

function getBulletinTimeliness () {
    getTimelinessInfo().done((timeliness_array) => {
        timeliness_array.forEach((timeliness) => {
            timeliness[2] === 1 ? BULLETIN_DATA.push(timeliness) : EWI_DATA.push(timeliness);
        });
    });
}

function plotTimeliness () {
    getTimelinessInfo().done((timeliness_data) => {
        let INFORMATION = "";
        $("#selection-area").val() === "bulletin" ? INFORMATION = BULLETIN_DATA : INFORMATION = EWI_DATA;

        Highcharts.chart("chart-container", {
            chart: {
                type: "scatter",
                zoomType: "xy"
            },
            title: {
                text: "Timeliness Chart"
            },
            subtitle: {
                text: "Bulletin and EWI"
            },
            xAxis: {
                title: {
                    enabled: true,
                    text: "Date Received"
                },
                labels: {
                    format: "{value:%Y-%b-%e}"
                },
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis: {
                title: {
                    text: "Execution Time"
                }
            },
            // legend: {
            //     layout: "vertical",
            //     align: "left",
            //     verticalAlign: "top",
            //     x: 500,
            //     y: 70,
            //     floating: true,
            //     backgroundColor: "#FFFFFF",
            //     borderWidth: 1
            // },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: "rgb(100,100,100)"
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: "<b>{series.name}</b><br>",
                        pointFormat: "{point.x:%Y-%b-%e}, {point.y} minutes"
                    }
                }
            },
            series: [{
                name: "Bulletin",
                color: "rgba(16, 46, 80, 0.3)",
                data: INFORMATION
            }]
        });
    });
}
