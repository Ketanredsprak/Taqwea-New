$(function() {
    CKEDITOR.replace('reply_text', {});
    var userDatatable = $('#support-datatable');
    NioApp.DataTable('#support-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/accountant/supports/list",
            type: 'Get',

            data: function(d) {
                d.size = d.length;
                d.page = parseInt(userDatatable.DataTable().page.info().page) + 1;
                d.type = 'Accountant';
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {
            $('.showEmailMsg', row).on('click', function() {

                $('#readMoreModal .modal-body p').html(data.message);
                $('#readMoreModal').modal('show');

            });

            $('.replyModel', row).on('click', function() {
                $('#replyModal').modal('show');
                CKEDITOR.instances.reply_text.setData('');
                $('#support_email_id').val(data.id);
                $('#support_email').val(data.email);
            });
        },
        "stateSave": true,
        "columnDefs": [{
                "data": 'id',
                "targets": 'no',
            },
            {
                "data": 'name',
                "targets": 'name'
            },
            {
                "data": 'email',
                "targets": 'email'
            },
            {
                "data": 'message',
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
            // {
            //     "data": 'id',
            //     "targets": 'actions',
            //     'orderable': false,
            //     "render": function(data, type, full, meta) {
            //         return '<a href="javascript:void(0);" data-toggle="modal" class="btn btn-sm mr-1 btn-primary ripple-effect replyModel">Reply</a>';
            //     }
            // },
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
                url: process.env.MIX_APP_URL + '/accoutant/support-email-reply',
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