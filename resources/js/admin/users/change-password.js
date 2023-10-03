$(function() {
    $("#submit-btn").on('click', function(e) {
        e.preventDefault();
        var frm = $('#user-change-password-form');
        var btn = $('#submit-btn');
        if (frm.valid()) {
            btn.prop('disabled', true);
            var showLoader = 'processing...';
            showButtonLoader(btn, showLoader, 'disabled');
            $.ajax({
                url: frm.attr('action'),
                type: "POST",
                data: frm.serialize(),
                success: function(response) {
                    if (response.success) {
                        showButtonLoader(btn, 'Update', 'enable');
                        successToaster(response.message, 'tutor', { timeOut: 2000 });
                        $('#updatePassword').modal('hide');
                    } else {
                        btn.prop('disabled', false);
                        btn.html('Update');
                        errorToaster(response.message, 'tutor', { timeOut: 2000 });
                    }
                },
                error: function(data) {
                    handleError(data);
                },
            });
        }
    });
});