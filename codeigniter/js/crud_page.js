
$(document).ready(() => {
    reposition("#input-modal");
    initializeInputForm();

    getDynaslopeTeams()
    .done((teams) => { buildTileRows(teams, "teams"); })
    .catch((x) => {
        showErrorModal(x, "loading Dynaslope Teams");
    });

    initializeTileOnClick();
    initializeTileExpandOnClick();
});

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
            const { name, description } = collection[i];

            let id_name;
            switch (tile_field) {
                case "teams":
                    id_name = "team_id"; break;
                case "modules":
                    id_name = "module_id"; break;
                default:
                    break;
            }

            // console.log(collection[i][id_name], i, id_name);

            $new_tile = $("#tile-template").clone().prop({
                id: "",
                "data-id": parseInt(collection[i][id_name], 10)
            });

            console.log($new_tile.data("id"), collection[i][id_name]);

            $new_tile.find(".tile-title")
            .text(name).end()
            .find(".tile-description")
            .text(`${description.substring(0, 30)}...`);
        }

        const $temp_tile = $column.append($new_tile);
        console.log("dsdsfs", $new_tile.data("id"));
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
        const form_id = "#input-form";

        $(`#${field_id} .tile-selected`).removeClass("tile-selected");
        $target.addClass("tile-selected");

        if ($target.hasClass("add-tile")) {
            // Get the previous div/tile_field
            const $previous_field = $tile_field.prev(".tile-field");
            const prev_field_id = $previous_field.prop("id");
            const prev_tile_id = $previous_field.find(".tile-selected").data("id");
            $(form_id).data({ prev_field_id, prev_tile_id, current_field_id: field_id });

            const $input = $("#input-modal");
            const uppercase_field = field_id.charAt(0).toUpperCase() + field_id.slice(1, -1);
            $input.find("#field-id").text(uppercase_field);
            $input.modal("show");
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
    console.log(team_id);
    return $.getJSON(`/input/getModulesByTeamID/${team_id}`);
}

function getMetrics (module_id) {
    return $.getJSON(`/input/getMetricsByModuleID/${module_id}`);
}

function initializeTileExpandOnClick () {
    $(document).on("click", ".tile-expand", ({ currentTarget }) => {
        const $target = $(currentTarget);
        const team_id = $target.parents(".tile").data("id");
        console.log(team_id);

        // TO DO SHOW MODAL PLUS EDIT FUNCTIONALITY
    });
}

function initializeInputForm () {
    const form_id = "#input-form";
    $(form_id).validate({
        debug: true,
        rules: {
            name: "required",
            description: "required"
        },
        messages: { comments: "" },
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
            const data = $(form_id).serializeArray();
            const input = {};
            data.forEach(({ name, value }) => { input[name] = value === "" ? null : value; });

            const { prev_field_id, prev_tile_id, current_field_id } = $(form_id).data();
            if (typeof prev_field_id !== "undefined") {
                const field = prev_field_id.slice(0, -1);
                input[`${field}_id`] = prev_tile_id;
            }

            insertDataToDatabase(input, current_field_id);
        }
    });
}

function insertDataToDatabase (input, current_field_id) {
    const table_name = current_field_id === "teams" ? "dynaslope_teams" : current_field_id;
    const obj_to_send = {
        data: input,
        table_name
    };

    console.log(obj_to_send);

    $.post("/input/generalInsertToDatabase", obj_to_send)
    .done((x) => {
        console.log(x);
    });

    // Refresh field
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
