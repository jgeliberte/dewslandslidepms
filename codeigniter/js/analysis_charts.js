
let TEAM_METRICS = [];

$(document).ready(() => {
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
});

function getTimelinessInfo () {
    return $.getJSON("/Analysis_charts/getTimelinessResult");
}

function getAccuracyInfo () {
    return $.getJSON("/Analysis_charts/getAccuracyResult");
}

function getErrorInfo () {
    return $.getJSON("/Analysis_charts/getErrorLogsResult");
}

function getTeamMetrics () {
    return $.getJSON("/Analysis_charts/getTeamMetrics");
}

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
        metric_names.forEach(({ metric_name, metric_type, metric_id }) => {
            $metric_input.append(`<option id="${metric_id}" value="${metric_name}" 
                data-metric-type="${metric_type}">${metric_name}</option>`);
        });
    });
}

function initializeMetricNameOnChange () {
    $("#metric_name").change(({ currentTarget: { value: metric } }) => {
        const metric_name = metric === "" ? "" : metric;
        const metric_type = $("#metric_name").find(":selected").data("metric-type");
        getSeriesData(metric_name, metric_type);
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
        const {
            metric_module_id: metric, metric_name,
            metric_id, metric_type
        } = entry;

        if (metric === module_id) {
            if (flags[metric_name]) return false;
            flags[metric_name] = true;
            return true;
        }
        return false;
    });
    return metric_names;
}

function getSeriesData (metric_name, metric_type) {
    const SERIES_ARR = [];

    let LOOKUP = [
        ["scatter", "Accuracy Plot", "Percent Accuracy", metric_name, "%"],
        ["scatter", "Error Logs Plot", "Error Instances", metric_name, ""],
        ["scatter", "Timeliness Plot", "Execution Time", metric_name, " mins."]
    ];

    getTimelinessInfo().done((data) => {
        getAccuracyInfo().done((data2) => {
            getErrorInfo().done((data3) => {
                let data_source;
                switch (metric_type) {
                    case 1:
                        data_source = data2;
                        LOOKUP.splice(1, 2);
                        break;
                    case 2:
                        data_source = data3;
                        LOOKUP = LOOKUP.slice(1, -1);
                        break;
                    case 3:
                        data_source = data;
                        LOOKUP.splice(0, 2);
                        break;
                    default: data_source = ""; break;
                }

                Object.entries(data_source[0]).forEach(([results, info]) => {
                    const series_data = {
                        name: results.toUpperCase(),
                        data: []
                    };
                    if (metric_name === results) {
                        info.forEach((datum) => {
                            const chart_data = [datum.ts_received, datum.value];
                            series_data.data.push(chart_data);
                        });
                        SERIES_ARR.push(series_data);
                    }
                });
                plotMetricChart(SERIES_ARR, LOOKUP[0]);
                plotMetricTable(data_source, metric_name, LOOKUP[0]);
            });
        });
    });
}

function plotMetricTable (data_source, metric_name, lookup) {
    $("#metric-table").DataTable().clear().destroy();
    $("#metric-table").prop("hidden", false);
    $("#metric-value").text(lookup[2]);
    Object.entries(data_source[0]).forEach(([results, data]) => {
        data.forEach((result) => {
            if (metric_name === results) {
                const table_row = $("#row-template").clone().removeAttr("id").prop("hidden", false);
                const {
                    ts_received, value, report_id, report_message,
                    reference_id, reference_table
                } = result;

                const lookup_array = [
                    ["#report-id", report_id],
                    ["#ts-received", moment(ts_received).format("YYYY-MM-DD H:mm:ss")],
                    ["#value", value],
                    ["#report-message", report_message],
                    ["#reference-id", reference_id],
                    ["#reference-table", reference_table]
                ];
                lookup_array.forEach(([element, text]) => {
                    table_row.find(element).text(text);
                });
                $("#metric-table-body").append(table_row);
            }
        });
    });
    $("#metric-table").DataTable({
        "order": [[1, "desc"]],
        "columnDefs": [{"width": "20%", "targets": [3, 4, 5]}],
    });
}

function plotMetricChart (series_array, chart_details) {
    Highcharts.setOptions({
        time: {
            useUTC: false
        }
    });

    Highcharts.chart("chart-container", {
        chart: {
            type: chart_details[0],
            zoomType: "xy"
        },
        title: {
            text: chart_details[1]
        },
        subtitle: {
            text: chart_details[3].toUpperCase()
        },
        xAxis: {
            title: {
                enabled: true,
                text: "Date Received"
            },
            labels: {
                format: "{value:%Y-%b-%e %H:%m:%S}"
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },
        yAxis: {
            title: {
                text: chart_details[2]
            }
        },
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
                    pointFormat: `Received: {point.x:%Y-%b-%e %H:%M:%S}<br>${chart_details[2]}: {point.y}${chart_details[4]}`
                }
            }
        },
        series: series_array,
        lang: {
            noData: "No data available"
        },
        noData: {
            style: {
                fontWeight: "bold",
                fontSize: "15px",
                color: "#303030"
            }
        }
    });
}
