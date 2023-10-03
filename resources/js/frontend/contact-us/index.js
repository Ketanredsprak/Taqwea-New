$(function(){

    $("#contact-us-form").on('submit', (function (e) {
        e.preventDefault();
        var frm = $('#contact-us-form');
        var btn = $('#contact-submit');
        var btnName = btn.html();
        var url = $(this).attr('action');
        if (frm.valid()) {
            var showLoader = 'Processing...';
            showButtonLoader(btn, showLoader, 'disabled');
            $.ajax({
                url: url,
                type: "POST",
                data: frm.serialize(),
                cache: false,
                success: function (response) {
                    showButtonLoader(btn, btnName, 'enable');
                    successToaster(response.message);
                    frm[0].reset();
                },
                error: function (data) {
                    handleError(data);
                    showButtonLoader(btn, btnName, 'enable');
                },
            });
        }
    }));
});