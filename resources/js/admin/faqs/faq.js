$(function() {
    filter();
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        filter(page);
    });

    $('#button-edit-faq').on('click', (function(e) {
        e.preventDefault();
        var frm = $('#edit-faq-form');
        var btn = $('#button-edit-faq');
        var id = $('#faqId').val();
        var formData = new FormData($("#edit-faq-form")[0]);
        var en_content = CKEDITOR.instances.edit_en_content.getData();
        var ar_content = CKEDITOR.instances.edit_ar_content.getData();
        if (frm.valid()) {
            var showLoader = 'Processing...';
            showButtonLoader(btn, showLoader, 'disable');
            formData.append('en[content]', en_content);
            formData.append('ar[content]', ar_content);
            $.ajax({
                url: process.env.MIX_APP_URL + '/admin/faqs/' + id,
                type: "POST",
                data: formData,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showButtonLoader(btn, showLoader, 'enable');
                        successToaster(response.message, 'edit-faq', { timeOut: 2000 });
                        setTimeout(function() {
                            location.reload();
                        }, 200);
                    } else {
                        btn.prop('disabled', false);
                        btn.html('Save');
                        errorToaster(response.message, 'edit-faq', { timeOut: 2000 });
                    }
                },
                error: function(response) {
                    btn.prop('disabled', false);
                    handleError(response);
                }
            });
        }
    }));

    $('#button-faq').on('click', function(e) {
        var frm = $('#add-faq-form');
        var btn = $('#button-faq');
        var formData = new FormData($("#add-faq-form")[0]);
        var en_content = CKEDITOR.instances.en_content.getData();
        var ar_content = CKEDITOR.instances.ar_content.getData();
        if (frm.valid()) {
            var showLoader = 'Processing...';
            showButtonLoader(btn, showLoader, 'disable');
            formData.append('en[content]', en_content);
            formData.append('ar[content]', ar_content);
            $.ajax({
                url: process.env.MIX_APP_URL + '/admin/faqs',
                type: "POST",
                data: formData,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function(response) {
                    showButtonLoader(btn, showLoader, 'enable');
                    if (response.success) {
                        successToaster(response.message, {
                            timeOut: 2000
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    } else {
                        btn.prop('disabled', false);
                        errorToaster(response.message, {
                            timeOut: 1000
                        });
                    }

                },
                error: function(data) {
                    btn.prop('disabled', false);
                    handleError(data);
                    showButtonLoader(btn, 'Add-Faq', 'enable');
                }
            })
        }
    });
});

window.filter = function(page) {
    console.log("alert");
    var question = $('#question').val();
    if (question) {
        $('.dot').addClass('dot-success');
    }
    $.ajax({
        url: process.env.MIX_APP_URL + '/admin/faq-filter',
        type: "GET",
        data: {
            search: question,
            page: page
        },
        success: function(response) {
            $('#faqs').html(response);
        },
        error: function(data) {
            handleError(data);
        }
    });
}

window.deleteFaq = function(id) {
    var url = process.env.MIX_APP_URL + '/admin/faqs/' + id;
    var type = "DELETE";
    swal.fire({
        title: 'Are you sure you want to delete ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(data) {
                    if (data.success) {
                        successToaster(data.message, type, { timeOut: 2000 });
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        errorToaster(data.message, type, { timeOut: 2000 });
                    }
                },
                error: function(err) {
                    handleError(err);
                }
            });
        }
    })
};

window.editFaq = function(id) {
    $.ajax({
        method: 'Get',
        url: process.env.MIX_APP_URL + '/admin/faqs/' + id + '/edit',
        success: function(response) {
            $('#editModel').html(response);
            $('#editModel').modal('show');
            CKEDITOR.replace('edit_en_content', {});
            CKEDITOR.replace('edit_ar_content', {contentsLangDirection: 'rtl'});
        },
        error: function(data) {
            handleError(data);
        },
    });
}

window.addFaq = function() {
    $.ajax({
        method: 'Get',
        url: process.env.MIX_APP_URL + '/admin/faqs/create',
        success: function(response) {
            $('#addNewFaq').html(response);
            $('#addNewFaq').modal('show');
            CKEDITOR.replace('en_content', {});
            CKEDITOR.replace('ar_content', {contentsLangDirection: 'rtl'});
        },
        error: function(data) {
            handleError(data);
        },
    });
}
$(".deleteFaqImage").click(function() {
    $(this).parent().parent().css('display', 'none');
    $("#faqAddImageDiv").css('display', 'block');
    $("#faqAddImageDiv").children(".uploadStuff").css('display', 'block');
    $("#old_images").val('');
    $("#uploadId").val('');
});