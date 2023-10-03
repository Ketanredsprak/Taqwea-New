window.forgotPassword = function() {
    var frm = $('#sendOtpFrm');
    var btn = $('#sendOtpBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        showButtonLoader(btn, btnName, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/post-forgot-password',
            type: "post",
            data: frm.serialize(),
            dataType: "JSON",
            success: function(response) {
                successToaster(response.message);
                setTimeout(function() {
                    window.location.href = process.env.MIX_APP_URL + '/admin/reset-password';
                }, 2000);
            },
            error: function(data) {
                showButtonLoader(btn, 'Send Mail', 'enable');
                handleError(data);
            },
            complete: function() {
                showButtonLoader(btn, btnName, 'enable');
            }
        });
    }
}