
let FORM_VALIDATE;
let submetric_column_num = 1;

$(document).ready(() => {
    // reposition("#input-modal");

    FORM_VALIDATE = initializeInputForm();

    buildDynaslopeTeamField();

    initializeTileOnClick();
    initializeTileExpandOnClick();
    initializeOnModalClose();
    initializeSubmetricSwitchToggle();
    initializeSubmetricSwitch();
    initializeAddColumnButtonOnClick();
    removeInputField();
});

function buildDynaslopeTeamField () {
    getDynaslopeTeams()
    .done((teams) => {
        $("#teams .tile-rows").empty();
        buildTileRows(teams, "teams");
    })
    .catch((x) => {
        showErrorModal(x, "loading Dynaslope Teams");
    });
}

function getDynaslopeTeams () {
    return $.getJSON("/input/getDynaslopeTeams");
}

function buildTileRows (collection, tile_field) {
    const $tile_rows = $(`#${tile_field} .tile-rows`);
    let { length } = collection;

    length += 1;
    let $row;
    for (let i = 0; i < length; i += 1) {
        if (i + 1 % 4 === 1) {
            $row = $("<div>", { class: "row" });
        }

        const $column = $("<div>", { class: "col-sm-3" });
        let $new_tile;
        if (i + 1 === length) {
            $new_tile = $("#add-tile-template").clone();
        } else {
            const single_field = tile_field.slice(0, -1);
            const _name = `${single_field}_name`;
            const _desc = `${single_field}_desc`;
            const {
                [_name]: name,
                [_desc]: description
            } = collection[i];

            const id_name = `${tile_field.slice(0, -1)}_id`;

            $new_tile = $("#tile-template").clone().attr({
                id: "",
                "data-id": parseInt(collection[i][id_name], 10),
                "data-name": name,
                "data-desc": description
            });

            if (tile_field === "metrics") {
                const { metric_type, submetric_id } = collection[i];
                $new_tile.data("type", metric_type);

                if (submetric_id !== null) {
                    const {
                        submetric_table_name, show_on_modal,
                        submetric_columns
                    } = collection[i];

                    $new_tile.attr({
                        "data-submetric_id": submetric_id,
                        "data-submetric_table_name": submetric_table_name,
                        "data-show_on_modal": show_on_modal,
                        "data-submetric_columns": submetric_columns
                    });
                }
            }

            $new_tile.find(".tile-title")
            .text(name).end()
            .find(".tile-description")
            .text(`${description.substring(0, 30)}...`);
        }

        const $temp_tile = $column.append($new_tile);
        $row.append($temp_tile);

        if (i + 2 % 4 === 0 || i + 1 === length) {
            $tile_rows.append($row);
        }
    }
}

function initializeTileOnClick () {
    $(document).on("click", ".tile", ({ currentTarget }) => {
        const $target = $(currentTarget);
        const $tile_field = $target.parents(".tile-field");
        const field_id = $tile_field.prop("id");
        const tile_id = $target.data("id");
        const $form = $("#input-form");

        const $prev_selected = $(`#${field_id} .tile-selected`);
        const prev_selected_id = $prev_selected.data("id");
        $prev_selected.removeClass("tile-selected");
        $target.addClass("tile-selected");

        $("#submetric-columns").empty();
        FORM_VALIDATE.resetForm();
        $(".form-group").removeClass("has-error has-success has-feedback");
        $form[0].reset();

        if ($target.hasClass("add-tile")) {
            // Get the previous div/tile_field
            const $previous_field = $tile_field.prev(".tile-field");
            const prev_field_id = $previous_field.prop("id");
            const prev_tile_id = $previous_field.find(".tile-selected").data("id");

            $form.data({
                prev_field_id,
                prev_tile_id,
                current_field_id: field_id,
                prev_selected_id,
                "is-edit": false
            });

            const $modal = $("#input-modal");
            const uppercase_field = field_id.charAt(0).toUpperCase() + field_id.slice(1, -1);
            $modal.find("#field-id").text(uppercase_field);

            $modal.find("#submit").text("Submit");
            $modal.modal({
                backdrop: "static",
                show: true
            });
        } else {
            chooseGetFunctionToImplement(field_id, tile_id)
            .then((result, ...args) => {
                const [, { build_field_id }] = args;
                if (build_field_id !== "end") {
                    $(`#${build_field_id} .tile-rows`).empty();
                    buildTileRows(result, build_field_id);
                }
                return build_field_id;
            })
            .then((build_field_id) => {
                $(`#${build_field_id}`).slideDown();
            })
            .catch((x) => {
                showErrorModal(x, `loading ${field_id} field`);
            });
        }

        alterTileIfAccuracy(field_id);
    });
}

