$(function() {
    var webinarTable = $('#webinar-table');

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

    NioApp.DataTable('#webinar-table', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + '/admin/classes/list',
            type: 'GET',
            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(webinarTable.DataTable().page.info().page) + 1;
                d.search = webinarTable.DataTable().search();
                d.class_type = 'webinar';
                d.search = webinarTable.DataTable().search();
                d.level = $('#level').val();
                d.grade = $('#grade').val();
                d.subject = $('#subject').val();
                d.status = $('#status').val();
                d.rating = $('#rating').val();
                d.start_time = $('#start_time').val() ? moment.utc($('#start_time').val()).format('YYYY-MM-DD') : '';
                d.end_time = $('#end_time').val() ? moment.utc($('#end_time').val()).format('YYYY-MM-DD') : '';
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
            $('.change-status', row).on('click', function() {
                var isChecked = $(this).prop("checked");
                var status = isChecked ? 'active' : 'inactive';
                if (!isChecked) {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary mr-2',
                            cancelButton: 'btn btn-light ripple-effect-dark'
                        },
                        buttonsStyling: false
                    });
                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "You want to inactive this webinar!",
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Inactive it!',
                    }).then((result) => {
                        if (result.value) {
                            changeStatus(data.id, status);
                        }
                    });
                } else {
                    changeStatus(data.id, status);
                }
            });

        },
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                "name": "id",
                "targets": 'id'
            },
            {
                "data": 'class_name',
                "name": "class_name",
                "targets": 'class_name'
            },
            {
                "data": 'category.name',
                "name": "category",
                "targets": 'category',
                "render": function(data, type, full, meta) {
                    if (full.grade) {
                        return full.category.name + '(' + full.grade.name + ')';
                    }
                    return full.category.name;
                }
            },
            {
                "data": 'subject.name',
                "name": "subject",
                "targets": 'subject',
                'defaultContent': '--',
            },
            {
                "data": 'duration',
                "name": "duration",
                "targets": 'class_duration',
                "render": function(data, type, full, meta) {
                    return convertMinutes(data);
                }
            },
            {
                "data": 'start_time',
                "name": "start_time",
                "targets": 'class_time',
                "render": function(data, type, full, meta) {
                    return moment.utc(data).local().format('MM/DD/YYYY LT')
                }
            },
            {
                "data": 'tutor.data.name',
                "name": "tutor_name",
                "targets": 'tutor_name',
                "render": function(data, type, full, meta) {
                    return '<a href="' + process.env.MIX_APP_URL + '/admin/tutors/' + full.tutor.id + '">' +
                        '<div class="user-card">' +
                        '<div class="user-info">' +
                        '<span class="tb-lead">' + full.tutor.name + '</span>' +
                        '<span class="d-block">' + full.tutor.email + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</a>';
                }
            },
            {
                'data': 'tutor_class_rating',
                'targets': 'rating',
                "render": function(data, type, full, meta) {
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
                "data": 'status',
                "targets": 'status',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    if (data == 'completed') {
                        return 'Completed';
                    }
                    if (data == 'cancelled') {
                        return 'Cancelled';
                    }
                    var checked = false;
                    if (data == 'active') {
                        checked = true;
                    }
                    return '<div class="custom-control custom-switch">' +
                        '<input type="checkbox" class="custom-control-input change-status" id="customSwitch' + full.id + '" ' + (checked ? 'checked="checked"' : '') + '>' +
                        '<label class="custom-control-label" for="customSwitch' + full.id + '"></label>' +
                        '</div>';
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
                        '<a href="' + process.env.MIX_APP_URL + '/admin/webinars/' + full.id + '"><em class="icon ni ni-eye"></em><span>View</span></a></a>\n' +
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
        $('#subject').val([]).trigger('change');
        $('#start_time').val('');
        $('#end_time').val('');
        clearDatepicker();
        webinarTable.DataTable().ajax.reload();
    });

    $('#webinar-filter').on('click', function() {
        $('.dot').addClass('dot-success');
        webinarTable.DataTable().ajax.reload();
    });
});