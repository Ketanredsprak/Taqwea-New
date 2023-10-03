<header class="header fixed-top">
    <nav class="navbar navbar--home navbar-expand-lg py-0">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo-frontend.png') }}" class="img-fluid" alt="Logo" />
        </a>

        @if(!Auth::check())
        <div class="authLinks order-3 order-lg-4 align-items-center d-flex">
            <a class="btn btn-primary ripple-effect btn-login" href="{{ route('show/login') }}">{{ __('labels.login') }}</a>
            <a class="btn btn-info ripple-effect" href="{{ route('show/signup') }}">{{ __('labels.sign_up') }}</a>
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navCollapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </button>
        </div>
        @endif



        <div class="collapse navbar-collapse order-4 order-lg-3" id="navCollapse">
            <ul class="navbar-nav ml-auto align-items-center">
                @if(!Auth::check())
                <li class="nav-item active">
                    <a class="nav-link {{ ( Request::is('/')) ? 'active' : '' }}"  href="{{ route('home') }}">{{ __('labels.home') }}</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ ( Request::is('classes')) ? 'active' : '' }}" href="{{ url('classes') }}">{{ __('labels.online_classes') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (Request::is('webinars') ) ? 'active' : '' }}" href="{{ url('webinars') }}">{{ __('labels.webinars') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ( Request::is('blogs') ) ? 'active' : '' }}" href="{{ url('blogs') }}">{{ __('labels.blogs') }}</a>
                </li>
                <li class="nav-item nav-item--lang">
                    @php
                    $languages = getLanguages();
                    $locale = App::getLocale();
                    @endphp
                    <select class="form-select" id="changeLanguage">
                        @forelse($languages as $language)
                        <option value="{{ $language->code }}" {{ ($locale==$language->code)?'selected':''}}>{{ strtoupper($language->code) }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="nav-item nav-item--border">
                </li>
            </ul>
        </div>
        <div class="navbar-backdrop" id="navbarBackdrop"></div>

        @if(Auth::check())
        <div class="order-3 order-lg-4 align-items-center d-flex">
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navCollapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </button>
            <ul class="navbar-nav ml-auto align-items-center">
                @if(Auth::user()->isTutor())
                @include('layouts.tutor.header-menu')
                @elseif(Auth::user()->isStudent())
                @include('layouts.student.header-menu')
                @endif
            </ul>
        </div>
        @endif
    </nav>
</header>
@push('scripts')
<script >
    var setLanguageUrl = "{{ route('setLanguage') }}";
</script>
@endpush