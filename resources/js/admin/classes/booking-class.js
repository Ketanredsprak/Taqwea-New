$(function() {
    var classBookingTable = $('#student-booking-datatable');
    var classId = $('#classId').val();

    NioApp.DataTable('#student-booking-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {
            url: process.env.MIX_APP_URL + '/admin/booking/class/list/' + classId,
            type: 'GET',
            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(classBookingTable.DataTable().page.info().page) + 1;
                d.search = classBookingTable.DataTable().search();
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            },
            error: function(xhr, error, code) {
                handleError(xhr);
            }
        },
        'createdRow': function(row, data) {
            $(".rateStar", row).each(function(index) {
                var rating = $(this).attr("data-rating");
                $(this).rateYo({
                    normalFill: "#E1E1E1",
                    ratedFill: "#FFC100",
                    rating: rating,
                    readOnly: true,
                    spacing: "2px"
                });
            });
        },
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                'name': 'id',
                "targets": 'id'
            },
            {
                "data": 'student_name',
                'name': 'student_name',
                "targets": 'student_name',
                "render": function(data, type, full, meta) {
                    return '<a href="javascript:void(0);">' +
                        '<div class="user-card">' +
                        '<div class="user-avatar">' +
                        '<img src="' + full.student.profile_image_url + '" alt="">' +
                        '</div>' +
                        '<div class="user-info">' +
                        '<span class="tb-lead">' + full.student.name + '</span>' +
                        '<span class="d-block">' + full.student.email + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</a>';
                }
            },
            {
                "data": 'transaction_items',
                'name': 'amount',
                "targets": 'amount_paid',
                'defaultContent': '--',
                "render": function(data, type, full, meta) {
                    return data.total_amount;
                }
            },
            {
                "data": 'booking_date',
                "name": "booking_date",
                "targets": 'booking_date',
                "render": function(data, type, full, meta) {
                    return moment.utc(data).local().format('MM/DD/YYYY LT')
                }
            },

            {
                'data': 'student',
                'targets': 'review',
                "render": function(data, type, full, meta) {
                    var n = '<div class="userInfo__rating"><div class="rateStar w-auto" data-rating="' + full.student.rating + '"></div></div>';
                    return n;

                }
            },
            {
                "data": 'status',
                "targets": 'status',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    return '<span>' + data + '</span>';
                }
            },
            {
                'data': 'id',
                'targets': 'actions',
                'orderable': false,
                'render': function(data, type, full, meta) {

                    if (full.class.class_type == 'class') {
                        var actions = ' <li><a href=' + process.env.MIX_APP_URL + '/admin/students ><span>View Student Detail</span></></li><li><a href = ' + process.env.MIX_APP_URL + '/admin/bookings/classes ><span> View Booking Detail </span></a></li>\n';
                    } else {
                        var actions = '<li><a href=' + process.env.MIX_APP_URL + ' /admin/students><span>View Student Detail</span></></li><li><a href =' + process.env.MIX_APP_URL + '/admin/bookings/webinars ><span> View Booking Detail </span></a></li>\n';
                    }

                    var n = '<ul class="nk-tb-actions gx-1 justify-content-center">\n' +
                        '  <li>\n' +
                        '  <div class="dropdown">\n' +
                        '  <a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '  <div class="dropdown-menu dropdown-menu-right">\n' +
                        '  <ul class="link-list-opt no-bdr">\n' +
                        actions +
                        '  </ul>\n' +
                        '  </div>\n' +
                        '  </div>\n' +
                        '  </li>\n' +
                        '  </ul> ';
                    return n;
                }
            },
        ]
    });
});