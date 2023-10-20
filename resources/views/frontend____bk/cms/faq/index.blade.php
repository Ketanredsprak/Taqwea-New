@extends('layouts.frontend.app')
@section('title',__('labels.faq'))
@section('content')
<main class="mainContent {{ (@$_GET['contentOnly']) ? 'pt-0' : ''}}">
    <div class="faqPage innerHomePage">
        @if(!@$_GET['contentOnly'])
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.faq') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.faq') }}</h3>
            </div>
        </section>
        @endif
        <section class="faqPage__innerSec">
            <div class="container">
                <div id="faqs" class="accordion customAccordion">
                    {{ pageLoader() }}
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/cms/faq.js')}}"></script>
@endpush