function alterTileIfAccuracy (field_id) {
    $("#type").trigger("change");
    const $metrics_opt = $("#metrics-options");
    const $option = $(".metric-option");
    if (field_id === "metrics") {
        $metrics_opt.show();
        $option.prop("disabled", false);
    } else {
        $metrics_opt.hide();
        $option.prop("disabled", true);
    }
}

function chooseGetFunctionToImplement (field_id, tile_id) {
    let result;
    let build_id;
    switch (field_id) {
        case "teams":
            result = getModules(tile_id);
            build_id = "modules";
            $("#metrics").slideUp();
            break;
        case "modules":
            result = getMetrics(tile_id);
            build_id = "metrics";
            break;
        default:
            result = $.ajax();
            build_id = "end";
            break;
    }

    result.build_field_id = build_id;
    return result;
}

function getModules (team_id) {
    return $.getJSON(`/input/getModulesByTeamID/${team_id}`);
}

function getMetrics (module_id) {
    return $.getJSON(`/input/getMetricsByModuleID/${module_id}`);
}

function initializeTileExpandOnClick () {
    $(document).on("click", ".tile-expand", (event) => {
        event.stopPropagation();
        const { currentTarget } = event;
        const $target = $(currentTarget);
        const tile_data = $target.parents(".tile").data();
        const field_id = $target.parents(".tile-field").attr("id");

        const $form = $("#input-form");
        $form.data({
            current_tile_id: tile_data.id,
            current_field_id: field_id,
            "is-edit": true,
            current_submetric_id: null,
            current_submetric_table_name: null,
            current_column_names: null
        });

        $(".form-input").each((index, element) => {
            $(element).val(tile_data[element.name]);
        });

        const $cbox = $("#submetrics_cbox");
        if ($cbox.is(":checked") === true) $cbox.trigger("click");

        // Show accuracy-related submetric fields if there's any
        $("#submetric-columns").empty();
        if (typeof tile_data.submetric_id !== "undefined") {
            const {
                submetric_id, submetric_table_name,
                submetric_columns, show_on_modal
            } = tile_data;

            $form.data({
                current_submetric_id: submetric_id,
                current_submetric_table_name: submetric_table_name,
                current_submetric_columns: submetric_columns
            });

            $cbox.trigger("click");

            let tbl_name = submetric_table_name;
            tbl_name = tbl_name.replace("submetrics_", "");
            $("#submetric_table_name").val(tbl_name);

            const column_names = submetric_columns.split(",");
            column_names.forEach((name) => {
                const textfield_name = addSubmetricColumnInput(true);
                const label = name.split("_")
                .map(x => x.charAt(0).toUpperCase() + x.slice(1))
                .join("_");
                $(`input[name=${textfield_name}]`).val(label);
            });

            const $show = $("#show_on_modal");
            $show.prop("checked", false);
            if (show_on_modal === 1) {
                $show.trigger("click");
            }
        }

        alterTileIfAccuracy(field_id);

        const $modal = $("#input-modal");
        const uppercase_field = field_id.charAt(0).toUpperCase() + field_id.slice(1, -1);
        $modal.find("#field-id").text(uppercase_field);
        $modal.find("#submit").text("Submit Edit");
        $modal.modal({
            backdrop: "static",
            show: true
        });
    });
}

