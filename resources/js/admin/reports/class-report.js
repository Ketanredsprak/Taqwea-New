$(function() {
    var classTable = $('#class-report-datatable');
    NioApp.DataTable('#class-report-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/class-report/list",
            type: "get",

            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(classTable.DataTable().page.info().page) + 1;
                d.search = classTable.DataTable().search();
                d.class_type = 'class';
                d.status = $('#status').val();
                d.start_time = $('#from_date').val() ? moment($('#from_date').val()).format('YYYY-MM-DD') : '';
                d.end_time = $('#to_date').val() ? moment($('#to_date').val()).format('YYYY-MM-DD') : '';
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {
            $('.showEmailMsg', row).on('click', function() {

                $('#readMoreModal .modal-body p').html(data.class_description);
                $('#readMoreModal').modal('show');

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
                "data": 'name',
                "name": 'tutor_name',
                "targets": 'tutor_name',
                "render": function(data, type, full, meta) {
                    return '<a href="#" class="showUserModal" data-toggle="modal">\n' +
                        '<div class="user-card">\n' +
                        '<div class="user-avatar user-avatar-sm bg-warning">\n' +
                        '<img src="' + full.class_image_url + '" alt="avatar">\n' +
                        ' </div>\n' +
                        '  <div class="user-name">\n' +
                        ' <p class="tb-lead fw-medium mb-0">' + full.tutor.name + '</p>\n' +
                        '  <small class="text-gray">' + full.tutor.email + '</small>\n' +
                        ' </div>\n' +
                        ' </div>\n' +
                        '</a>';
                }
            },
            {
                "data": 'class_type',
                'name': 'class_type',
                "targets": 'class_type',

            },
            {
                'data': 'class_detail',
                'name': 'class_detail',
                'targets': 'class_detail',
                'defaultContent': '--',
            },
            {
                'data': 'class_description',
                'name': 'class_description',
                'targets': 'class_description',
                'defaultContent': '--',
                "render": function(data, type, full, meta) {
                    var text = full.class_description;
                    var limit = 50;
                    var string = text.substring(0, limit);
                    if (text.length > limit) {
                        string = string + ' <a href = "javascript:void(0);" class="showEmailMsg" >Read More </a>';
                    } else {
                        string = '<span>' + string + '</span>';
                    }
                    return string;
                }
            },
            {
                'data': 'student_count',
                'name': 'student_count',
                'targets': 'class_capacity',
                'defaultContent': '--',
                'orderable': false,
                'render': function(data, type, full, meta) {
                    return data + '/' + full.no_of_attendee;
                }
            }

        ]
    });
    $('#class-report-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        classTable.DataTable().draw(true);
    });
    window.reset = function() {
        $('.dot').removeClass('dot-success')
        $('.form-select').val('').trigger('change');
        $('#to_date').val('');
        $('#from_date').val('');
        $('#status').val('');
        clearDatepicker();
        classTable.DataTable().draw(true);
    }
});