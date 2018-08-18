function showModal(page,pms_data) {
    $.post("http://pms/modal_alpha/index", {page}).done((response) => {
        const html = JSON.parse(response);
        $("body").append(html);
        $("#pms_modal").attr("id", pms_data.modal_id);
        this.is_attached = true;
        $("#"+pms_data.modal_id).modal("show");
    });
}

function sendPMSReport() {
	console.log(pms_data);
}