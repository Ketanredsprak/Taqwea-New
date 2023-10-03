<!-- Required meta tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta name="csrf-token" content="{{ csrf_token() }}" />


<!-- favicon -->
<link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/images/favicon/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('assets/images/favicon/site.webmanifest')}}">

<!-- StyleSheets  -->
<script src="{{asset('assets/js/admin/app.js')}}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/admin/admin-app.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/css/admin/taqwea.css') }}" type="text/css">
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
