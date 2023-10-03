$(function() {
    var tutorReportDatatable = $('#tutor-report-datatable');
    NioApp.DataTable('#tutor-report-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/report/list",
            type: "get",

            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(tutorReportDatatable.DataTable().page.info().page) + 1;
                d.search = tutorReportDatatable.DataTable().search();
                d.user_type = 'tutor';
                d.report = true;
                d.subscription = 'subscription';
                d.from_date = $('#from_date').val() ? moment($('#from_date').val()).format('YYYY-MM-DD') : '';
                d.to_date = $('#to_date').val() ? moment($('#to_date').val()).format('YYYY-MM-DD') : '';
                d.type_of_subscription = $('#type_of_subscription').val() ? $('#type_of_subscription').val() : '';
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {},
        'order': [0, 'desc'],
        "columnDefs": [{
                "data": 'id',
                'name': 'id',
                "targets": 'id',
                "render": function(data, type, row, meta) {
                    return type == 'export' ? meta.row + 1 : data;
                }
            },
            {
                "data": 'name',
                'name': 'name',
                "targets": 'name',
                "render": function(data, type, full, meta) {
                    return '<a href="#" class="showUserModal" data-toggle="modal">\n' +
                        '<div class="user-card">\n' +
                        '<div class="user-avatar user-avatar-sm bg-warning">\n' +
                        '<img src="' + full.profile_image_url + '" alt="avatar">\n' +
                        ' </div>\n' +
                        '  <div class="user-name">\n' +
                        ' <p class="tb-lead fw-medium mb-0">' + data + '</p>\n' +
                        '  <small class="text-gray">' + full.email + '</small>\n' +
                        ' </div>\n' +
                        ' </div>\n' +
                        '</a>';
                }
            },
            {
                'data': 'gender',
                "name": 'gender',
                'targets': 'gender',
                'defaultContent': '--',
                "render": function(data, type, full, meta) {
                    if (data) {
                        return data.charAt(0).toUpperCase() + data.slice(1);
                    }
                }
            },
            {
                'data': 'phone_number',
                'name': 'phone_number',
                'targets': 'phone_number',
                'defaultContent': '--',
            },
            {
                'data': 'email',
                'name': 'email',
                'targets': 'email',
                'defaultContent': '--',
            },
            {
                'data': 'rating',
                'targets': 'rating',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    data = Math.round(data-0.1);
                    var n = '<div class="ratingstarIcons">';
                    for (var i = 1; i <= 5; i++) {
                        if (i <= data) {
                            n += ' <em class="ni ni-star-fill"></em>';
                        } else {
                            n += '<em class="ni ni-star"></em>';
                        }
                    }
                    n += '</div>';
                    return n;
                }
            },
            {
                "data": 'approval_status',
                'targets': 'verify_status',
                'orderable': false,
                'render': function(data, type, full, meta) {
                    if (!full.is_profile_completed) {
                        var statusClass = 'badge-secondary';
                        var verifyStatus = 'Profile Incomplete'
                        return '<span class="badge badge-sm badge-dot has-bg ' + statusClass + ' d-mb-inline-flex">' + verifyStatus + '</span>';
                    }
                    var statusClass = 'badge-warning';
                    var verifyStatus = 'Pending'
                    if (data == 'approved') {
                        statusClass = 'badge-success';
                        verifyStatus = 'Approved';
                    } else if (data == 'rejected') {
                        statusClass = 'badge-danger';
                        verifyStatus = 'Rejected';
                    }
                    return '<span class="badge badge-sm badge-dot has-bg ' + statusClass + ' d-mb-inline-flex">' + verifyStatus + '</span>'
                }

            },
            {
                "data": 'payment_earning',
                'name': 'overall_revenue',
                'orderable': false,
                "targets": 'overall_revenue',
                "render": function(data, type, full, meta) {
                    return data.total_earning;
                }

            },
            {
                "data": 'walletBalance',
                'name': 'wallet',
                'orderable': false,
                "targets": 'wallet'
            },
            {
                "data": 'amount',
                'name': 'amount',
                "targets": 'amount',
                "render": function(data, type, full, meta) {
                    return data;
                }

            },
            {
                "data": 'availablePoint',
                'name': 'points',
                'orderable': false,
                "targets": 'points'


            },
            {
                "data": 'payment_earning',
                'name': 'current_due_amount',
                'orderable': false,
                "targets": 'current_due_amount',
                "render": function(data, type, full, meta) {
                    return data.total_due;
                }

            },
            {
                "data": 'created_at',
                'name': 'created_at',
                "targets": 'date',
                "render": function(data, type, full, meta) {
                    return moment(data).format('MM/DD/YYYY');
                }

            },
            {
                'data': 'tutor_subscription.subscription.subscription_name',
                'name': 'type_subscription',
                'targets': 'type_of_subscription',
            }

        ]
    });
    $('#tutor-report-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        tutorReportDatatable.DataTable().draw(true);
    });
    window.reset = function() {
        $('.dot').removeClass('dot-success');
        $('.form-select').val('').trigger('change');
        $('#to_date').val('');
        $('#from_date').val('');
        $('#type_of_subscription').val('');
        clearDatepicker();
        tutorReportDatatable.DataTable().draw(true);
    }
});
