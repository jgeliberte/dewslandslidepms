
let SERIES_ARR = [$("metric-selection").val()];
let TEAM_METRICS = [];

$(document).ready(() => {
    getTimelinessInfo();
    initializeTeamNameOnChange();
    initializeModuleNameOnChange();
    initializeMetricNameOnChange();

    getTeamMetrics()
    .done((team_metrics) => {
        TEAM_METRICS = team_metrics;
    })
    .then(() => {
        const teams = getAllTeamNames("team_name");
        teams.forEach(({ team_name, team_id }) => {
            $("#team_name").append(`<option value="${team_id}">${team_name}</option>`);
        });
    });
    getSeriesData($("#metric_name").val());
});

function getAllTeamNames (attr) {
    const flags = {};
    const teams = TEAM_METRICS.filter((entry, index, self) => {
        if (flags[entry[attr]]) return false;
        flags[entry[attr]] = true;
        return true;
    });

    return teams;
}

function initializeTeamNameOnChange () {
    $("#team_name").change(({ currentTarget: { value: team_id } }) => {
        const $module_input = $("#module_name");
        $module_input.find("option").not("[value='']").remove();
        const module_names = getModuleNames(team_id);
        module_names.forEach(({ module_id, module_name }) => {
            $module_input.append(`<option value="${module_id}">${module_name}</option>`);
        });
    });
}

function initializeModuleNameOnChange () {
    $("#module_name").change(({ currentTarget: { value: module_id } }) => {
        const $metric_input = $("#metric_name");
        $metric_input.find("option").not("[value='']").remove();
        const metric_names = getMetricNames(module_id);
        metric_names.forEach(({ metric_name }) => {
            $metric_input.append(`<option value="${metric_name}">${metric_name}</option>`);
        });
    });
}

function initializeMetricNameOnChange () {
    $("#metric_name").change(({ currentTarget: { value: metric } }) => {
        const metric_name = metric === "" ? "" : metric;
        getSeriesData(metric_name);
    });
}

function getModuleNames (team_id) {
    const flags = {};
    const module_names = TEAM_METRICS.filter((entry, index, self) => {
        const { team_id: team, module_name } = entry;
        if (team === team_id) {
            if (flags[module_name]) return false;
            flags[module_name] = true;
            return true;
        }
        return false;
    });
    return module_names;
}

function getMetricNames (module_id) {
    const flags = {};
    const metric_names = TEAM_METRICS.filter((entry, index, self) => {
        const { metric_module_id: metric, metric_name, metric_type } = entry;
        if (metric === module_id && metric_type == 3) {
            if (flags[metric_name]) return false;
            flags[metric_name] = true;
            return true;
        }
        return false;
    });
    return metric_names;
}

function getTimelinessInfo () {
    return $.getJSON("/Analysis_charts/getTimelinessResult");
}

// function initializeSelectOnChange () {
//     $("#metric-selection").change(({ currentTarget: { value: metric } }) => {
//         const metric_name = metric === "all" ? "all" : metric;
//         getSeriesData(metric_name);
//     });
// }

function getTeamMetrics () {
    return $.getJSON("/Analysis_charts/getTeamMetrics");
}

function getSeriesData (metric_name) {
    SERIES_ARR = [];
    getTimelinessInfo().done((data) => {
        Object.entries(data[0]).forEach((timeliness_data) => {
            if (metric_name === timeliness_data[0]) {
                console.log(timeliness_data[0]);
                const series_data = {
                    name: timeliness_data[0].toUpperCase(),
                    data: timeliness_data[1]
                };
                SERIES_ARR.push(series_data);
            } else if (metric_name === "") {
                const series_data_all = {
                    name: timeliness_data[0].toUpperCase(),
                    data: timeliness_data[1]
                };
                SERIES_ARR.push(series_data_all);
            }
        });
        plotTimeliness(SERIES_ARR);
    });
}

function plotTimeliness (series_array) {
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
                    pointFormat: "Received: {point.x:%Y-%b-%e}<br>Execution Time: {point.y}"
                }
            }
        },
        series: series_array
    });
}
