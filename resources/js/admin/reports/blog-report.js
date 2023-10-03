$(function() {
    var blogTable = $('#blog-report-datatable');
    NioApp.DataTable('#blog-report-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/blog-report/list",
            type: "get",

            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(blogTable.DataTable().page.info().page) + 1;
                d.search = blogTable.DataTable().search();
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
            $('.showBlogDescription', row).on('click', function() {

                $('#readMoreModal .modal-body p').html(data.blog_description);
                $('#readMoreModal').modal('show');

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
                "name": 'id',
                "targets": 'id',
            },
            {
                "data": 'name',
                "name": 'tutor_name',
                "targets": 'tutor_name',
                "render": function(data, type, full, meta) {
                    return '<a href="#" class="showUserModal" data-toggle="modal">\n' +
                        '<div class="user-card">\n' +
                        '<div class="user-avatar user-avatar-sm bg-warning">\n' +
                        '<img src="' + full.media_url + '" alt="avatar">\n' +
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
                'data': 'blog_title',
                "name": 'blog_title',
                'targets': 'blog_title',
                'defaultContent': '--',
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
                'data': 'blog_description',
                "name": 'blog_description',
                'targets': 'blog_description',
                'defaultContent': '--',
                "render": function(data, type, full, meta) {
                    var text = full.blog_description;
                    var limit = 10;
                    var string = text.substring(0, limit);
                    if (text.length > limit) {
                        string = string + ' <a href = "javascript:void(0);" class="showBlogDescription" >Read More </a>';
                    } else {
                        string = '<span>' + string + '</span>';
                    }
                    return string;
                }
            },
            {
                'data': 'no_of_attendee',
                "name": 'no_of_attendee',
                'targets': 'blog_capacity',
                'defaultContent': '--',
            }

        ]
    });
    $('#blog-report').on('click', function(e) {
        $('.dot').addClass('dot-success');
        blogTable.DataTable().draw(true);
    });
    $('.reset-filter').on('click', function(e) {
        $('.dot').removeClass('dot-success');
        $('#to_date').val('');
        $('#from_date').val('');
        clearDatepicker();
        blogTable.DataTable().draw(true);
    });
});