$(".resend-otp").on('click', (function(e) {
    e.preventDefault();
    $.ajax({
        url: process.env.MIX_APP_URL + "/accountant/resend-otp",
        type: "POST",
        data: { _token: $('meta[name="csrf-token"]').attr('content'), email: window.email, type: 'forgot_password' },
        success: function(data) {
            successToaster(data.message);
        },
        error: function(data) {
            handleError(data);
        },
    });
}));