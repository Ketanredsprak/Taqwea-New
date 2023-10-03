
window.addToCart = function addToCart(btn, itemId, itemType, qty = 1) {
    var showLoader = 'Processing...';
    var btnName = btn.html();
    showButtonLoader(btn, showLoader, 'disabled');
   
    let url = process.env.MIX_APP_URL + '/student/carts';

    $.ajax({
        url: url,
        type: "POST",
        data: { 'item_id': itemId, 'item_type': itemType, 'qty': qty },
        success: function(response) {
            showButtonLoader(btn, btnName, 'enable');
            btn.prop('disabled', true);
            $('.booking-disabled').attr('disabled', true);
            var existingCount = $('.badge-info').text();
            var count = 0;
            if (existingCount) {
                count = parseInt(existingCount);
            }
            count++;
            $('.badge-info').text(count)
            successToaster(response.message);
        },
        error: function(data) {
            handleError(data);
            showButtonLoader(btn, btnName, 'enable');
        },
    });
}

window.deleteItem = function deleteItem(cartId, itemId) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light ripple-effect-dark'
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: Lang.get('labels.are_you_sure'),
        text: Lang.get("labels.you_want_to_delete_this_item"),
        showCancelButton: true,
        confirmButtonText: Lang.get('labels.yes_delete_it'),
        cancelButtonText: Lang.get('labels.cancel'),
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "DELETE",
                url: process.env.MIX_APP_URL + '/student/carts/' + cartId + '/' + itemId,
                //data: { },
                success: function(response) {
                    successToaster(response.message);
                    $("#item-" + itemId).remove();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(response) {
                    handleError(response);
                },
            });
        }
    });
};