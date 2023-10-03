$("#submitEnCms").on('click', (function(e) {
    var frm = $('#edit-cms-en-form');
    var btn = $('#submitEnCms');
    var btnName = btn.html();
    var url = frm.attr('action');
    var formData = new FormData($("#edit-cms-en-form")[0]);
    var page_content = CKEDITOR.instances.page_content.getData();
    if (frm.valid()) {
        showButtonLoader(btn, btnName, 'disabled');
        formData.append('en[page_content]', page_content);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    successToaster(response.message, 'Cms page');
                }
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            },
            error: function(data) {
                handleError(data);
            },
            complete: function() {
                showButtonLoader(btn, btnName, 'enable');
            }
        });
    }
}));
$("#submitArCms").on('click', (function(e) {
    var frm = $('#edit-cms-ar-form');
    var btn = $('#submitArCms');
    var btnName = btn.html();
    var url = frm.attr('action');
    var formData = new FormData($("#edit-cms-ar-form")[0]);
    var page_content = CKEDITOR.instances.description1.getData();
    if (frm.valid()) {
        showButtonLoader(btn, btnName, 'disabled');
        formData.append('ar[page_content]', page_content);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    successToaster(response.message, 'Cms page');
                }
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            },
            error: function(data) {
                handleError(data);
            },
            complete: function() {
                showButtonLoader(btn, btnName, 'enable');
            }
        });
    }
}));