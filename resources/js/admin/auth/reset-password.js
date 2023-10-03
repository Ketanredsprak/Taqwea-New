$(".resend-otp").on('click', function(e) {
    e.preventDefault();
    $.ajax({
        url: process.env.MIX_APP_URL + "/admin/resend-otp",
        type: "POST",
        data: { _token: $('meta[name="csrf-token"]').attr('content'), email: window.email, type: 'forgot_password' },
        success: function(data) {
            successToaster(data.message);
        },
        error: function(data) {
            handleError(data);
        },
    });
});

window.isNumber = function(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}