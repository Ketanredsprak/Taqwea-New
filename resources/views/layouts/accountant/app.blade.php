<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=='ar')?'rtl':'ltr' }}" translate="no">

<head>
    <title>@yield('title') | {{config('app.name')}}</title>
    @include('layouts.accountant.head-link')
</head>

<body class="nk-body bg-lighter npc-default {{Auth::check() ? 'has-sidebar dashboard' : 'pg-auth'}} language-{{ (app()->getLocale()=='ar')?'arabic':'english' }}">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            @auth
            @include('layouts.accountant.sidebar')
            @endauth
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap">
                <!-- main header @s -->
                @auth
                @include('layouts.accountant.header')
                @else
                <div class="nk-wrap nk-wrap-nosidebar">
                @endauth
                <!-- main header @e -->
                <!-- content @s -->
                @yield('content')
                <!-- content @e -->
                <!-- footer @s -->
                @include('layouts.accountant.footer')
                @stack('scripts')
                <!-- footer @e -->
            </div>
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
</body>

</html>