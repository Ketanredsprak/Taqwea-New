function getName(name){
    return name ? name : 'N/A';
}
$(function() {
    var student = $('#student-datatable');
    NioApp.DataTable('#student-datatable', {
        'processing': true,
        'serverSide': true,
        "bDestroy": true,
        'ajax': {
            url: process.env.MIX_APP_URL + "/admin/student/list",
            type: 'Get',
            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(student.DataTable().page.info().page) + 1;
                d.search = student.DataTable().search();
                d.user_type = 'student';
                d.status = $('#status').val();
                d.gender = $('#gender').val();
                d.rating = $('#rating').val();
                d.from_date = $('#from_date').val() ? moment($('#from_date').val()).format('YYYY-MM-DD') : '';
                d.to_date = $('#to_date').val() ? moment($('#to_date').val()).format('YYYY-MM-DD') : '';
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data, full) {
            $('.studentChangePassword', row).on('click', function() {
                $('#updatePassword').modal('show');
                $('#id').val(data.id);
                $('#email').val(data.email);
            });

            $('#showUserModal', row).on('click', function() {
                $.ajax({
                    method: "GET",
                    url: process.env.MIX_APP_URL + '/admin/students/' + data.id,
                    success: function(response) {
                        $('#view-student').html(response);
                        $('#studentDetails').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });

            $('.edit', row).on('click', function() {
                $.ajax({
                    method: "GET",
                    url: process.env.MIX_APP_URL + '/admin/students/' + data.id + '/edit',
                    success: function(response) {
                        $('#editStudent').html(response);
                        $('#editStudent').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
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
                                        $('#student-datatable').DataTable().draw(true);
                                    }, 2000);
                                }
                            },
                            error: function(err) {
                                handleError(err);
                            }
                        });
                    } else {
                        if (result.isDismissed) {
                            $('#student-datatable').DataTable().draw(true);
                        }

                    }
                })
            });

        },
        'order': [0, 'desc'],
        'columnDefs': [{
                'data': 'id',
                'targets': 'id'
            },
            {
                "data": 'name',
                'name': 'name',
                "targets": 'name',
                "defaultContent": '--',
                "render": function(data, type, full, meta) {
                    return '<a href="javascript:void(0)" id="showUserModal"  data-toggle="modal">\n' +
                        '<div class="user-card">\n' +
                        '<div class="user-avatar user-avatar-sm bg-warning">\n' +
                        '<img src="' + full.profile_image_url + '" alt="avatar">\n' +
                        ' </div>\n' +
                        '  <div class="user-name">\n' +
                        '  <p class="tb-lead fw-medium mb-0">' + getName(data) + '</p>\n' +
                        '  <small class="text-gray">' + full.email + '</small>\n' +
                        ' </div>\n' +
                        ' </div>\n' +
                        '</a>';
                }
            },
            {
                'data': 'gender',
                'targets': 'gender',
                'name': 'gender',
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
                'data': 'created_at',
                'name': 'created_at',
                'targets': 'registration',
                'defaultContent': '--',
                "render": function(data, type, full, meta) {
                    return moment(data).format('MM/DD/YYYY');
                }
            },
            {
                'data': 'status',
                'targets': 'status',
                'orderable': false,
                "render": function(data, type, full, meta) {
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
                'data': 'id',
                'targets': 'actions',
                'orderable': false,
                'render': function(data, type, full, meta) {
                    var actions = '';
                    if (full.login_type == 'normal') {
                        actions += '<li><a href="javascript:void(0)" data-toggle="modal" class="studentChangePassword"><em class="icon ni ni-lock-alt-fill"></em><span>Change Password</span></a></li>\n';
                    }
                    actions += '<li><a href="javascript:void(0)" id="showUserModal"><em class="icon ni ni-eye" ></em><span>View</span></a></li>\n' +
                        '<li><a href="javascript:void(0)" class="edit"><em class="icon ni ni-pen delete"></em><span>Edit</span></a></li>\n';
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
    $('#student-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        student.DataTable().draw(true);
    });

    $('.reset-filter').on('click', function() {
        $('.dot').removeClass('dot-success');
        $('#to_date').val('');
        $('#from_date').val('');
        $('.form-select').val('').trigger('change');
        clearDatepicker();
        student.DataTable().ajax.reload();
    });

    $(document).on('submit', '#student-edit-form', function(e) {
        e.preventDefault();
        var frm = $('#student-edit-form');
        var btn = $('#student-edit-btn');
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
                    $('#editStudent').modal('hide');
                },
                error: function(data) {
                    handleError(data);
                    showButtonLoader(btn, 'Update', 'enable');
                },
            });
        }
    });
});