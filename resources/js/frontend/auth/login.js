$("#studentLoginForm").on('submit', (function(e) {
    e.preventDefault();
    var frm = $('#studentLoginForm');
    var btn = $('#studentLoginBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + "/login",
            type: "POST",
            data: frm.serialize(),
            cache: false,
            success: function(response) {
                showButtonLoader(btn, btnName, 'enable');
                successToaster(response.message, 'Login');
                setTimeout(function() {
                    window.location.href = response.redirectionUrl;
                }, 1500);
            },
            error: function(data) {
                console.log(data);
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