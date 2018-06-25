
const MODAL = {
    modal_id: "pms_modal",
    metric_name: null,
    module_name: null,
    type: "accuracy",
    is_attached: false,
    form: null,
    data: {},

    __attach (modal_id = "pms_modal") {
        if ($(`#${modal_id}`).length > 0) {
            console.log("%c► PMS Modal:\nPMS Modal ID already exists!", "background: rgba(255,127,80,0.3); color: black");
            return;
        }

        $.ajax({
            url: "http://localhost:5053/modal",
            type: "GET",
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

            // this.__validate();
        });
    },

    show () {
        if (this.is_attached) {
            $(`#${this.modal_id}`).modal("show");
        } else {
            setTimeout(() => { $(`#${this.modal_id}`).modal("show"); }, 1000);
        }
    },

    __send (report, modal_id) {
        console.log("%c► PMS Modal:\nSending PMS report:", "background: rgba(255,127,80,0.3); color: black");
        console.log(report);

        $.post("http://localhost:5053/api/insertReport", report)
        .done((result) => {
            let res = JSON.parse(result);
            if (res.status == true) {
                $.notify('Report Submitted.','success');
                $(".modal").modal("hide");
            } else {
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
        this.__validate();
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

        this.form = $(`#${modal_id} .pms-form`).validate({
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
                const report = {
                    metric_name,
                    module_name,
                    ...data,
                    type,
                    report_message: $("#report_message").val(),
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

        $.post("http://localhost:5053/api/insertReport", report)
        .done((result) => {
            let res = JSON.parse(result);
            if (res.status == true) {
                $.notify('Report Submitted.','success');
                $(".modal").modal("hide");
            } else {
                $.notify('Failed to submit report.','error');
            }
        })
        .catch(({ responseText, status: conn_status, statusText }) => {
            alert(`Status ${conn_status}: ${statusText}`);
            console.log(`%c► PMS ${responseText}`, "background: rgba(255,127,80,0.3); color: black");
        });
    }
};
