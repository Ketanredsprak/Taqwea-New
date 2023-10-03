window.blogList = function blogList(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/student/blogs/list';
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            $("#blogList").html(response.data);
        },
        error: function (data) {
            handleError(data);
        },
    });
};
blogList();

