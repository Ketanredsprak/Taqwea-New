$("#completeSignUpForm").on('submit', (function(e) {
    e.preventDefault();
    var frm = $('#completeSignUpForm');
    var btn = $('#completeSignUpBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);

        $.ajax({
            url: process.env.MIX_APP_URL + "/sign-up/complete",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                showButtonLoader(btn, btnName, 'enable');
                successToaster(response.message, 'Login');
                setTimeout(function() {
                    window.location.href = response.data.redirectUrl;
                }, 1500);
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));