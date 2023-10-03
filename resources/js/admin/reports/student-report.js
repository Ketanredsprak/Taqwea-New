$(function() {
    var userDatatable = $('#student-report-datatable');
    NioApp.DataTable('#student-report-datatable', {
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
                d.page = parseInt(userDatatable.DataTable().page.info().page) + 1;
                d.search = userDatatable.DataTable().search();
                d.user_type = 'student';
                d.from_date = $('#from_date').val() ? moment($('#from_date').val()).format('YYYY-MM-DD') : '';
                d.to_date = $('#to_date').val() ? moment($('#to_date').val()).format('YYYY-MM-DD') : '';
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
                "data": 'created_at',
                'name': 'created_at',
                "targets": 'date',
                "render": function(data, type, full, meta) {
                    return moment(data).format('MM/DD/YYYY');
                }

            },
            {
                'data': 'total_booking_classes',
                'name': 'total_booking_classes',
                'targets': 'class_opted',
                'orderable': false,
                'defaultContent': '--',
            }

        ]
    });
    $('#student-report-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        userDatatable.DataTable().draw(true);
    });
    window.reset = function() {
        $('.dot').removeClass('dot-success');
        $('.form-select').val('').trigger('change');
        $('#to_date').val('');
        $('#from_date').val('');
        clearDatepicker();
        userDatatable.DataTable().draw(true);
    }
});
