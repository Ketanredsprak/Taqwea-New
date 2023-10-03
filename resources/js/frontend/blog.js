window.blogList = function blogList(url = '') {
    showPageLoader("blogList");
    if (url == '') {
        url = process.env.MIX_APP_URL + '/blogs/list';
    }
    var price = '';
    var filterLabel = [];
    if ($('input[name="price"]:checked').val()){
        price = $('input[name="price"]:checked').val();
        var text = $('input[name="price"]:checked').attr('id');
        console.log(text);
        filterLabel.push(text.split('___').join(' '));
    }

    var category = $('input[type="checkbox"][name="category\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    category = category.join(',');

    var grade = $('input[type="checkbox"][name="grade\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    grade = grade.join(',');

    var level = $('input[type="checkbox"][name="level\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    level = level.join(',');

    var subject = $('input[type="checkbox"][name="subject\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    subject = subject.join(',');

    var gk_level = $('input[type="checkbox"][name="gk_level\\[\\]"]:checked').map(function () {
        var text = this.id;
        filterLabel.push(text.split('___').join(' '));
        return this.value;
    }).get();
    gk_level = gk_level.join(',');

    var language_level = $('input[type="checkbox"][name="language_level\\[\\]"]:checked').map(function () {
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
            'price': price, 
            'category': category, 
            'grade': grade, 
            'level': level, 
            'subject': subject,
            'gk_level': gk_level,
            'language_level': language_level,
            'tutor_id': tutor_id,
        },
        success: function (response) {
            $("#blogList").html(response.data);
        },
        error: function (response) {
            handleError(response);
        },
    });
};
$(document).ready(function () {
    blogList();
});

window.addFilterLabel = function addFilterLabel(lavels) {
    var html = '';
    for (let i = 0; i < lavels.length; i++) {
        html += `<li class="list-inline-item font-sm">
                    `+ lavels[i] + `<a href="javascript:void(0);" class="removeFilter" data-id="` + lavels[i] + `">×</a>
                </li>`;
    }
    $("#filterLabels").html(html);
};

window.clearAll = function clearAll() {
    $('#filterForm')[0].reset();
    $("#filterLabels").html('');
    blogList();
};

$(document).on('click', '.removeFilter', function () {
    var id = $(this).attr('data-id').split(' ').join('___');
    $(this).parent().remove();
    $("#" + id).prop('checked', false);
    blogList();
});