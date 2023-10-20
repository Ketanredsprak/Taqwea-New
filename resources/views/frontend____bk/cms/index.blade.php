@extends('layouts.frontend.app')
@section('title', $cms->page_title)
@section('meta-title', $cms->meta_title)
@section('meta-description', $cms->meta_description)
@section('meta-keywords', $cms->meta_keywords)
@section('content')
<main class="mainContent {{ (@$_GET['contentOnly']) ? 'pt-0' : ''}}">
    <div class="cmsPage innerHomePage">
    @if(!@$_GET['contentOnly'])
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $cms->translateOrDefault()->page_title }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ $cms->translateOrDefault()->page_title }}</h3>
            </div>
        </section>
        @endif
        <section class="cmsPage__innerSec">
            <div class="container">
                {!! $cms->translateOrDefault()->page_content !!}
            </div>
        </section>
    </div>
</main>
@endsection
@push('scripts')
@endpush