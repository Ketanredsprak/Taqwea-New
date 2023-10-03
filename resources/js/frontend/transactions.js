window.transactionList = function transactionList(url = '') {
    var type = $('.transactionType').parent().parent().find('.active').attr('data-type');
    if (url == '') {
        if(type == 'transaction') {
            url = transactionLitUrl;
        } else {
            url = payoutLitUrl;
        }
        
    }
    showPageLoader("transactionList");
    showPageLoader("payoutList");
    $.ajax({
        url: url,
        data: {type:type},
        type: "GET",
        success: function(response) {
            if(type == 'transaction') {
                $("#transactionList").html(response.data);
            } else {
                $("#payoutList").html(response.data);
            }
           
        },
        error: function(data) {
            handleError(data);
        },
    });
};
transactionList();

$(document).on('click', '.transactionType', function() {
    transactionList();
});