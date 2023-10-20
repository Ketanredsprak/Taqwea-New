window.tutorClassRequestList = function tutorClassRequestList(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/tutor/classrequest/list';  
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            $("#tutorClassRequestList").html(response.data);
        },
        error: function (data) {
            handleError(data);
        },
    });
};
tutorClassRequestList();
