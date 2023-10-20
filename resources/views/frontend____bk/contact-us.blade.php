@extends('layouts.frontend.app')
@section('title',__('labels.contact_support'))
@section('content')
<main class="mainContent">
<div class="contactPage commonPad bg-green">
    <section class="pageTitle">
        <div class="container">
            <div class="commonBreadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('labels.home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('labels.contact_support')}}</li>
                    </ol>
                </nav>
            </div>
            <h3 class="h-32 pageTitle__title">{{__('labels.contact_support')}}</h3>
        </div>
    </section>
    <div class="container">
        <div class="contactForm common-shadow">
            <div class="contactForm-inner">
                <form id="contact-us-form" action="{{route('contact-submit')}}" method="post">
                    <div class="form-group">
                        <label class="form-label">{{__('labels.name')}}</label>
                        <input type="text"  dir="rtl" class="form-control" name="name" placeholder="{{__('labels.enter_name')}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{__('labels.email_id')}}</label>
                        <input type="text" dir="rtl" class="form-control" name="email" placeholder="{{__('labels.enter_email_id')}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{__('labels.description')}}</label>
                        <textarea class="form-control" dir="rtl" rows="6" name="message" placeholder="{{__('labels.enter_description')}}"></textarea>
                    </div>
                    <button id="contact-submit" class="btn btn-primary ripple-effect btn-lg btn-block submit">{{__('labels.submit')}}</button>
                    {!! JsValidator::formRequest('App\Http\Requests\Frontend\ContactUsRequest', '#contact-us-form') !!}
                </form>
            </div>                    
        </div>
    </div>
</div>
</main>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/contact-us/index.js')}}"></script>
@endpush