$("#adminLoginForm").on('submit', (function(e) {
    $('#tz').val(momentTz.tz.guess());
    e.preventDefault();
    var frm = $('#adminLoginForm');
    var btn = $('#adminLoginBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        showButtonLoader(btn, btnName, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + "/admin/submit-login",
            type: "POST",
            data: frm.serialize(),
            success: function(data) {
                successToaster(data.message, 'Login');
                setTimeout(function() {
                    window.location.href = data.redirectionUrl;
                }, 1500);
            },
            error: function(data) {
                var obj = jQuery.parseJSON(data.responseText);
                errorToaster(obj.message, 'Login');
            },
            complete: function() {
                showButtonLoader(btn, btnName, 'enable');
            }
        });
    }
}));