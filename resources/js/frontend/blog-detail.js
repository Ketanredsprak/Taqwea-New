$(document).on('click', '.showBlogContent', function () {
    $("#videoModal").modal('show');
});

$(document).on('click', '.showPurchaseMessage', function () {
    Swal.fire({
        title: '',
        icon: 'info',
        html:
          Lang.get("labels.blog_purchase_content"),
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonText:
        Lang.get("labels.ok"),
    })
});


$(document).on('click', '.download', function () {
    $.ajax({
        type: 'GET',
        url: process.env.MIX_APP_URL +'/blogs/download/'+$(this).attr('data-slug'),
        success: function(res){
            let name = Math.random().toString(36).substring(2,7);
            const data = res.data.path;
            const link = document.createElement('a');
            link.setAttribute('href', data);
            link.setAttribute('download', name+'.'+res.data.extension); // Need to modify filename ...
            link.click();
        },
        error: function(res){
            console.log(res);
        }
    });
});

$('#copy').tooltip({
    trigger: 'click',
    placement: 'bottom',
    animation: false
});

function setTooltip(message) {
    $('#copy').tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
}

function hideTooltip() {
    setTimeout(function() {
        $('#copy').tooltip('hide');
    }, 1000);
}

var clipboard = new ClipboardJS('#copy', {
    container: document.getElementById('copy')
});
clipboard.on('success', function(e) {
    setTooltip(Lang.get("labels.copied"));
    hideTooltip();
});
