$(function() {
    var testimonial = $('#demo-datatable');
    NioApp.DataTable('#demo-datatable', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + "/admin/demo-list",
            type: 'Get',
            data: function(d) {
                d.size = d.length;
                d.page = parseInt(testimonial.DataTable().page.info().page) + 1;
                d.search = testimonial.DataTable().search();
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {
            $('.showEmailMsg', row).on('click', function() {
                $('#readMoreModal .modal-body p').html(data.content);
                $('#readMoreModal').modal('show');
            });

            $('.delete', row).on('click', function() {
                var url = process.env.MIX_APP_URL + '/admin/demo/' + data.id;
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary mr-2',
                        cancelButton: 'btn btn-light ripple-effect-dark'
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this subject!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            data: { _token: $('meta[name="csrf-token"]').attr('content') },
                            url: url,
                            success: function(data) {
                                successToaster(data.message, { timeOut: 2000 });
                                testimonial.DataTable().ajax.reload();
                            },
                            error: function(err) {
                                handleError(err);
                            }
                        });
                    }
                });
            });

        },
        'order': [0, 'desc'],
        "columnDefs": [{
                "data": 'id',
                'name': 'id',
                "targets": 'id',
            },
            {
                "data": 'name',
                'name': 'name',
                "targets": 'name',
                "render": function(data, type, full, meta) {
                    // return '<a href="javascript:void(0)" id="showUserModal"  data-toggle="modal">\n' +
                    //     '<div class="user-card">\n' +
                    //     '<div class="user-avatar user-avatar-sm bg-warning">\n' +
                    //     '<img src="' + full.testimonial_image_url + '" alt="avatar">\n' +
                    //     ' </div>\n' +
                    //     '  <div class="user-name">\n' +
                    //     ' <p class="tb-lead fw-medium mb-0">' + data + '</p>\n' +
                    //     ' </div>\n' +
                    //     ' </div>\n' +
                    //     '</a>';
                    return data;
                }
            },
            {
                "data": 'id',
                "targets": 'actions',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    var n = '<ul class="nk-tb-actions gx-1 justify-content-center">\n' +
                        '<li>\n' +
                        '<div class="drodown">\n' +
                        '<a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '<div class="dropdown-menu dropdown-menu-right">\n' +
                        '<ul class="link-list-opt no-bdr">\n' +
                        '<li><a class="edit" href=' + process.env.MIX_APP_URL + '/admin/demo/' + full.id + '/edit' + '><em class="icon ni ni-pen"></em><span>Edit</span></a></li>\n' +
                        '<li><a href="javascript:void(0)" class="eg-swal-av3 delete"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>\n' +
                        '</ul>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</li>\n' +
                        '</ul>';

                    return n;
                }
            }
        ]

    });

    $("#demo-frm").on('submit', function(event) {
        event.preventDefault();
        var frm = $('#demo-frm');
        var submitButton = $('#demo-btn');
        var method = "POST";
        var buttonLabel = "Add";
        var btnName = submitButton.html();
        var url = frm.attr('action');
        if (frm.valid()) {
            var formData = new FormData($("#demo-frm")[0]);
            showButtonLoader(submitButton, btnName, 'disabled');
            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    successToaster(response.message);
                    window.location.href = process.env.MIX_APP_URL + '/admin/demo';
                },
                error: function(data) {
                    console.log(data);
                    showButtonLoader(submitButton, buttonLabel + ' Demo');
                    handleError(data);
                }
            });
        }
    });
});

// $(".deleteTestimonialImage").click(function() {
//     $(this).parent().parent().css('display', 'none');
//     $("#testimonailAddUpdateImageDiv").css('display', 'block');
//     $("#testimonailAddUpdateImageDiv").children(".uploadStuff").css('display', 'block');
//     $("#old_images").val("");
// });