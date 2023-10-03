window.updateStatus = function (tutorId) {
    var status = $("#tutor-status").is(':checked') ? 'active' : 'inactive';
    var url = process.env.MIX_APP_URL + '/admin/changeStatus/';
    Swal.fire({
        title: 'Are you sure',
        text: "you want to change status?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "PUT",
                url: url,
                data: { _token: $('meta[name="csrf-token"]').attr('content'), id: tutorId, 'status': status },
                success: function (data) {
                    successToaster(data.message, { timeOut: 2000 });
                },
                error: function (err) {
                    handleError(err);
                }
            });
        } else {
            if (result.isDismissed) {
                if ($("#tutor-status").is(':checked')) {
                    $("#tutor-status").prop("checked", false);
                } else {
                    $("#tutor-status").prop("checked", true);
                }
            }

        }
    })
};

$(function () {
    $(".viewDoc").on("click", function () {
        var imgSrc = $(this).data('link');
        let certificate = $(this).data('certificate');
        var str = 'No document found';
        if (certificate == '') {
            $('#degreeView p').text(str);
            $('#btn').addClass('display:none');
            $('#degreeView img').hide();
        } else {
            $('#degreeView img').attr('src', imgSrc);
            $('#degreeView p').text('');
            $('#degreeView img').show();
        }
    });


    window.downloadEducationCertification = function (id) {
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/tutor/download-education-document/' + id,
            type: "GET",
            success: function (response) {
                var a = document.createElement('a');
                var url = response.data.certificate_url;
                a.href = url;
                a.download = response.data.certificate;
                document.body.append(a);
                a.click();
                a.remove();
            }
        });
    }

    window.downloadExperienceCertification = function (id) {
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/tutor/download-experience-document/' + id,
            type: "GET",
            success: function (response) {
                var a = document.createElement('a');
                var url = response.data.certificate_url;
                a.href = url;
                a.download = response.data.certificate;
                document.body.append(a);
                a.click();
                a.remove();
            }
        });
    }

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        views: {
            timeGridWeek: {
                type: 'timeGridWeek',
                displayEventTime: true,

            },
            timeGridDay: {
                type: 'timeGridDay',
                displayEventTime: true,

            },
            dayGridMonth: {
                type: 'dayGridMonth',
                displayEventTime: false,

            }
        },
        eventClick: function (event) {
            let gridView = event.view.type;
            var start_date = moment(event.event.start).format('YYYY-MM-DD LT');
            if (gridView == 'dayGridMonth') {
                start_date = moment(event.event.start).format('YYYY-MM-DD');
            }

            $.ajax({
                url: process.env.MIX_APP_URL + '/admin/tutor/' + tutorId + '/schedule-list',
                method: "GET",
                data: {
                    start_time: start_date,
                    gridView: gridView
                },
                success: function (response) {
                    console.log(response);
                    $('#eventDetails').html(response);
                    $('#eventDetails').modal('show');
                }
            });

        },
        events: process.env.MIX_APP_URL + '/admin/tutors/' + tutorId + '/schedules',

    });
    calendar.render();
    var xhr;
    $('.fc-button-group').on('click', function () {
        calendar.getEventSources().forEach(function (item) {
            item.remove();
        });
        var gridView = $('.fc-button-active').text();
        if (xhr && xhr.readyState != 4) {
            xhr.abort();
        }

        xhr = $.ajax({
            url: process.env.MIX_APP_URL + '/admin/tutors/' + tutorId + '/schedules',
            method: "GET",
            data: {
                gridView: gridView
            },
            success: function (response) {
                calendar.addEventSource(response);
                calendar.render('rerenderEvents');
            }
        });
    });

});

window.updateBlogStatus = function (obj, blogId) {
    var isChecked = $(obj).prop("checked");
    var status = isChecked ? 'active' : 'inactive';
    var url = process.env.MIX_APP_URL + '/admin/blogs/' + blogId;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light ripple-effect-dark'
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You want to inactive this blog!",
        showCancelButton: true,
        confirmButtonText: 'Yes, Inactive it!',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "PUT",
                data: { _token: $('meta[name="csrf-token"]').attr('content'), status: status },
                url: url,
                success: function (data) {
                    successToaster('Status updated successfully!');
                },
                error: function (err) {
                    handleError(err);
                }
            });
        } else {
            if (isChecked) {
                $(obj).prop("checked", false);
            } else {
                $(obj).prop("checked", true);
            }
        }
    });

}