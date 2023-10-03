// rateStar
$(function() {
    readMore();

    $(".rateStar").each(function(index) {
        var rating = $(this).attr("data-rating");
        $(this).rateYo({ 
            normalFill: "#808080",
            ratedFill: "#000000",
            rating: rating,
            readOnly: true,
            spacing: "2px"
        });
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