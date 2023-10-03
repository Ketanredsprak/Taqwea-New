$(function() {
    var blogTable = $('#blog-table');

    NioApp.DataTable(blogTable, {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + '/admin/blogs/purchase/list',
            type: 'GET',
            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(blogTable.DataTable().page.info().page) + 1;
                d.search = blogTable.DataTable().search();
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
            $('.showBlogTitle', row).on('click', function() {

                $('#readMoreModal .modal-body p').html(data.blog.blog_title);
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
                "data": 'student_name',
                "name": "student_name",
                "targets": 'student_name',
                "render": function(data, type, full, meta) {
                    return '<a href="">' +
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
                "data": 'blog.blog_title',
                "name": "blog_name",
                "targets": 'blog_name',
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
                "data": 'blog.total_fees',
                "name": "blog_price",
                "targets": 'blog_price',
                "render": function(data, type, full, meta) {
                    return config + ' ' + data;
                }
            },
            {
                "data": 'total_amount',
                "name": "amount_paid",
                "targets": 'amount_paid',
                "render": function(data, type, full, meta) {
                    return config + ' ' + data;
                }
            },

            {
                "data": 'purchase_date',
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
                        '<a href="' + process.env.MIX_APP_URL + '/admin/purchased-blogs/' + full.blog.id + '"><em class="icon ni ni-eye"></em><span>View</span></a></a>\n' +
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