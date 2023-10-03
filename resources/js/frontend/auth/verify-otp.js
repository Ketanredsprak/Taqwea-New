$("#verifyOtpForm").on('submit', (function (e) {
    e.preventDefault();
    var frm = $('#verifyOtpForm');
    var btn = $('#verifyOtpBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        $.ajax({
            url: process.env.MIX_APP_URL + "/verify-otp",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                showButtonLoader(btn, btnName, 'enable');
                successToaster(response.message);
                setTimeout(() => {
                    window.location.href = response.data.redirectUrl;
                }, 2000);
            },
            error: function (data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

$(".otp-control").keyup(function () {
    if (this.value.length == this.maxLength) {
        $(this).next('.otp-control').focus();
    }
});

$(".otp-control").keydown(function (e) {
    if (this.value.length == 0 && e.which == 8) {
        $(this).prev('.otp-control').focus();
    }
});

//only number
window.onlyNumberKey = function onlyNumberKey(evt) {
    // Only ASCII charactar in that range allowed 
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

window.resendOtp = function resendOtp(email, type) {
    var btn = $(this);
    var btnName = $('#resendOtp').text();
    var showLoader = 'Processing...';
    showButtonLoader(btn, showLoader, 'disabled');
    $.ajax({
        url: process.env.MIX_APP_URL + "/send-otp",
        type: "POST",
        data: { 'email': email, 'type': type},
        success: function (response) {
            showButtonLoader(btn, btnName, 'enable');
            successToaster(response.message);
            clearTimerInterval();
            $('#resendOtp').css('display', 'none');
            timer(60);
        },
        error: function (data) {
            handleError(data);
            showButtonLoader(btn, btnName, 'enable');
        },
    });
}

let timerOn = true;
var timerInterval;
function clearTimerInterval(){
    clearTimeout(timerInterval);
}
function timer(remaining) {
    var m = Math.floor(remaining / 60);
    var s = remaining % 60;

    m = m < 10 ? '0' + m : m;
    s = s < 10 ? '0' + s : s;
    document.getElementById('timer').innerHTML = m + ':' + s;
    remaining -= 1;

    if (remaining >= 0 && timerOn) {
        timerInterval = setTimeout(function () {
            timer(remaining);
        }, 1000);
        return;
    }
    $('#resendOtp').css('display', 'block');
} 

timer(60);
