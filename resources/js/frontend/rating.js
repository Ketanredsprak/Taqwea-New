// rateStar
let ratingStar = () => {
    $(".rateStar").each(function(index) {
        var rating = $(this).attr("data-rating");
        $(this).rateYo({
            normalFill: "#E1E1E1",
            ratedFill: "#FFC100",
            rating: rating,
            readOnly: true,
            spacing: "2px"
        });
    });
}

/**
 * Load list rating
 * 
 * @param sting url 
 */
window.ratingList = function(url = '') {
    if (url == '') {
        url = ratingUrl;
    }
    var type = $('.nav-link').parent().parent().find('.active').attr('data-type');
    $.ajax({
        url: url,
        data: { 'rating_type': type },
        type: "GET",
        success: function(response) {
            if (type == 'received') {
                $("#received").html(response.data);
            } else {
                $("#given").html(response.data);
            }
            ratingStar();
        },
        error: function(data) {
            handleError(data);
        },
    });
};
ratingList();
$(document).on('click', '.ratingListType', function() {
    ratingList();
});