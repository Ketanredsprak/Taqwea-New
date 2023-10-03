window.quoteModal= function quoteModal(id,class_requiest_id,tutor_id,student_id) {
    $('#tutor_request_id').val(id);
    $('#tutor_id').val(tutor_id);
    $('#student_id').val(student_id);
    $('#class_request_id').val(class_requiest_id);
    $('#quoteModal').modal('show');
}

$("#addQuoteForm").on('submit', (function(e) {
    e.preventDefault();
    var frm = $('#addQuoteForm');
    var btn = $('#addQuoteBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                successToaster(response.message);
                frm[0].reset();
                $('#quoteModal').modal('hide');
                window.location.href = process.env.MIX_APP_URL + '/tutor/classrequest/';
                
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

