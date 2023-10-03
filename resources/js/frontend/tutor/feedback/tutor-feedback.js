$(function() {
    $(".ratingStar").rateYo({
        normalFill: "#E1E1E1",
        ratedFill: "#FFC100",
        rating: 0.0,
        // readOnly: true,
        fullStar: true,
        numStars: 5,
        spacing: "10px"
    });
    $(".rateStar1").each(function(index) {
        console.log("hi");
        var rating = $(this).attr("data-rating");
        $(this).rateYo({
            normalFill: "#E1E1E1",
            ratedFill: "#FFC100",
            rating: rating,
            readOnly: true,
            spacing: "2px"
        });
    });
});
$('#ratingSubmit').on('click', function(e) {
    e.preventDefault();
    var rating = $(".ratingStar").rateYo("rating");
    var review = $('#review').val();
    var id = $('#student_id').val();
    var class_id = $('#class_id').val();
    var btn = $('#ratingSubmit');
    var frm = $('#feedback-frm');
    var btnName = btn.html();
    if (frm.valid()) {
        showButtonLoader(btn, btnName, 'disabled');
        $.ajax({
            url: process.env.MIX_APP_URL +'/tutor/feedback/store',
            type: "POST",
            data: {
                "to_id": id,
                "review": review,
                "rating": rating,
                "class_id": class_id
            },
            success: function(response) {
                successToaster(response.message, 'Feedback');
                setTimeout(function() {
                    window.location.href = process.env.MIX_APP_URL +'/tutor/feedback/' + class_id;
                }, 2000);
            },
            error: function(data) {
                handleError(data);
            },
        });
    }
})