function initializeInputForm () {
    const form_id = "#input-form";

    $.validator.addMethod(
        "moreThanTwoColumns",
        (value, element) => {
            const $alert = $("#less-column-alert");
            const bool = $("#submetric-columns input").length >= 2;

            if (bool) $alert.hide();
            else $alert.show();
            return bool;
        }, ""
    );

    $.validator.addMethod(
        "alphanumeric",
        (value, element) => /^\w+$/i.test(value)
        , "Letters, numbers, and underscores only please"
    );

    return $(form_id).validate({
        ignore: [],
        debug: true,
        rules: {
            name: "required",
            desc: "required",
            type: "required",
            submetric_table_name: {
                required: true,
                alphanumeric: true
            },
            submetric_column: {
                moreThanTwoColumns: true
            }
        },
        messages: { comments: "" },
        focusCleanup: true,
        errorPlacement (error, element) {
            const placement = $(element).closest(".form-group");
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(placement);
            } // remove on success

            element.parents(".form-group").addClass("has-feedback");
        },
        success (label, element) {
            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if (!$(element).next("span")) {
                $("<span class='glyphicon glyphicon-ok form-control-feedback' style='top:0px; right:37px;'></span>").insertAfter($(element));
            }

            $(element).closest(".form-group").children("label.error").remove();
        },
        highlight (element, errorClass, validClass) {
            $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
            $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
        },
        unhighlight (element, errorClass, validClass) {
            $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
        },
        submitHandler (form) {
            $("#input-modal").modal("hide");

            const attr_data = $(form_id).data();
            const data = $(form_id).serializeArray();
            const input = {};

            const { current_field_id } = attr_data;
            const table_name = current_field_id === "teams" ? "dynaslope_teams" : current_field_id;

            const single_field = current_field_id.slice(0, -1);
            data.forEach(({ name, value }) => {
                if (["desc", "name", "type"].includes(name)) {
                    input[`${single_field}_${name}`] = value;
                }
            });

            let obj_to_send = {};
            if ($(form_id).data("is-edit")) {
                const { current_tile_id } = attr_data;
                const field = current_field_id.slice(0, -1);

                obj_to_send = {
                    data: input,
                    table_name,
                    column: `${field}_id`,
                    key: current_tile_id
                };

                updateDataOnDatabase(obj_to_send)
                .then(() => {
                    const submetrics = processSubmetricsTableUpdating();
                    refreshUpdatedTile(current_field_id, current_tile_id, input, submetrics);
                })
                .catch((x) => {
                    showErrorModal(x, "updating data");
                });
            } else {
                const { prev_field_id, prev_tile_id } = attr_data;

                if (typeof prev_field_id !== "undefined") {
                    const field = prev_field_id.slice(0, -1);
                    input[`${field}_id`] = prev_tile_id;
                }

                obj_to_send = {
                    data: input,
                    table_name
                };

                insertDataToDatabase(obj_to_send)
                .then((id) => {
                    processSubmetricsTableCreation(id);
                    refreshFields(current_field_id, prev_field_id);
                })
                .catch((x) => {
                    showErrorModal(x, "inserting data");
                });
            }

            console.log(obj_to_send);
        }
    });
}

function addRulesOnColumn (input_name) {
    $(`input[name=${input_name}]`).rules("add", {
        required: true,
        moreThanTwoColumns: true,
        maxlength: 120,
        alphanumeric: true
    });
}

function initializeOnModalClose () {
    $("#input-modal").on("hide.bs.modal", () => {
        const { prev_selected_id, current_field_id } = $("#input-form").data();
        const $cur_field = $(`#${current_field_id}`);
        $cur_field.find(".add-tile").removeClass("tile-selected");
        if (typeof prev_selected_id !== "undefined") {
            $cur_field.find(`.tile[data-id=${prev_selected_id}]`).addClass("tile-selected");
        }
    });
}

function insertDataToDatabase (obj_to_send) {
    return $.post("/input/generalInsertToDatabase", obj_to_send);
}

function updateDataOnDatabase (obj_to_send) {
    return $.post("/input/generalUpdateData", obj_to_send);
}

function refreshFields (field_id, prev_field_id) {
    switch (field_id) {
        case "teams":
            buildDynaslopeTeamField();
            $("#modules, #metrics").slideUp();
            break;
        case "modules":
            $("#metrics").slideUp();
            // fall through
        case "metrics":
            $(`#${prev_field_id} .tile-selected`).trigger("click");
            // fall through
        default:
            break;
    }
}

function refreshUpdatedTile (current_field_id, current_tile_id, input, submetrics) {
    const $updated = $(`#${current_field_id}`).find(`.tile[data-id=${current_tile_id}]`);
    const single_field = current_field_id.slice(0, -1);
    const _name = `${single_field}_name`;
    const _desc = `${single_field}_desc`;
    const {
        [_name]: name,
        [_desc]: description
    } = input;

    $updated.data(input);

    if (Object.keys(submetrics).length !== 0) {
        const { submetric_table_name, submetric_columns, show_on_modal } = submetrics;
        $updated.data({
            submetric_table_name,
            submetric_columns: submetric_columns.join(","),
            show_on_modal
        });
    }

    $updated.find(".tile-title")
    .text(name).end()
    .find(".tile-description")
    .text(`${description.substring(0, 30)}...`);
}

function showErrorModal (ajax, module) {
    const { responseText, status, statusText } = ajax;
    const $modal = $("#error-modal");
    const $body_ul = $modal.find(".modal-body ul");
    const text = `<li>Error loading ${module}</li>`;

    if (!$modal.is(":visible")) {
        $body_ul.empty()
        .html(text);
        $modal.modal("show");
    } else {
        $body_ul.append(text);
    }

    console.log(`%c► Error ${module}\n► Status ${status}: ${statusText}\n\n${responseText}`, "background: rgba(255,127,80,0.3); color: black");
}

