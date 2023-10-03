$("#avatar").change(function(e) {
    var frm = $('#avatar-form');
    e.preventDefault();
    if (frm.valid()) {
        var formData = new FormData($("#avatar-form")[0]);
        $.ajax({
            type: "POST",
            data: formData,
            url: process.env.MIX_APP_URL + '/admin/upload-profile',
            datType: 'JSON',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    successToaster(response.message, 'Profile');
                    setTimeout(function() {
                            window.location.href = process.env.MIX_APP_URL + '/admin/profile';
                        },
                        2000);
                }
            },
            error: function(data) {
                handleError(data);
            },
        });
    }
});

$("#submit-btn").on('click', (function(e) {
    e.preventDefault();
    var frm = $('#profile-update-frm');
    var btn = $('#submit-btn');
    var btnName = btn.html();
    if (frm.valid()) {
        btn.prop('disabled', true);
        showButtonLoader(btn, btnName, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/update-profile',
            type: "POST",
            data: frm.serialize(),
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    successToaster(response.message, 'Profile');
                    setTimeout(function() {
                        window.location.href = process.env.MIX_APP_URL + '/admin/profile';
                    }, 2000);
                }
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

$("#submit-button").on('click', (function(e) {
    var frm = $('#change-password-form');
    var btn = $('#submit-button');
    var btnName = btn.html();
    if (frm.valid()) {
        showButtonLoader(btn, btnName, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/change-password',
            type: "POST",
            data: frm.serialize(),
            success: function(response) {
                if (response.success) {
                    successToaster(response.message, 'Change-password');
                    setTimeout(function() {
                        window.location.href = process.env.MIX_APP_URL + '/admin/profile';
                    }, 2000);
                }
            },
            error: function(data) {
                var obj = JSON.parse(data.responseText);
                errorToaster(obj.message, 'Change-password');
            },
            complete: function() {
                showButtonLoader(btn, btnName, 'enable');
            }
        });
    }
}));