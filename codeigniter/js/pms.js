
const MODAL = {
    modal_id: "pms_modal",
    metric_name: null,
    module_name: null,
    type: "accuracy",
    is_attached: false,
    validator: null,
    data: {},

    __attach (modal_id = "pms_modal") {
        $.validator.addMethod(
            "atLeastOneChecked",
            (value, element) => $("#accuracy-checkbox .acc-checkbox:checked").length > 0,
            "Check at least one"
        );

        if ($(`#${modal_id}`).length > 0) {
            console.log("%c► PMS Modal:\nPMS Modal ID already exists!", "background: rgba(255,127,80,0.3); color: black");
            return;
        }

        const form = {
            metric_name: this.metric_name
        };

        $.ajax({
            url: "http://www.dewslandslide.com:5053/modal",
            type: "GET",
            data: form,
            contentType: "text/plain",
            xhrFields: {
                withCredentials: false
            },
            crossDomain: true
        })
        .done((x) => {
            const html = JSON.parse(x);
            this.modal_id = modal_id;
            $("body").append(html);
            $("#pms_modal").attr("id", this.modal_id);
            this.is_attached = true;

            $.validator.addClassRules({
                "acc-checkbox": {
                    atLeastOneChecked: true
                }
            });

            this.__validate();
        });
    },

    show () {
        const $modal = $(`#${this.modal_id}`);
        if (this.is_attached) {
            const $form = $(`#${this.modal_id} .pms-form`);
            $form.validate().resetForm();
            $form[0].reset();
            $modal.modal("show");
        } else {
            setTimeout(() => { $modal.modal("show"); }, 1000);
        }
    },

    __send (report, modal_id) {
        console.log("%c► PMS Modal:\nSending PMS report:", "background: rgba(255,127,80,0.3); color: black");
        console.log(report);

        $.post("http://www.dewslandslide.com:5053/api/insertReport", report)
        .done((result) => {>>>>>>> master
            let res = JSON.parse(result);
            if (res.status !== true) {
                $.notify('Failed to submit report.','error ');
            }
        })
        .catch(({ responseText, status: conn_status, statusText }) => {
            alert(`Status ${conn_status}: ${statusText}`);
            console.log(`%c► PMS ${responseText}`, "background: rgba(255,127,80,0.3); color: black");
        });

        $(`#${modal_id}`).modal("hide");
    },

    set (data) {
        const copy = Object.assign({}, this.data);
        this.data = { ...copy, ...data };

        const { metric_name } = data;
        if (typeof metric_name !== "undefined") {
            this.metric_name = metric_name;

            const $acc_cbox = $(`#${this.modal_id} #accuracy-checkbox`);
            if ($.trim($acc_cbox.html()).length === 0) {
                this.__getSubmetricCheckboxes(metric_name)
                .done((x) => {
                    const html = JSON.parse(x);
                    $acc_cbox.append(html);

                    $.validator.addClassRules({
                        "acc-checkbox": {
                            atLeastOneChecked: true
                        }
                    });
                });
            }
        }

        this.__validate();
    },

    __getSubmetricCheckboxes (metric_name) {
        const url = `http://dewslpms.com/modal/getSubmetricCheckboxes/${metric_name}/1`;
        return $.ajax({
            url,
            type: "GET",
            contentType: "text/plain",
            xhrFields: {
                withCredentials: false
            },
            crossDomain: true
        });
    },

    print () {
        const { data, modal_id } = this;
        console.log("%c► PMS Modal:\nPMS Modal data set", "background: rgba(255,127,80,0.3); color: black");
        console.log({ modal_id, data });
    },

    __validate () {
        const {
            __send, modal_id, metric_name,
            module_name, type, data
        } = this;

        if (this.validator !== null) this.validator.destroy();
        this.validator = $(`#${modal_id} .pms-form`).validate({
            debug: true,
            rules: {
                report_message: "required"
            },
            // messages: {
            //     comments: "aa"
            // },
            errorPlacement (error, element) {
                const placement = $(element).closest(".form-group");
                if ($(element).hasClass("cbox_trigger_switch")) {
                    $("#errorLabel").append(error).show();
                } else if (placement) {
                    $(placement).append(error);
                } else {
                    error.insertAfter(placement);
                } // remove on success

                element.parents(".form-group").addClass("has-feedback");

                // Add the span element, if doesn't exists, and apply the icon classes to it.
                const $next_span = element.next("span");
                if (!$next_span[0]) {
                    if (element.is("input[type=number]")) $next_span.css({ top: "24px", right: "0px" });
                }
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
                if ($(element).parent().is(".datetime") || $(element).parent().is(".time")) {
                    $(element).nextAll("span.glyphicon").remove();
                    $("<span class='glyphicon glyphicon-remove form-control-feedback' style='top:0px; right:37px;'></span>").insertAfter($(element));
                } else $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
            },
            unhighlight (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                if ($(element).parent().is(".datetime") || $(element).parent().is(".time")) {
                    $(element).nextAll("span.glyphicon").remove();
                    $("<span class='glyphicon glyphicon-ok form-control-feedback' style='top:0px; right:37px;'></span>").insertAfter($(element));
                } else $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
            },
            submitHandler (form) {
                const submetrics = [];
                $(form).find("#accuracy-checkbox .acc-checkbox:checked").each((i, elem) => {
                    submetrics.push(elem.value);
                });

                const report = {
                    metric_name,
                    module_name,
                    ...data,
                    type,
                    report_message: $(form).find("#report_message").val(),
                    submetrics,
                    limit: "specific"
                };

                __send(report, modal_id);
            }
        });
    }
};

const PMS_MODAL = {
    create (args) {
        const { modal_id } = args;
        const obj = { ...MODAL, ...args };
        obj.__attach(modal_id);
        return obj;
    }
};

const PMS = {
    __checkPayload (report) {
        const categories = ["accuracy", "timeliness", "error_logs"];
        const { type } = report;

        if (!categories.includes(type)) {
            throw new Error(`Type "${type}" is not valid: use either "accuracy", "timeliness", or "error_logs"`);
        }

        const payload = ["metric_name", "module_name"];
        switch (type) {
            default: break;
            case "accuracy":
                payload.push("reference_id", "reference_table", "report_message");
                break;
            case "timeliness":
                payload.push("execution_time");
                break;
            case "error_logs":
                payload.push("report_message");
                break;
        }

        const missing = [];
        payload.forEach((key) => {
            if (!Object.keys(report).includes(key)) {
                missing.push(key);
            }
        });

        if (missing.length !== 0) {
            throw new Error(`Missing parameter(s): the following attributes must be filled - ${missing.join(", ")}`);
        }
    },

    send (report) {
        try {
            this.__checkPayload(report);
        } catch (error) {
            alert(error);
            console.log(`%c► PMS ${error}`, "background: rgba(255,127,80,0.3); color: black");
            return;
        }

        $.post("http://www.dewslandslide.com:5053/api/insertReport", report)
        .done((result) => {
            let res = JSON.parse(result);
            if (res.status !== true) {
                $.notify('Failed to submit report.','error');
            }
        })
        .catch(({ responseText, status: conn_status, statusText }) => {
            alert(`Status ${conn_status}: ${statusText}`);
            console.log(`%c► PMS ${responseText}`, "background: rgba(255,127,80,0.3); color: black");
        });
    }
};