function processSubmetricsTableCreation (id) {
    const metric_type = $("#type").val();
    const is_sub_checked = $("#submetrics_cbox").is(":checked");
    if (metric_type === "1" && is_sub_checked) {
        const tbl_name = $("#submetric_table_name").val();
        const submetrics = {
            metric_id: id,
            submetric_table_name: `submetrics_${tbl_name}`,
            show_on_modal: $("#show_on_modal").is(":checked") ? 1 : 0
        };
        submetrics.submetric_columns = getAllSubmetricColumnNames();

        createSubmetricsTable(submetrics)
        .catch((x) => {
            showErrorModal(x, "inserting data");
        });

        console.log(submetrics);
    }
}

function processSubmetricsTableUpdating () {
    const metric_type = $("#type").val();
    const is_sub_checked = $("#submetrics_cbox").is(":checked");
    let submetrics = {};
    if (metric_type === "1" && is_sub_checked) {
        const {
            current_submetric_table_name, current_submetric_columns,
            current_submetric_id, current_tile_id: metric_id
        } = $("#input-form").data();
        const tbl_name = $("#submetric_table_name").val();
        const updated_tbl_name = `submetrics_${tbl_name}`;
        submetrics = {
            metric_id,
            submetric_id: current_submetric_id,
            submetric_table_name: updated_tbl_name,
            show_on_modal: $("#show_on_modal").is(":checked") ? 1 : 0
        };
        submetrics.submetric_columns = getAllSubmetricColumnNames();

        if (current_submetric_table_name !== updated_tbl_name) {
            const old_table_name = current_submetric_table_name !== null ? current_submetric_table_name : "new";
            submetrics.old_table_name = old_table_name;

            if (old_table_name !== "new") {
                if (current_submetric_columns !== submetrics.submetric_columns.join(",")) {
                    const old_columns = current_submetric_columns !== null ? current_submetric_columns.split(",") : null;
                    if (old_columns !== null) submetrics.old_columns = old_columns;
                }
            }
        }

        updateSubmetricsTable(submetrics)
        .catch((x) => {
            showErrorModal(x, "updating data");
        });

        console.log(submetrics);
    }

    return submetrics;
}

function getAllSubmetricColumnNames () {
    const columns = [];
    $(".submetric_column").each((i, elem) => {
        if (elem.value !== "") {
            const column_name = elem.value.trim()
            .toLowerCase().replace(" ", "_");
            columns.push(column_name);
        }
    });
    return columns;
}

function createSubmetricsTable (submetrics) {
    return $.post("/input/createSubmetricsTable", submetrics);
}

function updateSubmetricsTable (submetrics) {
    return $.post("/input/updateSubmetricsTable", submetrics);
}

function initializeSubmetricSwitchToggle () {
    $(document).on("change", "#type", ({ currentTarget }) => {
        const $submetrics_switch = $("#submetrics-switch");
        const $cbox = $("#submetrics_cbox");
        const $submetrics_opt = $("#submetrics-option");

        if ($(currentTarget).find(":selected").text() === "Accuracy") {
            $submetrics_switch.show();
        } else {
            $submetrics_switch.hide();
            $cbox.prop("checked", false);
            $submetrics_opt.hide();
            $submetrics_opt.find("input").prop("disabled", true);
        }
    });
}

function initializeSubmetricSwitch () {
    $(document).on("click", "#submetrics_cbox", (event) => {
        const $cbox = $("#submetrics_cbox");
        const $submetrics_opt = $("#submetrics-option");
        const $input = $("#submetrics-option input");

        if ($cbox.is(":checked") === true) {
            $submetrics_opt.show();
            $input.prop("disabled", false);
        } else {
            $submetrics_opt.hide();
            $input.prop("disabled", true);
        }
    });
}

function initializeAddColumnButtonOnClick () {
    $("#add-submetric").click(() => {
        addSubmetricColumnInput();
    });
}

function addSubmetricColumnInput (disable_remove = false) {
    const col_name = `submetric_column_${submetric_column_num}`;
    const $clone = $("#submetric-template").clone()
    .prop("hidden", false);

    $clone.find("input").each((i, elem) => {
        $(elem).attr({ name: col_name, disabled: false });
    });

    $clone.find(".remove").each((i, elem) => {
        $(elem).attr({ disabled: disable_remove });
    });

    $("#submetric-columns").append($clone);

    submetric_column_num += 1;
    addRulesOnColumn(col_name);

    return col_name;
}

function removeInputField () {
    $(document).on("click", ".remove", ({ currentTarget }) => {
        $(currentTarget).closest("div.form-group").remove();
    });
}
