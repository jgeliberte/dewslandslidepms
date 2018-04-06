
const MODAL = {
    modal_id: "pms_modal",
    is_attached: false,
    form: null,

    __attach (modal_id = "pms_modal") {
        $.get("/modal")
        .done((x) => {
            this.modal_id = modal_id;
            $("body").append(x);
            $("#pms_modal").attr("id", this.modal_id);
            this.is_attached = true;

            this.__validate();
        });
    },

    show () {
        if (this.is_attached) {
            $(`#${this.modal_id}`).modal("show");
        } else {
            setTimeout(() => { $(`#${this.modal_id}`).modal("show"); }, 1000);
        }
    },

    send (report) {
        console.log("SEND");
        console.log(report);

        $.post("/api/insertReport", report)
        .done((result) => {
            console.log(result);
        })
        .catch(({ responseText, status: conn_status, statusText }) => {
            alert(`Status ${conn_status}: ${statusText}`);
            alert(responseText);
        });
    },

    __validate () {
        const { send, modal_id, metric_name } = this;
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
                console.log("VALIDATE");
                const report = {
                    metric_name,
                    team_id: '2',
                    module_name: 'Chatterbox',
                    report_message: $("#report_message").val(),
                    ts_data: "2018-02-10 00:00:00",
                    limit: "specific",
                    type: "accuracy"
                };

                send(report);
            }
        });
    }
};

const PMS_MODAL = {
    create (modal_id, metric_name) {
        // return Object.create(MODAL);
        const obj = { ...MODAL, metric_name };
        obj.__attach(modal_id);
        return obj;
    }
};

// const PMS_MODAL = (() => {
//     const pms_modal = {
//         modal_id: "pms_modal",
//         is_attached: false,

//         show () {
//             if (this.is_attached) {
//                 $(`#${this.modal_id}`).modal("show");
//             } else {
//                 setTimeout(() => { $(`#${this.modal_id}`).modal("show"); }, 1000);
//             }
//         },

//         send () {
//             console.log("SEND");
//         },

//         _validate () {
//             $("#pms-form").validate({
//                 debug: true,
//                 rules: {
//                     report_message: "required"
//                 },
//                 // messages: {
//                 //     comments: "Provide a reason to invalidate this event. If the event is not invalid and is really an end of event EWI, release it on the indicated end of validity."
//                 // },
//                 errorPlacement (error, element) {
//                     const placement = $(element).closest(".form-group");
//                     if ($(element).hasClass("cbox_trigger_switch")) {
//                         $("#errorLabel").append(error).show();
//                     } else if (placement) {
//                         $(placement).append(error);
//                     } else {
//                         error.insertAfter(placement);
//                     } // remove on success

//                     element.parents(".form-group").addClass("has-feedback");

//                     // Add the span element, if doesn't exists, and apply the icon classes to it.
//                     const $next_span = element.next("span");
//                     if (!$next_span[0]) {
//                         if (element.is("input[type=number]")) $next_span.css({ top: "24px", right: "0px" });
//                     }
//                 },
//                 success (label, element) {
//                     // Add the span element, if doesn't exists, and apply the icon classes to it.
//                     if (!$(element).next("span")) {
//                         $("<span class='glyphicon glyphicon-ok form-control-feedback' style='top:0px; right:37px;'></span>").insertAfter($(element));
//                     }

//                     $(element).closest(".form-group").children("label.error").remove();
//                 },
//                 highlight (element, errorClass, validClass) {
//                     $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
//                     if ($(element).parent().is(".datetime") || $(element).parent().is(".time")) {
//                         $(element).nextAll("span.glyphicon").remove();
//                         $("<span class='glyphicon glyphicon-remove form-control-feedback' style='top:0px; right:37px;'></span>").insertAfter($(element));
//                     } else $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
//                 },
//                 unhighlight (element, errorClass, validClass) {
//                     $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
//                     if ($(element).parent().is(".datetime") || $(element).parent().is(".time")) {
//                         $(element).nextAll("span.glyphicon").remove();
//                         $("<span class='glyphicon glyphicon-ok form-control-feedback' style='top:0px; right:37px;'></span>").insertAfter($(element));
//                     } else $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
//                 },
//                 submitHandler (form) {
//                     console.log("VALIDATE");
//                 }
//             });
//         },

//         attach (element, modal_id = "pms_modal") {
//             $.get("/modal")
//             .done((x) => {
//                 this.modal_id = modal_id;
//                 $(element).append(x);
//                 $("#pms_modal").attr("id", this.modal_id);
//                 this.is_attached = true;

//                 //this._validate();
//                 console.log(this);
//             });

//             console.log(this);
//         }
//     };

//     return Object.create(pms_modal);
// })();
