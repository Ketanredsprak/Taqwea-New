$('#leaveFeedback').modal('show');

window.rasieDisputeModal = function rasieDisputeModal() {
    $('#rasieDisputeModal').modal('show');
    $('#leaveFeedback').modal('hide');
}

// rateStar
$(function() {
    $('#submit-button').on('click', function() {
        var class_id = $('#class_id').val();
        var btn = $('#submit-button');
        var frm = $('#raiseDispute-frm');
        var btnName = btn.html();
        if (frm.valid()) {
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: process.env.MIX_APP_URL + "/student/feedback/dispute-reason",
                type: "POST",
                data: frm.serialize(),
                success: function(response) {
                    showButtonLoader(btn, btnName, 'enable');
                    successToaster(response.message, 'Feedback');
                    window.location.href = process.env.MIX_APP_URL + "/student/feedback/" + class_id;
                },
                error: function(data) {
                    handleError(data);
                },
            });
        }

    });

    $('#submit-btn').on('click', function() {
        var tutor_id = $('#tutor_id').val();
        var class_id = $('#class_id').val();
        var clarity = $('#clarity_count').text();
        var orgnization = $('#organization_count').text();
        var give_homework = $('#giveHomework_count').text();
        var use_of_supporting_tools = $('#supportingTools_count').text();
        var on_time = $('#onTime_count').text();
        var review = $('#review').val();
        var total_rating = ((+clarity) + (+orgnization) + (+give_homework) + (+use_of_supporting_tools) + (+on_time)) / 5;
        var rating = Math.round(total_rating);
        var btn = $('#submit-btn');
        var frm = $('#feedback-frm');
        var btnName = btn.html();
        var url = $('#feedback-frm').attr('action');
        if (frm.valid()) {
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    "to_id": tutor_id,
                    "clarity": clarity,
                    "review": review,
                    "orgnization": orgnization,
                    "give_homework": give_homework,
                    "use_of_supporting_tools": use_of_supporting_tools,
                    "on_time": on_time,
                    "rating": rating,
                    "class_id": class_id
                },
                success: function(response) {
                    showButtonLoader(btn, btnName, 'enable');
                    successToaster(response.message, 'Feedback');
                    window.location.href = process.env.MIX_APP_URL + "/student/feedback/" + class_id;
                },
                error: function(data) {
                    handleError(data);
                },
            });
        }

    });

    $(".onTimeStar").rateYo({
        normalFill: "#E1E1E1",
        ratedFill: "#FFC100",
        rating: 0.0,
        // readOnly: true,
        fullStar: true,
        numStars: 5,
        spacing: "10px"
    });
    $(".supportingToolsStar").rateYo({
        normalFill: "#E1E1E1",
        ratedFill: "#FFC100",
        rating: 0.0,
        // readOnly: true,
        fullStar: true,
        numStars: 5,
        spacing: "10px"
    });
    $(".giveHomeworkStar").rateYo({
        normalFill: "#E1E1E1",
        ratedFill: "#FFC100",
        rating: 0.0,
        // readOnly: true,
        fullStar: true,
        numStars: 5,
        spacing: "10px"
    });
    $(".organizationStar").rateYo({
        normalFill: "#E1E1E1",
        ratedFill: "#FFC100",
        rating: 0.0,
        // readOnly: true,
        fullStar: true,
        numStars: 5,
        spacing: "10px"
    });
    $(".clarityStar").rateYo({
        normalFill: "#E1E1E1",
        ratedFill: "#FFC100",
        rating: 0.0,
        // readOnly: true,
        fullStar: true,
        numStars: 5,
        spacing: "10px"
    });

    $('.clarityStar').on('click', function() {
        var clarity_rating = $(".clarityStar").rateYo("rating");
        var value = clarity_rating * 20;

        $("#clarity_data").attr("data-value", value);
        $('#clarity_count').text(clarity_rating);
        progress();
        overAllRating();

    });
    $('.organizationStar').on('click', function() {
        var org_rating = $(".organizationStar").rateYo("rating");
        var value = org_rating * 20;

        $("#organization_data").attr("data-value", value);
        $('#organization_count').text(org_rating);
        progress();
        overAllRating();

    });
    $('.giveHomeworkStar').on('click', function() {
        var giveHomework_rating = $(".giveHomeworkStar").rateYo("rating");
        var value = giveHomework_rating * 20;

        $("#giveHomework_data").attr("data-value", value);
        $('#giveHomework_count').text(giveHomework_rating);
        progress();
        overAllRating();

    });
    $('.supportingToolsStar').on('click', function() {
        var support_rating = $(".supportingToolsStar").rateYo("rating");
        var value = support_rating * 20;

        $("#supportingTools_data").attr("data-value", value);
        $('#supportingTools_count').text(support_rating);
        progress();
        overAllRating();

    });
    $('.onTimeStar').on('click', function() {
        var onTime_rating = $(".onTimeStar").rateYo("rating");
        var value = onTime_rating * 20;

        $("#onTime_data").attr("data-value", value);
        $('#onTime_count').text(onTime_rating);
        progress();
        overAllRating();

    });

    window.overAllRating = function overAllRating() {
        var clarity = $('#clarity_count').text();
        var orgnization = $('#organization_count').text();
        var give_homework = $('#giveHomework_count').text();
        var use_of_supporting_tools = $('#supportingTools_count').text();
        var on_time = $('#onTime_count').text();
        var total_rating = ((+clarity) + (+orgnization) + (+give_homework) + (+use_of_supporting_tools) + (+on_time)) / 5;
        var rating = Math.round(total_rating);
        $('#over-all-rating').text(rating);
        var i = 1;
        $(".class-show-rating").each(function() {

            if (i <= rating) {
                $(this).addClass('cls-1');
                $(this).removeClass('cls-2');
            } else {
                $(this).removeClass('cls-1');
                $(this).addClass('cls-2');
            }
            i++;

        });
    }

});

function progress() {
    $(".progress").each(function() {

        var value = $(this).attr('data-value');
        var left = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');

        if (value > 0) {
            if (value <= 40) {
                right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                left.css('transform', 'rotate(0deg)')
            } else {
                right.css('transform', 'rotate(180deg)')
                left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
            }
        }

    })

}

function percentageToDegrees(percentage) {
    return percentage / 100 * 360
}

$(function() {
    progress();
    overAllRating();
});