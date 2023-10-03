$(function() {
    var blogTable = $('#blog-table');

    function changeStatus(id, status) {
        var url = process.env.MIX_APP_URL + '/admin/blogs/' + id;
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

    NioApp.DataTable(blogTable, {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + '/admin/blogs/list',
            type: 'GET',
            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(blogTable.DataTable().page.info().page) + 1;
                d.search = blogTable.DataTable().search();
                d.status = $('#status').val();

                d.from_date = $('#start_time').val() ? moment.utc($('#start_time').val()).format('YYYY-MM-DD') : '';
                d.to_date = $('#end_time').val() ? moment.utc($('#end_time').val()).format('YYYY-MM-DD') : '';

                d.content_type = $('#contentType').val();
                d.category = $('#category_id').val();
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
                        text: "You want to inactive this blog!",
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Inactive it!',
                    }).then((result) => {
                        if (result.value) {
                            changeStatus(data.id, status);
                        } else {
                            $('.change-status', row).prop("checked", true);
                        }
                    });
                } else {
                    changeStatus(data.id, status);
                }
            });
            $('.showBlogTitle', row).on('click', function() {

                $('#readMoreModal .modal-body p').html(data.blog_title);
                $('#readMoreModal').modal('show');

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
                "data": 'blog_title',
                "name": "blog_title",
                "targets": 'blog_title',
                "render": function(data, type, full, meta) {
                    var text = data;
                    var limit = 10;
                    var string = text.substring(0, limit);
                    if (text.length > limit) {
                        string = string + ' <a href = "javascript:void(0);" class="showBlogTitle" >Read More </a>';
                    } else {
                        string = '<span>' + string + '</span>';
                    }
                    return string;
                }
            },
            {
                "data": 'category.category_name',
                "name": "category",
                "targets": 'category'
            },
            {
                "data": 'subject.subjects',
                "name": "subject",
                "targets": 'subject',
                'defaultContent': '--',
            },
            {
                "data": 'type',
                "name": "type",
                "targets": 'type',
                "render": function(data, type, full, meta) {
                    return data.charAt(0).toUpperCase() + data.slice(1);
                }
            },
            {
                "data": 'created_at',
                "name": "created_at",
                "targets": 'created_at',
                "render": function(data, type, full, meta) {
                    return moment.utc(data).local().format('MM/DD/YYYY LT')
                }
            },
            {
                "data": 'tutor.name',
                "name": "tutor_name",
                "targets": 'tutor_name',
                "render": function(data, type, full, meta) {
                    return '<a href="' + process.env.MIX_APP_URL + '/admin/tutors/' + full.tutor.id + '">' +
                        '<div class="user-card">' +
                        '<div class="user-info">' +
                        '<span class="tb-lead">' + full.tutor.name + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</a>';
                }
            },
            {
                'name': 'total_fees',
                'data': 'total_fees',
                'targets': 'price',
                "render": function(data, type, full, meta) {
                    return config + ' ' + data;
                }
            },
            {
                "name": 'status',
                "data": 'status',
                "targets": 'status',
                "render": function(data, type, full, meta) {
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
                        '<a href="' + process.env.MIX_APP_URL + '/admin/blogs/' + full.id + '"><em class="icon ni ni-eye"></em><span>View</span></a></a>\n' +
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
        clearDatepicker();
        blogTable.DataTable().ajax.reload();
    });

    $('#blog-filter').on('click', function() {
        $('.dot').addClass('dot-success');
        blogTable.DataTable().ajax.reload();
    });
});
