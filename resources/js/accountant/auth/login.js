$("#accountantLoginForm").on('submit', (function(e) {
    $('#tz').val(momentTz.tz.guess());
    e.preventDefault();
    var frm = $('#accountantLoginForm');
    var btn = $('#accountantLoginBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        showButtonLoader(btn, 'processing...', 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + "/accountant/submit-login",
            type: "POST",
            data: frm.serialize(),
            success: function(data) {
                successToaster(data.message, 'Login');
                setTimeout(function() {
                    window.location.href = data.redirectionUrl;
                }, 1500);
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