window.classesList = function classesList(url = '') {
    showPageLoader("classList");
    if (url == '') {
        url = process.env.MIX_APP_URL + '/classes/list';
    }
    var price = '';
    var filterLabel = [];
    if ($('input[name="price"]:checked').val()) {
        price = $('input[name="price"]:checked').val();
        filterLabel.push($('input[name="price"]:checked').parent().find('label').text());
    }

    var gender = '';
    if ($('input[name="gender"]:checked').val()) {
        gender = $('input[name="gender"]:checked').val();
        filterLabel.push($('input[name="gender"]:checked').parent().find('label').text());
    }

    var levels = $('input[type="checkbox"][name="level\\[\\]"]:checked').map(function() {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    levels = levels.join(',');

    var grade = $('input[type="checkbox"][name="grade\\[\\]"]:checked').map(function() {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    grade = grade.join(',');

    var subject = $('input[type="checkbox"][name="subject\\[\\]"]:checked').map(function() {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    subject = subject.join(',');

    var gk_level = $('input[type="checkbox"][name="gk_level\\[\\]"]:checked').map(function() {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    gk_level = gk_level.join(',');

    var language_level = $('input[type="checkbox"][name="language_level\\[\\]"]:checked').map(function() {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    language_level = language_level.join(',');

    addFilterLabel(filterLabel);

    $.ajax({
        method: "GET",
        url: url,
        data: {
            'class_type': $('#classType').val(),
            'order_by_price': $("#priceFilter").val(),
            'price': price,
            'gender': gender,
            'grade': grade,
            'level': levels,
            'subject': subject,
            'gk_level': gk_level,
            'language_level': language_level,
        },
        async: false,
        success: function (response) {
            $("#classList").html(response.data);
        },
        error: function(response) {
            handleError(response);
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
    classesList();
};

$(document).on('click', '.removeFilter', function() {
    var id = $(this).attr('data-id').split(' ').join('___');
    $(this).parent().remove();
    $("#" + id).prop('checked', false);
    classesList();
});

$(function () {
    classesList();
    $(document).on('click', '#pagination a',function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        classesList(url);
    });
});

window.classList = function classList() {
    classesList();
};