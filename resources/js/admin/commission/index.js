$("#submit-btn").on('click', (function(e) {
    e.preventDefault();
    var frm = $('#commission-form');
    var btn = $('#submit-btn');
    if (frm.valid()) {
        btn.prop('disabled', true);
        var showLoader = 'process...';
        showButtonLoader(btn, showLoader, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/commission-post',
            type: "POST",
            data: frm.serialize(),
            success: function(response) {
                if (response.success) {
                    showButtonLoader(btn, showLoader, 'enable');
                    successToaster(response.message, 'tutor', { timeOut: 2000 });
                    setTimeout(function() {
                        window.location.href = process.env.MIX_APP_URL + '/admin/commission';
                    }, 2000);
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
}));