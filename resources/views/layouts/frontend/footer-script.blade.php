<!-- message modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--message">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group mb-0 messageInfo">
                        <label>Write Your Message</label>
                        <textarea dir="rtl" class="form-control">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam dad voluptua.</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0">
                <button type="submit" class="btn btn-primary bttn w-100 ripple-effect">Submit</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/frontend/frontend-app.js') }}"></script>
<script src="{{ asset('assets/js/messages.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/global-search.js')}}"></script>


<script >
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
})
</script>
