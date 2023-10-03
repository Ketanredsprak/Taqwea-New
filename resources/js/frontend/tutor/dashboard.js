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


$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $('.famousTeachersSlider').slick('setPosition');
})