$(function() {
    var refundRequest = $('#refund-request-datatable');
    NioApp.DataTable('#refund-request-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        'language': {
            searchPlaceholder: "Search by tutor name",
        },
        "ajax": {
            url: process.env.MIX_APP_URL + "/accountant/refunds/list",
            type: "get",

            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(refundRequest.DataTable().page.info().page) + 1;
                d.search = refundRequest.DataTable().search();
                d.tutor_name = $('#tutor_name').val();
                d.status = $('#status').val();
                d.student_name = $('#student_name').val();
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
            $('.studentDetail', row).on('click', function() {
                $.ajax({
                    type: "get",
                    url: process.env.MIX_APP_URL + "/accountant/refund-request/" + data.student_id,
                    data: { class_id: data.class_id, id: data.id },
                    success: function(response) {
                        console.log(response);
                        $('#studentDetail').html(response);
                        $('#studentDetails').modal('show');
                    },
                    error: function(err) {
                        handleError(err);
                    }
                });
            });
            $('.cancelRequest', row).on('click', function() {
                $('#id').val(data.id);
                $('#cancelRequest').modal('show');
            });
            $('.refundRequest', row).on('click', function() {
                $('#student_id').val(data.student_id);
                $('#class_id').val(data.class_id);
                $('#amount').val(data.transactionItem.total_refund_amount);
                $('#amount1').val(data.transactionItem.total_refund_amount);
                $('#refund').modal('show');
            });

            $('.showDisputeReason', row).on('click', function() {

                $('#readMoreModal .modal-body p').html(data.dispute_reason);
                $('#readMoreModal').modal('show');

            });
        },
        "stateSave": true,
        "columnDefs": [{
                "data": 'id',
                "targets": 'id',
                "render": function(data, type, row, meta) {
                    return type == 'export' ? meta.row + 1 : data;
                }
            },
            {
                "data": 'tutor_name',
                "targets": 'tutor_name',
                "render": function(data, type, full, meta) {
                    return '<a href="#" class="showUserModal" data-toggle="modal">\n' +
                        '<div class="user-card">\n' +
                        '<div class="user-avatar user-avatar-sm bg-warning">\n' +
                        '<img src="' + full.class.tutor.profile_image_url + '" alt="avatar">\n' +
                        ' </div>\n' +
                        '  <div class="user-name">\n' +
                        ' <p class="tb-lead fw-medium mb-0">' + full.class.tutor.name + '</p>\n' +
                        '  <small class="text-gray">' + full.class.tutor.email + '</small>\n' +
                        ' </div>\n' +
                        ' </div>\n' +
                        '</a>';
                }
            },
            {
                'data': 'student.name',
                'targets': 'student_name',
                'defaultContent': '--',
            },
            {
                "data": 'class.class_name',
                "targets": 'class_name',
                'defaultContent': '--',
            },
            {
                "data": 'class.duration',
                'targets': 'duration',
                "render": function(data, type, full, meta) {
                    return convertMinutes(full.class.duration);
                }
            },
            {
                "data": 'class.hourly_fees',
                'targets': 'hourly_rate',
                "render": function(data, type, full, meta) {
                    return config + ' ' + data;
                }
            },
            {
                "data": 'created_at',
                'targets': 'date_&_time',
                "render": function(data, type, full, meta) {
                    return moment.utc(data).local().format('MM/DD/YYYY LT');
                }
            },
            {
                "data": 'dispute_reason',
                'targets': 'dispute_reason',
                'defaultContent': '--',
                "render": function(data, type, full, meta) {
                    console.log();
                    var text = data;
                    var limit = 10;
                    var string = text.substring(0, limit);
                    if (text.length > limit) {
                        string = string + ' <a href = "javascript:void(0);" class="showDisputeReason" >...Read More </a>';
                    } else {
                        string = '<span>' + string + '</span>';
                    }
                    return string;
                }
            },
            {
                "data": 'status',
                'targets': 'status',
                'defaultContent': '--',
                'orderable': false,
                'render': function(data, type, full, meta) {
                    if (data == 'pending') {
                        return '<span class ="text-warning">Pending</span>';
                    } else if (data == 'cancel') {
                        return '<span class ="text-danger">Cancel</span>';
                    } else if (data == 'refund') {
                        return '<span class ="text-success">Refund</span>';
                    }
                }
            },
            {
                "data": "id",
                "width": "80px",
                "targets": 'actions',
                "class": 'text-right',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    var actions = '';
                    if (full.status == 'cancel') {
                        actions += '<li><a href="javascript:void(0)" class="studentDetail" ><em class="icon ni ni-eye"></em><span>View</span></a></li>\n';
                    }
                    if (full.status == 'pending') {
                        actions += '<li><a href="javascript:void(0)" class="studentDetail"><em class="icon ni ni-eye"></em><span>View</span></a></li>\n' +
                            '<li><a href="javascript:void(0)" class="refundRequest"><em class="icon ni ni-curve-up-left"></em><span>Send Refund</span></a></li>\n' +
                            '<li><a href="javascript:void(0)" class="cancelRequest"><em class="icon ni ni-cross"></em><span>Cancel Dispute</span></a></li>\n';
                    }
                    if (full.status == 'refund') {
                        actions += '<li><a href="javascript:void(0)" class="studentDetail"><em class="icon ni ni-eye"></em><span>View</span></a></li>\n';
                    }
                    var n = '<ul class="nk-tb-actions gx-1 justify-content-center"\n' +
                        ' <li>\n' +
                        '  <div class="dropdown">\n' +
                        '  <a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '  <div class="dropdown-menu dropdown-menu-right ">\n' +
                        '  <ul class="link-list-opt no-bdr">\n' +
                        actions +
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
        $('#tutor_name').val('');
        $('#student_name').val('');
        $('#status').val('').trigger('change');
        $('#from_date').val('');
        $('#to_date').val('');
        refundRequest.DataTable().ajax.reload();
    });

    $('#class-filter').on('click', function() {
        $('.dot').addClass('dot-success');
        refundRequest.DataTable().ajax.reload();
    });

    $("#submit_cancel_request").on('click', (function(e) {
        e.preventDefault();
        var frm = $('#cancelRequestFrm');
        var btn = $('#submit_cancel_request');
        var id = $('#id').val();
        var btnName = btn.html();
        if (frm.valid()) {
            btn.prop('disabled', true);
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: process.env.MIX_APP_URL + '/accountant/refund-request/' + id,
                type: "PUT",
                data: frm.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#cancelRequest').modal('hide');
                        successToaster(response.message, 'Cancel Request');
                        refundRequest.DataTable().ajax.reload();
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
    }));
    $("#refund-submit").on('click', (function(e) {
        e.preventDefault();
        var frm = $('#refundAmountRequestFrm');
        var btn = $('#refund-submit');
        var btnName = btn.html();
        if (frm.valid()) {
            btn.prop('disabled', true);
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: process.env.MIX_APP_URL + '/accountant/refund-request',
                type: "POST",
                data: frm.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#refund').modal('hide');
                        successToaster(response.message, 'Cancel Request');
                        refundRequest.DataTable().ajax.reload();
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
    }));
});