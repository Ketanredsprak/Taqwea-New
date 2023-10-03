$(".rateStar").each(function(index) {
    var rating = $(this).attr("data-rating");
    console.log(rating);
    $(this).rateYo({
        normalFill: "#808080",
        ratedFill: "#FFC100",
        rating: rating,
        readOnly: true,
        spacing: "2px"
    });
});