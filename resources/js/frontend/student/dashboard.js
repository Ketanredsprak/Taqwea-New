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

// rateStar
$( ".rateStar" ).each(function( index ) {
    var rating = $( this ).attr("data-rating");
    $(this).rateYo({
            normalFill: "#E1E1E1",
            ratedFill: "#FFC100",
            rating: rating,
            readOnly: true,
            spacing: "2px"
        });
});