<!DOCTYPE html>
<html lang="{{config('app.locale')}}" dir="{{ (app()->getLocale()=='ar')?'rtl':'ltr' }}" translate="no">

<head>
    
@if (config('services.google_analytics_enabled'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{config('services.google_analytics_key')}}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){window.dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{config("services.google_analytics_key")}}');
    </script>
@endif

    <title>@yield('title') |  {{ __('labels.app_name')}}</title>

    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#3B5C4A">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="title" content="@yield('meta-title')">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">

    <!---------twitter-------------->
    <meta name="twitter:title" content="@yield('meta-title-facebook')">
    <meta name="twitter:description" content="@yield('meta-description-facebook')">
    <meta name="twitter:image" content="@yield('meta-image-facebook')">
    <!-----------facebook sharing------->
    <meta property="og:type" content="article" />
    <meta name="og:title" content="@yield('meta-title-facebook')">
    <meta name="og:description" content="@yield('meta-description-facebook')">
    <meta name="og:image" content="@yield('meta-image-facebook')">
    <meta property="og:url" content="@yield('meta-keywords-url')" />

    @include('layouts.frontend.header-link')

    <!-- child pages css -->
    @stack('css')
</head>

<body class="language-{{ (app()->getLocale()=='ar')?'arabic':'english' }}">
    <!-- header -->
    @if(!@$_GET['contentOnly'])
        @if (Auth::check() && Auth::user()->isStudent())
            @include('layouts.student.header')
        @elseif (Auth::check() && Auth::user()->isTutor())
            @include('layouts.tutor.header')
        @else
            @include('layouts.frontend.header')
        @endif
    @endif

    <!-- main content -->
    @yield('content')

    <!-- footer -->
    @if(!@$_GET['contentOnly'])
    @include('layouts.frontend.footer')
    @endif
    <!-- footer scripts -->
    @include('layouts.frontend.footer-script')

    <!-- child pages scripts -->
    @stack('scripts')
</body>

</html>