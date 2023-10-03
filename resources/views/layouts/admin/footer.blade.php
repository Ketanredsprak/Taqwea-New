@auth
<div class="nk-footer">
    <div class="container-fluid">
        <div class="nk-footer-wrap justify-content-center">
            <div class="nk-footer-copyright">© {{date('Y')}} All Rights Reserved.</div>
        </div>
    </div>
</div>
@endauth
@if($errors->any())
    <div class="alert alert-danger">
        <p><strong>Opps Something went wrong</strong></p>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
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
<script src="{{asset('assets/js/admin/admin-app.js')}}"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
@if(Auth::check())
<script>
    var apiKey = "{{ config('fcm.apiKey') }}"
    var projectId = "{{ config('fcm.project_id') }}"
    var senderId = "{{ config('fcm.http.sender_id') }}"
    var appId = "{{ config('fcm.app_id') }}"
    var userId = {{ Auth::user()->id }}
    var deviceId = "{{Auth::user()->device ? Auth::user()->device->device_id : ''}}";
    var swUrl = "{{asset('assets/firebase-messaging-sw.js')}}"
</script>
<script type="text/javascript" src="{{asset('assets/js/frontend/fcm-token.js')}}"></script>
@endif
