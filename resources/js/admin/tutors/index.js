function getName(name){
    return name ? name : 'N/A';
}
$(function() {
    CKEDITOR.replace('reject_reason', {});

    var userDatatable = $('#tutor-datatable');

    function approveOrReject(tutorId, status) {
        var rejectReason = CKEDITOR.instances.reject_reason.getData();
        if (!rejectReason && status == "rejected") {
            $("#tutor-rejected-reason-error").html('Please enter the rejection reason.');
            return;
            
        }
     
       
        $.ajax({
            method: "PATCH",
            url: process.env.MIX_APP_URL + '/admin/tutors/' + tutorId + '/' + status,
            data: { _token: $('meta[name="csrf-token"]').attr('content'), reject_reason: rejectReason },
            success: function(response) {
                if (status == 'rejected') {
                    $('#reject_reason').val('');
                    $('#rejectReason').modal('hide');
                }
                userDatatable.DataTable().ajax.reload();
                successToaster(response.message, { timeOut: 2000 });
            },
            error: function(err) {
                handleError(err);
            },
        });
    }
    $('#reject-submit').on('click', function() {
        approveOrReject($("#tutor-id").val(), 'rejected');
    });
    NioApp.DataTable('#tutor-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/tutor/list",
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
                d.rating = $('#rating').val();
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
            $('.tutorChangePassword', row).on('click', function() {
                $('#updatePassword').modal('show');
                $('#id').val(data.id);
                $('#email').val(data.email);
            });

            $('.update-checkbox', row).on('change', function() {
                var url = process.env.MIX_APP_URL + '/admin/changeStatus/'
                var status = (data.status == 'active') ? 'inactive' : 'active';
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
                            data: { _token: $('meta[name="csrf-token"]').attr('content'), id: data.id, 'status': status },
                            success: function(data) {
                                if (data.success) {
                                    successToaster(data.message, { timeOut: 2000 });
                                    setTimeout(function() {
                                        $('#tutor-datatable').DataTable().draw(true);
                                    }, 2000);
                                }
                            },
                            error: function(err) {
                                handleError(err);
                            }
                        });
                    } else {
                        if (result.isDismissed) {
                            $('#tutor-datatable').DataTable().draw(true);
                        }

                    }
                })
            });

            $('.approve', row).on('click', function() {
                Swal.fire({
                    title: 'Are you sure',
                    text: "you want to approve?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.value) {
                        approveOrReject(data.id, 'approved');
                    }
                });
            });

            $('.reject', row).on('click', function() {
                Swal.fire({
                    title: 'Are you sure',
                    text: "you want to reject?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.value) {
                        $("#rejectReason").modal('show');
                        $("#tutor-id").val(data.id);
                    }
                });
            });
        },
        'order': [0, 'desc'],
        "columnDefs": [{
                "data": 'id',
                "name": 'id',
                "targets": 'id',
                "render": function(data, type, row, meta) {
                    return type == 'export' ? meta.row + 1 : data;
                }
            },
            {
                "data": 'name',
                "name": 'name',
                "targets": 'name',
                "render": function(data, type, full, meta) {
                    return '<a href=' + process.env.MIX_APP_URL + '/admin/tutors/' + full.id + '>\n' +
                        '<div class="user-card">\n' +
                        '<div class="user-avatar user-avatar-sm bg-warning">\n' +
                        '<img src="' + full.profile_image_url + '" alt="avatar">\n' +
                        ' </div>\n' +
                        '  <div class="user-name">\n' +
                        ' <p class="tb-lead fw-medium mb-0">' + getName(data) + '</p>\n' +
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
                'data': 'rating',
                'targets': 'rating',
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
                "data": 'created_at',
                "name": 'created_at',
                "targets": 'date',
                "render": function(data, type, full, meta) {
                    return moment(data).format('MM/DD/YYYY');
                }

            }, {
                "data": 'type_subscription',
                "targets": 'type_subscription'
            },
            {
                "data": 'total_classes',
                'targets': 'total_classes'
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
                "data": 'status',
                'targets': 'status',
                'orderable': false,
                'render': function(data, type, full, meta) {
                    var checked = '';
                    if (data == 'active') {
                        checked = 'checked = checked';
                    }
                    return '<div class="custom-control custom-switch">' +
                        '<input type="checkbox" class="custom-control-input update-checkbox" id="customSwitch' + full.id + '" value=' + full.id + ' ' + checked + '>' +
                        '<label class="custom-control-label" for="customSwitch' + full.id + '"></label>' +
                        '</div>';
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
                    if (full.login_type == 'normal') {
                        actions += '<li><a href="javascript:void(0)" data-toggle="modal" class="tutorChangePassword"><em class="icon ni ni-lock-alt-fill"></em><span>Change Password</span></a></li>\n';
                    }
                    actions += '<li><a href=' + process.env.MIX_APP_URL + '/admin/tutors/' + full.id + '><em class="icon ni ni-eye"></em><span>View</span></a></li>\n' +
                        '<li><a href=' + process.env.MIX_APP_URL + '/admin/tutors/' + full.id + '/edit' + '><em class="icon ni ni-pen"></em><span>Edit</span></a></li>\n ';
                    if ((!full.approval_status || full.approval_status == 'pending') && full.is_profile_completed) {
                        actions += '<li><a class="approve" href="javascript:void(0)"><em class="icon ni ni-check"></em><span>Approve</span></a></li>\n' +
                            '<li><a class="reject" href="javascript:void(0)"><em class="icon ni ni-cross"></em><span>Reject</span></a></li>\n';
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
    $('#tutor-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        userDatatable.DataTable().draw(true);
    });
    $('.reset-filter').on('click', function(e) {
        $('.dot').removeClass('dot-success');
        $('.form-select').val('').trigger('change');
        $('#from_date').val('');
        $('#to_date').val('');
        clearDatepicker();
        userDatatable.DataTable().draw(true);
    });
});
$(document).on('submit', '#tutor_edit_form', function(e) {
    e.preventDefault();
    var frm = $('#tutor_edit_form');
    var btn = $('#tutor_edit_btn');
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        if (formData.get('profile_image')) {

            var file = imageBase64toFile(formData.get('profile_image'), 'user_image');
            formData.delete('profile_image');
            formData.append("profile_image", file); // remove base64 image content
        }
        formData.append("_method", 'PUT');

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                showButtonLoader(btn, 'Update', 'enable');
                successToaster(response.message);
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, 'Update', 'enable');
            },
        });
    }
});