window.RejectTutorRequest= function RejectTutorRequest(id,class_request_id) {
    $.ajax({
        url: process.env.MIX_APP_URL + '/student/rejectrequest/'+id,
        type: "GET",
        success: function (response) {
            successToaster(response.message);
            window.location.href = process.env.MIX_APP_URL + '/student/getrequest/'+class_request_id;
        },
        error: function (data) {
            handleError(data);
        },
    });
};