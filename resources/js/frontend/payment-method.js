const { lang } = require("moment");

window.getCardList = function getCardList(url = '') {
    if (url == '') {
        url = cardLitUrl;
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $("#show-card-id").html(response.data);
        },
        error: function(data) {
            handleError(data);
        },
    });
};
getCardList();
$('#sideMenuToggle').on('click', function() {
    $('.sideMenu').addClass('show');
});

$('#closeMenu').on('click', function() {
    $('.sideMenu').removeClass('show');
});
$(function() {
    window.deleteCard = function(name, id) {
        if (name == 'tutor') {
            var url = '/tutor/payment-method/' + id
        }
        if (name == 'student') {
            var url = '/student/payment-method/' + id
        }
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary mr-2',
                cancelButton: 'btn btn-light ripple-effect-dark'
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: Lang.get('labels.are_you_sure'),
            text: Lang.get('labels.you_want_to_delete_this_card'),
            showCancelButton: true,
            confirmButtonText: Lang.get('labels.yes_cancel_it'),
            cancelButtonText: Lang.get('labels.cancel'),
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: process.env.MIX_APP_URL + url,
                    success: function(data) {
                        successToaster(data.message);
                        getCardList();
                    },
                    error: function(err) {
                        handleError(err);
                    }
                });
            }
        });
    }
    $("#addBankDetailForm").on('submit', (function(e) {
        e.preventDefault();
        var frm = $('#addBankDetailForm');
        var btn = $('#addBankDetailBtn');
        var url = $(this).attr('action');
        var btnName = btn.html();
        if (frm.valid()) {
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: url,
                type: "POST",
                data: frm.serialize(),
                success: function(response) {
                    showButtonLoader(btn, btnName, 'disabled ');
                    successToaster(response.message);
                },
                error: function(data) {
                    handleError(data);
                    showButtonLoader(btn, btnName, 'enable');
                },
            });
        }
    }));

    window.reset = function() {
        $('#beneficiary_name').val('');
        $('#account_number').val('');
    }

    window.getCode = function(){
    var code = $('.select-bank-code').val();
    $('#code').val(code);
    }
    

});