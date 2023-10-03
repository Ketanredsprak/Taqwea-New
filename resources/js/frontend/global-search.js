
function delay(callback, ms) {
    var timer = 0;
    return function() {
      var context = this, args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () {
        callback.apply(context, args);
      }, ms || 0);
    };
}
window.globalSearch = function globalSearch() {
    var url = process.env.MIX_APP_URL + '/search';
    var searchText = $("#global-search-text").val();

    // new search updated
    var newUrl = process.env.MIX_APP_URL + '/search?search=';
    window.location.href = newUrl + searchText;


}
     // Global search
$(document).on('keyup', '#global-search-text', delay(function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) { //Enter keycode
        e.preventDefault();
        // globalSearch();
        $('#global-search-button').trigger('click');
    }
}, 500));

$(document).on('click', '#global-search-button', function() {
    globalSearch();
});
