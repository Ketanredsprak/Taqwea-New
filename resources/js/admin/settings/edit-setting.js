$("#submit-btn").on('click', (function(e) {
    e.preventDefault();
    var frm = $('#edit-setting-form');
    var btn = $('#submit-btn');
    var btnName = btn.html();
    if (frm.valid()) {
        btn.prop('disabled', true);
        showButtonLoader(btn, btnName, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/setting-post',
            type: "POST",
            data: frm.serialize(),
            success: function(response) {
                if (response.success) {
                    showButtonLoader(btn, btnName, 'enable');
                    successToaster(response.message, 'setting');
                    setTimeout(function() {
                        window.location.href = process.env.MIX_APP_URL + '/admin/setting';
                    }, 2000);
                }
            },
            error: function(data) {
                handleError(data);

            },
            complete: function(data) {
                showButtonLoader(btn, btnName, 'enabled');
            }
        });
    }
}));
$("#submit-button").on('click', (function(e) {
    e.preventDefault();
    var frm = $('#top-up-frm');
    var btn = $('#submit-button');
    var btnName = btn.html();
    if (frm.valid()) {
        btn.prop('disabled', true);
        showButtonLoader(btn, btnName, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/top-up',
            type: "POST",
            data: frm.serialize(),
            success: function(response) {
                if (response.success) {
                    showButtonLoader(btn, btnName, 'enable');
                    successToaster(response.message, 'top-up');
                    setTimeout(function() {
                        window.location.href = process.env.MIX_APP_URL + '/admin/top-up';
                    }, 2000);
                }
            },
            error: function(data) {
                handleError(data);

            },
            complete: function(data) {
                showButtonLoader(btn, btnName, 'enabled');
            }
        });
    }
}));