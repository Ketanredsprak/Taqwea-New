$("#signUpBtn").on('click', (function(e) {
    e.preventDefault();
    var frm = $('#signUpForm');
    var btn = $('#signUpBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        // Get base64 image and convert to image object
        if (formData.get('profile_image')) {
            var file = imageBase64toFile(formData.get('profile_image'), 'user_image');
            formData.delete('profile_image');
            formData.append("profile_image", file); // remove base64 image content
        }
        $.ajax({
            url: process.env.MIX_APP_URL + "/sign-up",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
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