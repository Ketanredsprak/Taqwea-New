const { lang } = require("moment");

$("#addCertificateForm").on('submit', (function(e) {
    e.preventDefault();
    var frm = $('#addCertificateForm');
    var btn = $('#addCertificateBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                showButtonLoader(btn, btnName, 'enable');
                addCertificateHtml(response.data, 'en');
                frm[0].reset();
                $("#certificateimagePreviewDiv").hide();
                $(".uploadCertificate").show();
                $('#certificateModal').modal('hide');
                frm.find('.showFileName').html('Upload education degree');
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

window.addCertificateHtml = function addCertificateHtml(data, lang = 'en') {
    if (data.certificate_name) {
        $("#education-certificate-error").html('');
        var html = `<li class="d-flex align-items-center certificate-items">
            <div class="commonDegree-left">
                <div class="commonDegree-left_img overflow-hidden">`;
                if (data.certificate_type == 'pdf') {
                    html += `<img src="` + data.certificate_thumb + `" alt="">`;
                } else {
                    html += `<img src="` + data.certificate_url + `" alt="">`;
                }

                html += `</div>
                    <div class="commonDegree-left_txt">
                        <div class="text">` + data.certificate_name + `</div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="linkDark" onclick="deleteCertificate($(this),` + data.id + `)">
                    <span class="icon-delete"></span>
                </a>
            </li>`;
        $('#certificateList-' + lang).append(html);
    }
}

window.deleteCertificate = function deleteCertificate(obj, id) {
    var url = process.env.MIX_APP_URL + '/tutor/certificates/' + id;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light ripple-effect-dark'
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: Lang.get('labels.are_you_sure'),
        text: Lang.get('labels.you_want_to_delete_this_certificate'),
        showCancelButton: true,
        confirmButtonText: Lang.get('labels.yes_delete_it'),
        cancelButtonText: Lang.get('labels.cancel'),
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "DELETE",
                url: url,
                success: function(data) {
                    successToaster(data.message);
                    obj.parent().remove();
                },
                error: function(err) {
                    handleError(err);
                }
            });
        }
    });
};

window.certificateModal = function certificateModal() {
    $('#certificateModal').modal('show');
}

$(document).ready(function () {
    $("#certificate_name_en").keyup(function () {
        var val = $(this).val();
        $("#certificate_name_ar").val(val);
    });
});
