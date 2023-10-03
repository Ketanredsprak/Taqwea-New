$("#forgotPasswordBtn").on('click', (function(e) {
    e.preventDefault();
    var frm = $('#forgotPasswordForm');
    var btn = $('#forgotPasswordBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        $.ajax({
            url: process.env.MIX_APP_URL + "/forgot-password/send-otp",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                showButtonLoader(btn, btnName, 'enable');
                successToaster(response.message);
                setTimeout(() => {
                    window.location.href = response.data.redirectUrl;
                }, 2000);
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

$("#createPasswordFrom").on('submit', (function(e) {
    e.preventDefault();
    var frm = $('#createPasswordFrom');
    var btn = $('#createPasswordBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        $.ajax({
            url: process.env.MIX_APP_URL + "/forgot-password/create-password",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                showButtonLoader(btn, btnName, 'disabled');
                successToaster(response.message);
                setTimeout(() => {
                    window.location.href = process.env.MIX_APP_URL + '/login';
                }, 2000);
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

$('#showPassword').on('click', function() {
    $('#showPassword span').toggleClass('icon-eye icon-eye-close')
    $(this).siblings(".form-control").attr('type', function(index, attr) {
        return attr == 'text' ? 'password' : 'text';
    });
});
$('#showPassword2').on('click', function() {
    $('#showPassword2 span').toggleClass('icon-eye icon-eye-close')
    $(this).siblings(".form-control").attr('type', function(index, attr) {
        return attr == 'text' ? 'password' : 'text';
    });
}); 