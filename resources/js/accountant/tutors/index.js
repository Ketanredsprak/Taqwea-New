$(function() {
    var userDatatable = $('#tutor-datatable');
    NioApp.DataTable('#tutor-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/accountant/tutor/list",
            type: "get",

            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(userDatatable.DataTable().page.info().page) + 1;
                d.search = userDatatable.DataTable().search();
                d.user_type = 'tutor';
                d.status = $('#status').val();
                d.gender = $('#gender').val();
                d.subscription = "subscription";
                d.is_approved = 1;
                d.approval_status = $('#verification-status').val();
                d.from_date = $('#from_date').val() ? moment($('#from_date').val()).format('YYYY-MM-DD') : '';
                d.to_date = $('#to_date').val() ? moment($('#to_date').val()).format('YYYY-MM-DD') : '';
            },

            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {
            $('.process', row).on('click', function() {
                $.ajax({
                    type: "get",
                    url: process.env.MIX_APP_URL +'/accountant/tutor/pay-now-load/'+data.id,
                    success: function(response) {
                        $('#tutor-account-details').html(response.html);
                        $('#tutor-account-details').modal('show');
                    },
                    error: function(err) {
                        handleError(err);
                    }
                });
            });
            $('.points', row).on('click', function() {
                $.ajax({
                    type: "get",
                    url: process.env.MIX_APP_URL +'/accountant/tutor/get-point/'+data.id,
                    success: function(response) {
                        $('#tutor-manage-points').html(response.html);
                        $('#tutor-manage-points').modal('show');
                    },
                    error: function(err) {
                        handleError(err);
                    }
                });
            });
        },
        "stateSave": true,
        "columnDefs": [{
                "data": 'id',
                "name": 'id',
                "targets": 'no',
                "render": function(data, type, row, meta) {
                    return type == 'export' ? meta.row + 1 : data;
                }
            },
            {
                "data": 'name',
                "name": 'name',
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
                'data': 'phone_number',
                "name": 'phone_number',
                'targets': 'phone_number',
                'defaultContent': '--',
            },
            {
                "data": 'tutor_subscription.subscription.subscription_name',
                "targets": 'type_subscription',
                "name": 'type_subscription',
                'defaultContent': '--',
            },
            {
                "data": 'total_classes',
                "name": 'total_classes',
                'targets': 'total_classes',
                'render': function(data, type, full, meta) {
                    return full.classes_completed + '/' + full.total_classes;
                }
            },
            {
                "data": 'total_webinars',
                "name": 'total_webinars',
                'targets': 'total_webinars',
                'render': function(data, type, full, meta) {
                    return full.webinar_completed + '/' + full.total_webinars;
                }
            },
            {
                "data": 'blogs_count',
                "name": 'blogs_count',
                'targets': 'total_blogs'
            },
            {
                "data": 'total_earning',
                "name": 'total_earning',
                'targets': 'total_earnings',
                'orderable': false,
                'defaultContent': '--',
            },
            {
                "data": 'total_sale',
                "name": 'total_sale',
                'targets': 'total_sale',
                'orderable': false,
                'defaultContent': '--',
            },
            {
                "data": 'total_admin_commission',
                "name": 'total_admin_commission',
                'targets': 'total_admin_commission',
                'orderable': false,
                'defaultContent': '--',
            },
            {
                "data": 'total_admin_commission',
                "name": 'total_admin_commission',
                'targets': 'total_admin_commission',
                'orderable': false,
                'defaultContent': '--',
            },
            {
                "data": 'total_paid_tutor',
                "name": 'total_paid_tutor',
                'targets': 'total_paid_tutor',
                'orderable': false,
                'defaultContent': '--',
            },
            {
                "data": 'total_due',
                "name": 'total_due',
                'targets': 'total_due',
                'orderable': false,
                'defaultContent': '--',
            },
            {
                "data": 'total_points',
                "name": 'total_points',
                'targets': 'total_points',
                'orderable': false,
                'defaultContent': '--',
            },
            {
                "data": "id",
                "width": "80px",
                "targets": 'actions',
                "class": 'text-right',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    var n = '<ul class="nk-tb-actions gx-1 justify-content-center"\n'+
                   ' <li>\n' +
                        '  <div class="drodown">\n' +
                        '  <a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '  <div class="dropdown-menu dropdown-menu-right">\n' +
                        '  <ul class="link-list-opt no-bdr">\n';
                        n += '  <li> <a href=' + process.env.MIX_APP_URL + '/accountant/tutor-show/' + full.id + '><em class="icon ni ni-eye"></em><span>View</span></a></li>\n'
                        + '  <li> <a href="javascript:void(0)" class="points"><em class="icon ni ni-coin"></em><span>Manage Points</span></a></li>\n';
                        if (full.total_due > 0) {
                            n += '  <li> <a href="javascript:void(0)" class="process"><em class="icon ni ni-coin"></em><span>Pay Now</span></a></li>\n';
                        }
                        n += '  </ul>\n' +
                        '  </div>\n' +
                        '  </div>\n' +
                        '  </li>\n'+
                        '  </ul> ';

                    return n;
                }
            }
        ]
    });
    $('#tutor-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        userDatatable.DataTable().draw(true);
    });
    window.reset = function() {
        $('.dot').removeClass('dot-success');
        $('#to_date').val('');
        $('#from_date').val('');
        $('#status').val('');
        $('#gender').val('');
        $('#verification-status').val('');
        $('.form-select').val('').trigger('change');
        userDatatable.DataTable().draw(true);
    }

    $("#tutor-account-details").on('submit', '#payAmountRequestFrm', function(event) {
        event.preventDefault();
        var frm = $('#payAmountRequestFrm');
        var btn = $('#paynow-submit');
        var btnName = btn.html();
        if (frm.valid()) {
            btn.prop('disabled', true);
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: process.env.MIX_APP_URL + '/accountant/tutor/pay-now',
                type: "POST",
                data: frm.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#tutor-account-details').modal('hide');
                        successToaster(response.message, 'Success');
                        userDatatable.DataTable().ajax.reload();
                    }
                },
                error: function(data) {
                    handleError(data);
                },
                complete: function() {
                    showButtonLoader(btn, btnName, 'enable');
                }
            });
        }
    });

    $("#tutor-manage-points").on('submit', '#managePointsRequestFrm', function(event) {
        event.preventDefault();
        var frm = $('#managePointsRequestFrm');
        var btn = $('#manage-points');
        var btnName = btn.html();
        if (frm.valid()) {
            btn.prop('disabled', true);
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: process.env.MIX_APP_URL + '/accountant/tutor/manage-points',
                type: "POST",
                data: frm.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#tutor-manage-points').modal('hide');
                        successToaster(response.message, 'Success');
                        userDatatable.DataTable().ajax.reload();
                    }
                },
                error: function(data) {
                    handleError(data);
                },
                complete: function() {
                    showButtonLoader(btn, btnName, 'enable');
                }
            });
        }
    });
});
