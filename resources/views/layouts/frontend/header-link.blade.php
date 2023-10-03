<!-- favicon -->
<link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/images/favicon/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon/favicon-16x16.png')}}">

<script src="{{asset('assets/js/frontend/app.js')}}"></script>

<link href="{{ asset('assets/css/frontend/frontend-app.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/frontend/common.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/frontend/frontend.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@if (!Session::get('timezone'))
<script >
    var url = "{{ url('/') }}" + '/set-timezone';
    $.ajax({
        method: "GET",
        url: url,
        headers: {
            'time-zone': moment.tz.guess()
        },
        async: false,
        //data: {},
        success: function(response) {
            if (response.success) {
                sessionStorage.setItem("timezone", response.data.timezone);
            }
        },
        error: function(response) {},
    });
</script>
@endif