window.RejectTutorRequest = function RejectTutorRequest(id, class_request_id) {
    swal.fire({
        title: 'Are you sure you want to reject this request.. ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirm'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: process.env.MIX_APP_URL + '/student/rejectrequest/' + id,
                type: "GET",
                success: function (response) {
                    successToaster(response.message);
                    window.location.href = process.env.MIX_APP_URL + '/student/getrequest/' + class_request_id;
                },
                error: function (data) {
                    handleError(data);
                },
            });
        };
    });
}


window.Approverequest = function Approverequest(id, class_request_id) {
 swal.fire({
        title: 'Are you sure you want to Accept this request..?',
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Confirm'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: process.env.MIX_APP_URL + '/student/acceptrequest/' + id,
                type: "GET",
                success: function (response) {
                    successToaster(response.message);
                     window.location.href = process.env.MIX_APP_URL + '/student/classrequest/';
                },
                error: function (data) {
                    handleError(data);
                },
            });
        };
    });
}


window.backPage = function backPage() {
       swal.fire({
           title: 'Are you sure you want to back page..?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Confirm'
       }).then((result) => {
           if (result.value) {
                   window.location.href = process.env.MIX_APP_URL + '/student/classrequest/';
           }
       });
   }







