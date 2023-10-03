window.classList = function classList(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/tutor/classes/list';
    }
    var type = $('.classListType').parent().parent().find('.active').attr('data-type');
    $.ajax({
        url: url,
        data: { 'class_type': $('#classType').val(), 'type': type },
        type: "GET",
        async: false,
        success: function(response) {
            if (type == 'upcoming') {
                $("#upcomingClasses").html(response.data);
            } else {
                $("#pastClasses").html(response.data);
            }
        },
        error: function(data) {
            handleError(data);
        },
    });
};

$(document).on('click', '.classListType', function() {
    classList();
});

window.publishClass = function publishClass(obj, id, type = 'class') {
    console.log(Lang.get("labels.you_want_to_publish_this"));
    var url = process.env.MIX_APP_URL + '/tutor/classes/' + id + '/publish';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light ripple-effect-dark'
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: Lang.get("labels.are_you_sure"),
        text: Lang.get("labels.you_want_to_publish_this") + ' ' + (type == 'class' ? Lang.get("labels.class") : Lang.get("labels.webinar")),
        showCancelButton: true,
        confirmButtonText: Lang.get("labels.yes_publish_it"),
        cancelButtonText: Lang.get("labels.cancel"),
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "PATCH",
                url: url,
                success: function(data) {
                    successToaster(data.message);
                    // obj.html('Published');
                    obj.css('pointer-events', 'none');
                    setTimeout(() => {
                        if (type == 'webinar') {
                            window.location.href = process.env.MIX_APP_URL + '/tutor/webinars';
                        } else {
                            window.location.href = process.env.MIX_APP_URL + '/tutor/classes';
                        }
                    }, 1000);
                },
                error: function(err) {
                    handleError(err);
                }
            });
        }
    });
};

window.cancelClass = function cancelClass(obj, id, type, redirect = false) {
    var url = process.env.MIX_APP_URL + '/tutor/cancel-class/' + id;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light ripple-effect-dark'
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: Lang.get("labels.are_you_sure"),
        text: Lang.get("labels.you_want_to_cancel_this") ,
        showCancelButton: true,
        confirmButtonText: Lang.get("labels.yes_cancel_it"),
        cancelButtonText: Lang.get("labels.cancel"),
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "get",
                url: url,
                success: function(data) {
                    successToaster(data.message);
                    if (redirect) {
                        setTimeout(() => {
                            classList();
                        }, 1000);
                    } else {
                        window.location.href = process.env.MIX_APP_URL + '/tutor/classes';
                    }
                },
                error: function(err) {
                    handleError(err);
                }
            });
        }
    });
};

// show more text 
readMore();

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

if ($("html").attr('dir') == 'ltr') {
    $(window).on('load resize', function () {

        $('.listSlider').slick({
            infinite: false,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 6,
            responsive: [{
                breakpoint: 1399,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                    infinite: true
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
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

    });

} else {
    $(window).on('load resize', function () {
        $('.listSlider').slick({
            infinite: false,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 6,
            rtl: true,
            responsive: [{
                breakpoint: 1399,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                    infinite: true
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
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
    });
}

function setTooltip(message) {
    $('#copy').tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
}

function hideTooltip() {
    setTimeout(function() {
        $('#copy').tooltip('hide');
    }, 1000);
}

$(function(){
    $('#copy').tooltip({
        trigger: 'click',
        placement: 'bottom',
        animation: false
    });
    if ($("#copy").length) {
        var clipboard = new ClipboardJS('#copy', {
            container: document.getElementById('copy')
        });
        clipboard.on('success', function(e) {
            setTooltip(Lang.get("labels.copied"));
            hideTooltip();
        });
    }
})