$("#addEducationForm").on('submit', (function(e) {
    e.preventDefault();
    var frm = $('#addEducationForm');
    var btn = $('#addEducationBtn');
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
                addEducationHtml(response.data, 'en');
                $("#education_certificateimagePreviewDiv").hide();
                $(".uploadEducationCertificate").show();
                frm[0].reset();
                $('#educationModal').modal('hide');
                frm.find('.showFileName').html('Upload education degree');
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

window.addEducationHtml = function addEducationHtml(data, lang = 'en') {
    if (data.degree) {
        $("#education-certificate-error").html('');
        var html = `<li class="d-flex align-items-center education-items">
            <div class="commonDegree-left">
                <div class="commonDegree-left_img overflow-hidden">`;
                if (data.certificate_type == 'pdf') {
                    html += `<img src="` + data.certificate_thumb + `" alt="">`;
                } else {
                    html += `<img src="` + data.certificate_url + `" alt="">`;
                }

                html += `</div>
                    <div class="commonDegree-left_txt">
                        <div class="text font-bd">` + data.degree + `</div>
                        <div class="text">` + data.university + `</div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="linkDark" onclick="deleteEducation($(this),` + data.id + `)">
                    <span class="icon-delete"></span>
                </a>
            </li>`;
        $('#educationList-' + lang).append(html);
    }
}

window.deleteEducation = function deleteEducation(obj, id) {
    var url = process.env.MIX_APP_URL + '/tutor/educations/' + id;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light ripple-effect-dark'
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: Lang.get('labels.are_you_sure'),
        text: Lang.get('labels.you_want_to_delete_this_education'),
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

window.educationModal = function educationModal() {
    $('#educationModal').modal('show');
};

$(document).ready(function () {
    $("#degree_en").on('keyup',function () {
        var val = $(this).val();
        $("#degree_ar").val(val);
    });
    $("#university_en").keyup(function () {
        var val = $(this).val();
        $("#university_ar").val(val);
    });
});
