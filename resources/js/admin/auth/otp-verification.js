$(function() {
    $(".resend-otp").on('click', (function(e) {
        e.preventDefault();
        $.ajax({
            url: process.env.MIX_APP_URL + "/api/v1/send-otp",
            type: "POST",
            data: {
                email: $("#user-email").val(),
                type: 'two_factor_auth'
            },
            success: function(data) {
                successToaster(data.message);
            },
            error: function(data) {
                handleError(data);
            },
        });
    }));

    $(".otp-control").on('keyup', function() {
        if (this.value.length == this.maxLength) {
            $(this).next('.otp-control').trigger('focus');
        }
    });
    //only number
    window.onlyNumberKey = function(event) {
        // Only ASCII charactar in that range allowed 
        var ASCIICode = (event.which) ? event.which : event.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    $("#otp-verify").on('click', (function(e) {
        e.preventDefault();
        var btn = $("#otp-verify");
        var frm = $('#otp-verification-frm');
        var btnName = btn.html();
        var otp = '';
        $('.otp-control').each(function() {
            otp += $(this).val();
        });
        $('#otp').val(otp);
        if (frm.valid()) {
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: process.env.MIX_APP_URL + "/admin/opt-verification",
                type: "POST",
                data: frm.serialize(),
                success: function(data) {
                    successToaster(data.message, 'Otp Verify');
                    if (data.redirectionUrl) {
                        setTimeout(function() {
                            window.location.href = data.redirectionUrl;
                        }, 1500);
                    }
                },
                error: function(data) {
                    var obj = JSON.parse(data.responseText);
                    errorToaster(obj.message, 'Otp Verify');
                },
                complete: function() {
                    showButtonLoader(btn, btnName, 'enable');
                }
            });
        }
    }));
});