$('.listSlider').slick({
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 4,
    responsive: [{
            breakpoint: 1279,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
            }
        },
        {
            breakpoint: 769,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 575,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

$('.famousTeachersSlider').slick({
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 4,
    responsive: [{
            breakpoint: 1279,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true
            }
        },
        {
            breakpoint: 769,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 575,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});



$('.scrollDown').click(function() {
    var body = $("html, body");
    body.stop().animate({ scrollTop: $('.inspiringSolutions').offset().top }, 500);
})

$('.scrollDownReview').click(function() {
    var body = $("html, body");
    var headerHeight = $('.header').height();
    body.stop().animate({
        scrollTop: $('.customerSection').offset().top - headerHeight
    }, 500);
})

// rateStar
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

var xhr;
window.classList = function classList(url = '', type = 'class') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/home/classes';
    }
    //var type = $('.nav-link').parent().find('.active').attr('data-type');
    if ($('.listSliderClass').hasClass('slick-initialized')) {
        $('.listSliderClass').slick('destroy');
        $(".listSliderClass").html('');

    }
    if(xhr && xhr.readyState != 4){
        xhr.abort();
    }
    xhr = $.ajax({
        url: url,
        data: { 'type': type },
        type: "GET",
        success: function(response) {
            $("#webinarNotFound").hide();
            $("#classNotFound").hide();
            if (type == 'class') {
                $("#class").html(response.data);

                if (!response.data) {
                    $("#classNotFound").show();
                }
            } else {
                $("#webinar").html(response.data);
                if (!response.data) {
                    $("#webinarNotFound").show();
                }
            }

            slider();
        },
        error: function(data) {
           // handleError(data);
        },
    });
};
$(function() {
    classList();
    readMore(50);
});
$(document).on('click', '.classListType', function() {
    let type = $(this).attr('data-type')
    classList('', type);
});

function slider() {
    $('.listSliderClass').slick({
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [{
                breakpoint: 1279,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
}

window.showReadMore = function showReadMore(data, name) {
    console.log(name);
    $('#readMoreModal .modal-body p').html(data);
    $('#readMoreModal .modal-header h5').html(name);
    $('#readMoreModal').modal('show');
}