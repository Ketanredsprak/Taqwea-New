@extends('layouts.student.app')
@section('title',__('labels.purchase_blog_video'))
@section('content')
<main class="mainContent">
    <div class="purchasedBlogVideosPage commonPad bg-green">
    <section class="pageTitle">
        <div class="container">
            <div class="commonBreadcrumb">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.purchase_blog_video') }}</li>
                </ol>
                </nav>
            </div>
            <h3 class="h-32 pageTitle__title">{{ __('labels.purchase_blog_video') }}</h3>
        </div>
    </section>
    <section class="purchasedBlogVideosPage__inner">
        <div class="container">
            <div class="d-flex align-items-center mb-3">
                <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
            </div>
            <div class="flexRow d-xl-flex">
                <div class="column-1">
                @include('layouts.student.side-bar')
                </div>
                <div class="column-2">
                <div class="purchasedBlogVideosPage__list" id="blogList">
                
                </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</main>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset('assets/js/frontend/student/blog.js')}}"></script>
@endpush