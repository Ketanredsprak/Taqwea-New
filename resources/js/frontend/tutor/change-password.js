$("#changePasswordForm").on('submit', (function (e) {
    e.preventDefault();
    var frm = $('#changePasswordForm');
    var btn = $('#changePasswordBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                showButtonLoader(btn, btnName, 'enable');
                frm[0].reset();
                $("#changedSuccessfuly").modal('show');
            },
            error: function (data) {
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
$('#showPassword3').on('click', function() {
    $('#showPassword3 span').toggleClass('icon-eye icon-eye-close')
    $(this).siblings(".form-control").attr('type', function(index, attr) {
        return attr == 'text' ? 'password' : 'text';
    });
}); 