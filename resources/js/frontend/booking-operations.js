$(function() {
    $('.join-now').on('click', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let startTime = moment.utc($(this).data('start-time')).local().format('YYYY-MM-DD HH:mm:ss');
        let currentTime = moment.utc().local().format('YYYY-MM-DD HH:mm:ss');
        if (startTime > currentTime) {
            errorToaster(Lang.get('error.class_start_time_is_of_future'));
            return false;
        }

        window.location.href = url;
    });

    setInterval(function() {
        $(".join-now").each(function(index) {
            let url = $(this).attr('href');
            let startTime = moment.utc($(this).data('start-time')).local().format('YYYY-MM-DD HH:mm:ss');
            let currentTime = moment.utc().local().format('YYYY-MM-DD HH:mm:ss');
            if (startTime <= currentTime) {
                $(this).removeClass('disabled');
                $('.cancel-btn-disabled').addClass('disabled');
                $('.cancel-btn-disabled').removeAttr('onclick');
            }
        });

        $(".add-to-cart").each(function(index) {
            let url = $(this).attr('href');
            let startTime = moment.utc($(this).data('start-time')).local().format('YYYY-MM-DD HH:mm:ss');
            let currentTime = moment.utc().local().format('YYYY-MM-DD HH:mm:ss');
            if (startTime <= currentTime) {
                $(this).removeAttr('onclick');
                $('.booking-disabled').attr('disabled', true);
                $(this).addClass('disabled');

            } else {
                $(this).removeClass('disabled');
            }
        });
    }, 500)
});

window.cancelBooking = function cancelBooking(obj, id, redirect = false) {
    var url = process.env.MIX_APP_URL + '/student/cancel-booking/' + id;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light ripple-effect-dark'
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: Lang.get('labels.are_you_sure'),
        text: Lang.get("labels.you_want_to_cancel_this_booking"),
        showCancelButton: true,
        confirmButtonText: Lang.get('labels.yes_cancel_it'),
        cancelButtonText: Lang.get('labels.cancel'),
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "get",
                url: url,
                success: function(data) {
                    successToaster(data.message);
                    setTimeout(() => {
                        if (redirect) {
                            classList();
                        } else {
                            window.location.reload();
                        }
                    }, 1000);
                },
                error: function(err) {
                    handleError(err);
                }
            });
        }
    });
};