window.getSubscriptionList = function getSubscriptionList(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/tutor/subscription/purchase';
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $("#subscriptionList").html(response.data);
        },
        error: function(data) {
            handleError(data);
        },
    });
};
getSubscriptionList();

window.transactionDetailModal = function transactionDetailModal(id) {

    var url = process.env.MIX_APP_URL + '/tutor/subscription/purchase/details/' + id;

    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            console.log(response);
            $('#transactionDetailModal').html(response.data);
            $('#transactionDetailModal').modal('show');
        },
        error: function(data) {
            handleError(data);
        },
    });
}

window.getNewSubscriptionPlan = function getNewSubscriptionPlan(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/tutor/new-subscription-plan/list';
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $("#newPlanSubscription").html(response.data);
        },
        error: function(data) {
            handleError(data);
        },
    });
};
getNewSubscriptionPlan();

window.getTopUpList = function getTopUpList(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/tutor/top-up';
        console.log(url);
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            console.log(response.data);
            $("#topUpList").html(response.data);

        },
        error: function(data) {
            handleError(data);
        },
    });
};
getTopUpList();

/**
 * Purchase top up model load
 */
$(document).on('click', '.purchaseTopUp', function() {
    var url = process.env.MIX_APP_URL + '/tutor/top-up/purchase';
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $("#purchaseTopUpModel").html(response.data);
            $('#purchaseTopUpModel').modal('show');

        },
        error: function(data) {
            handleError(data);
        },
    });
});