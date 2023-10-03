<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=='ar')?'rtl':'ltr' }}" translate="no">

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
    <title>@yield('title') | {{__('labels.app_name') }}</title>

    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#3B5C4A">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

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

    @include('layouts.tutor.header-link')

    <!-- child pages css -->
    @stack('css')
</head>

<body class="language-{{ (app()->getLocale()=='ar')?'arabic':'english' }}">
    <!-- header -->
    @if(!@$video_layout)
    @include('layouts.tutor.header')
    @endif
    <!-- main content -->
    @yield('content')
    
    <!-- footer -->
    @if(!@$video_layout)
    @include('layouts.tutor.footer')
    @endif

    <!-- footer scripts -->
    @include('layouts.tutor.footer-script')

    <!-- child pages scripts -->
    @stack('scripts')

</body>

</html>