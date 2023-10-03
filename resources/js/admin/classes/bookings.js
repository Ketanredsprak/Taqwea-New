$(function() {
    var bookingsTable = $('#bookings-table');

    function changeStatus(id, status) {
        var url = process.env.MIX_APP_URL + '/admin/classes/' + id;
        $.ajax({
            type: "PUT",
            data: { _token: $('meta[name="csrf-token"]').attr('content'), status: status },
            url: url,
            success: function(data) {
                successToaster('Status updated successfully!');
            },
            error: function(err) {
                handleError(err);
            }
        });
    }

    NioApp.DataTable('#bookings-table', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + '/admin/bookings/list',
            type: 'GET',
            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(bookingsTable.DataTable().page.info().page) + 1;
                d.search = bookingsTable.DataTable().search();
                d.booking_status = $('#status').val();
                d.start_time = $('#start_time').val() ? moment.utc($('#start_time').val()).format('YYYY-MM-DD') : '';
                d.end_time = $('#end_time').val() ? moment.utc($('#end_time').val()).format('YYYY-MM-DD') : '';
                d.booking_start_time = $('#booking_start_time').val() ? moment.utc($('#booking_start_time').val()).format('YYYY-MM-DD') : '';
                d.booking_end_time = $('#booking_end_time').val() ? moment.utc($('#booking_end_time').val()).format('YYYY-MM-DD') : '';
                d.class_type = $("#classType").val();
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
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                "name": "id",
                "targets": 'id'
            },
            {
                "data": 'student_name',
                "name": "student_name",
                "targets": 'student_name',
                "render": function(data, type, full, meta) {
                    return '<a href="' + process.env.MIX_APP_URL + '/admin/booking/classes/' + full.id + '">' +
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
                "data": 'class.class_name',
                "name": "class_name",
                "targets": 'class_name'
            },
            {
                "data": 'class.start_time',
                "name": "start_date",
                "targets": 'start_date',
                "render": function(data, type, full, meta) {
                    return moment.utc(data).local().format('MM/DD/YYYY LT')
                }
            },
            {
                "data": 'class.duration',
                "name": "class_duration",
                "targets": 'class_duration',
                "render": function(data, type, full, meta) {
                    return convertMinutes(data);
                }
            },
            {
                "data": 'transaction_items',
                "name": "amount_paid",
                "targets": 'amount_paid',
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
                "data": 'status',
                "name": "status",
                "targets": 'status',
                "render": function(data, type, full, meta) {
                    if (data == 'confirm') {
                        return 'Upcoming';
                    }
                    if (data == 'complete') {
                        return 'Completed';
                    }
                    if (data == 'cancel') {
                        return 'Cancelled';
                    }
                    if (data == 'pending') {
                        return 'Pending';
                    }
                }

            },
            {
                "data": 'id',
                "targets": 'actions',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    var n = '<ul class="nk-tb-actions gx-1 justify-content-center"\n' +
                        ' <li>\n' +
                        '  <div class="dropdown">\n' +
                        '  <a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '  <div class="dropdown-menu dropdown-menu-right ">\n' +
                        '  <ul class="link-list-opt no-bdr">\n' +
                        '<a href="' + process.env.MIX_APP_URL + '/admin/booking/classes/' + full.id + '"><em class="icon ni ni-eye"></em><span>View</span></a></a>\n' +
                        '</ul>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</li>\n' +
                        '</ul> ';
                    return n;
                }
            }
        ]
    });

    $('.reset-filter').on('click', function() {
        $('.dot').removeClass('dot-success');
        $('.form-select').val('').trigger('change');
        $('#start_time').val('');
        $('#end_time').val('');
        $('#booking_start_time').val('');
        $('#booking_end_time').val('');
        clearDatepicker();
        bookingsTable.DataTable().ajax.reload();
    });

    $('#class-filter').on('click', function() {
        $('.dot').addClass('dot-success');
        bookingsTable.DataTable().ajax.reload();
    });
});