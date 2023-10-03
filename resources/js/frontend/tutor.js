window.tutorList = function tutorList(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/tutors/list';
    }
    var filterLabel = [];
    var level = $('input[type="checkbox"][name="level[]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    level = level.join(',');

    var grade = $('input[type="checkbox"][name="grade\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    grade = grade.join(',');

    var subject = $('input[type="checkbox"][name="subject\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    subject = subject.join(',');

    var generalknowledge = $('input[type="checkbox"][name="generalknowledge\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    generalknowledge = generalknowledge.join(',');

    var language = $('input[type="checkbox"][name="language\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    language = language.join(',');

    var experience = '';
    if ($('input[name="experience"]:checked').val()) {
        experience = $('input[name="experience"]:checked').val();
        filterLabel.push($('input[name="experience"]:checked').parent().find('label').text());
    }

    addFilterLabel(filterLabel);

    $.ajax({
        url: url,
        type: "GET",
        data: {
            'grade': grade,
            'level': level,
            'subject': subject,
            'generalknowledge': generalknowledge,
            'language': language,
            'experience': experience
        },
        success: function (response) {
            $("#tutorList").html(response.data);
        },
        error: function (data) {
            handleError(data);
        },
    });
};


window.addFilterLabel = function addFilterLabel(lavels) {
    var html = '';
    for (let i = 0; i < lavels.length; i++) {
        html += `<li class="list-inline-item font-sm">
                    ` + lavels[i] + `<a href="javascript:void(0);" class="removeFilter" data-id="` + lavels[i] + `">×</a>
                </li>`;
    }
    $("#filterLabels").html(html);
};

window.clearAll = function clearAll() {
    $('#filterForm')[0].reset();
    $("#filterLabels").html('');
    tutorList();
};

$(document).on('click', '.removeFilter', function () {
    var id = $(this).attr('data-id').split(' ').join('___');
    if (id == "10+") {
        id = "10";
    }
    $(this).parent().remove();
    $("#" + id).prop('checked', false);
    tutorList();
});

if ($("html").attr('dir') == 'ltr') {
    $(window).on('load resize', function () {

        $('.listSlider').slick({
            dots: false,
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
                    dots: true
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

    });

} else {
    $(window).on('load resize', function () {
        $('.listSlider').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            rtl: true,
            responsive: [{
                breakpoint: 1279,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
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
    });
}
$(".rateStar").each(function (index) {
    var rating = $(this).attr("data-rating");
    $(this).rateYo({
        normalFill: "#E1E1E1",
        ratedFill: "#FFC100",
        rating: rating,
        readOnly: true,
        spacing: "2px"
    });
});
tutorList();