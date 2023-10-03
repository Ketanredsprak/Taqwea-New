$(document).on("click", "#checkoutBtn", function(e) {
    e.preventDefault();
    var btn = $("#checkoutBtn");
    var btnName = btn.html();
    var form = $("#checkout-form");
    if (form.valid()) {
        var paymentMethod = $('input[name="payment_method"]:checked').val();
        var card_type = $('#select_card').val();
        if (paymentMethod == 'wallet' && walletAmount < totalAmount) {
            errorToaster('Insufficient balance in your wallet.');
            return false;
        }

        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL + '/checkout',
            type: "POST",
            // data: { 'payment_method': paymentMethod, 'item_id': itemId, 'item_type': itemType},
            data: form.serialize(),
            success: function(response) {
                
                if (typeof response.data == 'string') {
                    window.location.href = process.env.MIX_APP_URL + '/checkout/pay-now/'+response.data+'?item='+itemType+'&card_type='+card_type;
                } else {
                    showButtonLoader(btn, btnName, 'enable');
                    $("#transactionId").html(response.data.external_id);
                    if (itemType != 'class') {
                        $(".commonModal").addClass('commonModal--successMsg--bg');
                    }
                    $('#successModal').modal('show');
                
                    btn.prop('disabled', true);
                }
                
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
});

$("input[name='payment_method']").change(function() {
    var paymentMethod = $('input[name="payment_method"]:checked').val();
    if (paymentMethod == 'new_card') {
        $('#new-card-form').show();
    } else {
        $('#new-card-form').hide();
    }
});

window.getCardList = function getCardList(url = '') {
    if (url == '') {
        url = cardLitUrl;
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $("#show-cards").html(response.data);
        },
        error: function(data) {
            handleError(data);
        },
    });
};
getCardList();

if (walletAmount < totalAmount) {
    $('#customRadio2').prop('checked', false);
    $('#customRadio2').prop('disabled', true);
    $('#customRadio1').prop('checked', true);
}

if (totalAmount == 0) {
    $('#customRadio1').prop('checked', false);
    $('#customRadio1').prop('disabled', true);
    $('#customRadio2').prop('checked', true);
}


$(document).ready(function(){
    $("#select_card").select2({  
    templateResult: formatState
    });
}); 

function formatState (state) {
    if (!state.id) { return state.text; }
    var $state = $(
      `

      <div style="display: flex; align-items: center; justify-content: space-between; width:100%"> 
            <div>
                ${state.text} 
            </div>
        <div>
        <img sytle="display: inline-block;" src="${icons[state.text]}" style="height: 30px;width: atuto;" />
        </div>
      </div>
      `
    );
    return $state;
   }
