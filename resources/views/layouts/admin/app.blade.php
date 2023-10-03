<!DOCTYPE html>
<html lang="{{config('app.locale')}}" class="js" translate="no">

<head>
    <title>@yield('title') | {{config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('layouts.admin.head-link')
    @stack('css')
</head>

<body class="nk-body bg-lighter npc-default {{Auth::check() ? 'has-sidebar dashboard' : 'pg-auth'}}">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            @auth
            @include('layouts.admin.sidebar')
            @endauth
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap">
                <!-- main header @s -->
                @auth
                @include('layouts.admin.header')
                @else
                <div class="nk-wrap nk-wrap-nosidebar">
                    @endauth
                    <!-- main header @e -->
                    <!-- content @s -->
                    @yield('content')
                    <!-- content @e -->
                    <!-- footer @s -->
                    @include('layouts.admin.footer')
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