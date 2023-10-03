$(function() {
    CKEDITOR.replace('reply_text', {});
    var userDatatable = $('#support-datatable');
    NioApp.DataTable('#support-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/help-support/list",
            type: 'Get',

            data: function(d) {
                d.size = d.length;
                d.page = parseInt(userDatatable.DataTable().page.info().page) + 1;
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {
            $('.showEmailMsg', row).on('click', function() {
                $.ajax({
                    method: "GET",
                    url: process.env.MIX_APP_URL + '/admin/read/' + data.id,
                    data: { id: data.id },
                    success: function(response) {
                        $('#readMoreModal .modal-body p').html(response.data.message);
                        $('#readMoreModal').modal('show');
                    },
                    error: function(errorResponse) {
                        handleError(errorResponse);
                    },
                });
            });

            $('.replyModel', row).on('click', function() {
                $('#replyModal').modal('show');
                CKEDITOR.instances.reply_text.setData('');
                $('#support_email_id').val(data.id);
                $('#support_email').val(data.email);
            });
        },
        'order': [0, 'desc'],
        "columnDefs": [{
                "data": 'id',
                'name': 'id',
                "targets": 'no',
            },
            {
                "data": 'name',
                'name': 'name',
                "targets": 'name'
            },
            {
                "data": 'email',
                'name': 'email',
                "targets": 'email'
            },
            {
                "data": 'message',
                'name': 'message',
                "targets": 'message',
                "render": function(data, type, full, meta) {
                    var text = full.message;
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
                        '<a href="javascript:void(0);" data-toggle="modal" class="replyModel"><em class="icon ni ni-curve-up-left"></em><span>Reply</span></a>\n' +
                        '</ul>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</li>\n' +
                        '</ul> ';
                    return n;
                }
            },
        ]
    });

    $('#reply-form').on('submit', function(event) {
        var replyForm = $('#reply-form');
        event.preventDefault();
        if (replyForm.valid()) {
            var formData = new FormData($("#reply-form")[0]);
            var reply_text = CKEDITOR.instances.reply_text.getData();
            formData.append('reply_text', reply_text);
            $.ajax({
                method: "POST",
                url: process.env.MIX_APP_URL + '/admin/support-email-reply',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#replyModal').modal('hide');
                },
                error: function(errorResponse) {
                    handleError(errorResponse);
                },
            });
        }
    });
});