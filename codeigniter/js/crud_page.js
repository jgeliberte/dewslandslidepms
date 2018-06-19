
let FORM_VALIDATE;

$(document).ready(() => {
    reposition("#input-modal");

    FORM_VALIDATE = initializeInputForm();

    buildDynaslopeTeamField();

    initializeTileOnClick();
    initializeTileExpandOnClick();
    initializeOnModalClose();
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
                const { metric_type } = collection[i];
                $new_tile.data("type", metric_type);
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

        const $prev_selected = $(`#${field_id} .tile-selected`);
        const prev_selected_id = $prev_selected.data("id");
        $prev_selected.removeClass("tile-selected");
        $target.addClass("tile-selected");

        const $metrics_opt = $("#metrics-options");
        const $option = $(".metric-option");
        if (field_id === "metrics") {
            $metrics_opt.show();
            $option.prop("disabled", false);
        } else {
            $metrics_opt.hide();
            $option.prop("disabled", true);
        }

        if ($target.hasClass("add-tile")) {
            // Get the previous div/tile_field
            const $previous_field = $tile_field.prev(".tile-field");
            const prev_field_id = $previous_field.prop("id");
            const prev_tile_id = $previous_field.find(".tile-selected").data("id");
            const $form = $("#input-form");

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

            FORM_VALIDATE.resetForm();
            $(".form-group").removeClass("has-error has-success has-feedback");
            $form[0].reset();

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
    });
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

        $(".form-input").each((index, element) => {
            $(element).val(tile_data[element.name]);
        });

        const $metrics_opt = $("#metrics-options");
        const $option = $(".metric-option");
        if (field_id === "metrics") {
            $metrics_opt.show();
            $option.prop("disabled", false);
        } else {
            $metrics_opt.hide();
            $option.prop("disabled", true);
        }

        const $form = $("#input-form");
        $form.data({
            current_tile_id: tile_data.id,
            current_field_id: field_id,
            "is-edit": true
        });

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
    return $(form_id).validate({
        debug: true,
        rules: {
            name: "required",
            desc: "required",
            type: "required"
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
                input[`${single_field}_${name}`] = value === "" ? null : value;
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
                    refreshUpdatedTile(current_field_id, current_tile_id, input);
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
                .then(() => {
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

function refreshUpdatedTile (current_field_id, current_tile_id, input) {
    const $updated = $(`#${current_field_id}`).find(`.tile[data-id=${current_tile_id}]`);
    const single_field = current_field_id.slice(0, -1);
    const _name = `${single_field}_name`;
    const _desc = `${single_field}_desc`;
    const {
        [_name]: name,
        [_desc]: description
    } = input;

    $updated.data(input);

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
