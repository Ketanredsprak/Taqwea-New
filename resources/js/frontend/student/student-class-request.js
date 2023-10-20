
window.Cancelrequest = function Cancelrequest(id) {
    swal.fire({
           title: 'Are you sure you want to Cancel this request..?',
           icon: 'success',
           showCancelButton: true,
           confirmButtonText: 'Confirm'
       }).then((result) => {
           if (result.value) {
               $.ajax({
                   url: process.env.MIX_APP_URL + '/student/cancelrequest/' + id,
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