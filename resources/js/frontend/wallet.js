
$("#addWalletBalanceForm").on('submit', (function (e) {
    e.preventDefault();
    var frm = $('#addWalletBalanceForm');
    var btn = $('#addWalletBalanceBtn');
    var url = $(this).attr('action');
    var amount = $('#amount').val();
   
    if (frm.valid()) {
        window.location.href = process.env.MIX_APP_URL + '/checkout?amount='+amount;
    }
}));

$("#redeemBtn").on('click', (function (e) {
    e.preventDefault();
    var frm = $('#redeemForm');
    var btn = $('#redeemBtn');
    var btnName = btn.html();
    var url = $('#redeemForm').attr('action');
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        $.ajax({
            url: url,
            type: "POST",
            data: frm.serialize(),            
            success: function (response) {
                showButtonLoader(btn, btnName, 'disabled');
                successToaster(response.message);
                frm[0].reset();
                setTimeout(() => {
                    location.reload();
                }, 200);
            },
            error: function (data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

window.getTransactionList = function getTransactionList(url='') {
    if (url == '') {
        url = walletLitUrl;
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            $("#transactionList").html(response.data);
        },
        error: function (data) {
            handleError(data);
        },
    });
};
getTransactionList();

$('#sideMenuToggle').on('click', function () {
    $('.sideMenu').addClass('show');
});

$('#closeMenu').on('click', function () {
    $('.sideMenu').removeClass('show');
})

window.redeemPointModal = function redeemPointModal() {
    $('#redeemPointModal').modal('show');
}

window.addAmountModal = function addAmountModal() {
    $('#addAmountModal').modal('show');
}

window.updateSar = function updateSar() {
    $('#sar').val('');
    var points = $('#points').val();
    var sar = points/10;
    if(sar) {
        $('#sar').val(sar);
    }
    
 
}