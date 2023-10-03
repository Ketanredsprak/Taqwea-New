window.classList = function classList(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/student/classes/list';
    }
    var type = $('.nav-link').parent().parent().find('.active').attr('data-type');
    $.ajax({
        url: url,
        data: { 'class_type': $('#classType').val(), 'type': type },
        type: "GET",
        async: false,
        success: function (response) {
            if(type=='upcoming'){
                $("#upcomingClasses").html(response.data);
            }else{
                $("#pastClasses").html(response.data);
            }
        },
        error: function (data) {
            handleError(data);
        },
    });
};

classList();

$(document).on('click', '.classListType', function () {
    classList();
});

$(document).on('click', '#pagination a', function (e) {
    e.preventDefault();
    console.log("hi");
    var url = $(this).attr('href');
    classList(url);
});


