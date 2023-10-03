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

$('#sideMenuToggle').on('click', function() {
    $('.sideMenu').addClass('show');
});

$('#closeMenu').on('click', function() {
    $('.sideMenu').removeClass('show');
});

var clipboard = new ClipboardJS('#copy', {
    container: document.getElementById('copy')
});
clipboard.on('success', function(e) {
    setTooltip(Lang.get("labels.copied"));
    hideTooltip();
});