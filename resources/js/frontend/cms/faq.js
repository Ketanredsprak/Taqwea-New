
window.faqList = function faqList(url='') {
    if(url==''){
        url = process.env.MIX_APP_URL + '/faq/list';
    }
    $.ajax({
        method: "GET",
        url: url,
        success: function (response) {
            $("#faqs").html(response.data);
        },
        error: function (response) {
            handleError(response);
        },
    });
};

faqList();