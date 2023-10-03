<script src="{{ asset('assets/js/frontend/frontend-app.js') }}"></script>
<script src="{{ asset('assets/js/messages.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script>
    var apiKey = "{{ config('fcm.apiKey') }}"
    var projectId = "{{ config('fcm.project_id') }}"
    var senderId = "{{ config('fcm.http.sender_id') }}"
    var appId = "{{ config('fcm.app_id') }}"
    var userId = {{ Auth::user()->id }}
    var deviceId = "{{Auth::user()->device ? Auth::user()->device->device_id : ''}}";
    var swUrl = "{{asset('assets/firebase-messaging-sw.js')}}";
</script>
<script type="text/javascript" src="{{asset('assets/js/frontend/fcm-token.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/global-search.js')}}"></script>
@if(session()->has('success'))
<script>
    $(document).ready(function () {
        successToaster("{!! session('success') !!}");
    });
</script>
@endif
@if(session()->has('error'))
<script>
    $(document).ready(function () {
        errorToaster("{!! session('error') !!}");
    });

</script>
@endif
<script>
    progressively.init({
        delay: 0,
        throttle: 50,
        onLoadComplete: function() {}
    });

    function niceScroll() {
        $('[nice-scroll]').niceScroll({
            cursorcolor: "#707070",
            cursorwidth: "6px"
        });
    }
    niceScroll();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
        niceScroll();
    })

    // select2   
    $(document).ready(function() {
        $(".form-select").select2({
            minimumResultsForSearch: -1
        });
    });

    //ripple-effect for button
    $('.ripple-effect, .ripple-effect-dark').on('click', function(e) {
        var rippleDiv = $('<span class="ripple-overlay">'),
            rippleOffset = $(this).offset(),
            rippleY = e.pageY - rippleOffset.top,
            rippleX = e.pageX - rippleOffset.left;
        rippleDiv.css({
            top: rippleY - (rippleDiv.height() / 2),
            left: rippleX - (rippleDiv.width() / 2),
            // background: $(this).data("ripple-color");
        }).appendTo($(this));
        window.setTimeout(function() {
            rippleDiv.remove();
        }, 800);
    });

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 20) {
            $("header").addClass("lightHeader");
        } else {
            $("header").removeClass("lightHeader");
        }
    });



    $('#navbarBackdrop').click(function() {
        $('.navbar-collapse').collapse('hide');
    })
    //===================== video modal script====================
    $('#videoModal').on('shown.bs.modal', function() {
        $('#video1')[0].play();
    })
    $('#videoModal').on('hidden.bs.modal', function() {
        $('#video1')[0].pause();
    })

    $('.categoryDropdown').mouseenter(function() {
        $('.categoryDropdown__menu').css('display', 'flex');
        $('.dropdown.show').removeClass('show');
        $('.dropdown-menu.show').removeClass('show');
    })
    $('.categoryDropdown').mouseleave(function() {
        $('.categoryDropdown__menu').hide()
        $('#categoryDropdownSecond').hide();
        $('#categoryDropdownThird').hide();
    })

    $('.categoryDropdown__col--first ul li a').mouseenter(function() {
        $('#categoryDropdownSecond').show();
    })
    $('.categoryDropdown__col--second ul li a').mouseenter(function() {
        $('#categoryDropdownThird').show();
    })

    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
        }
        var $subMenu = $(this).next('.dropdown-menu');
        $subMenu.toggleClass('show');


        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass('show');
        });
        return false;
    });

    function searchToggle() {
        $('#search').toggle()
    }
    $.ajaxSetup({
        headers: {
            'time-zone': moment.tz.guess()
        }
    });

    $('#sideMenuToggle').on('click', function(){
        $('.sideMenu').addClass('show');
    });
    $('#closeMenu').on('click', function(){
        $('.sideMenu').removeClass('show');
    })

    $('#sideMenuToggle').on('click', function(){
        $('.commonSideBar').addClass('show');
    });

    $('#closeMenu').on('click', function(){
        $('.commonSideBar').removeClass('show');
    });

</script>