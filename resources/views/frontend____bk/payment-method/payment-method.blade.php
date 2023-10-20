@php
if(Auth::check() && Auth::user()->isTutor()){
$layout = 'layouts.tutor.app';
}elseif(Auth::check() && Auth::user()->isStudent()){
$layout = 'layouts.student.app';
}
@endphp
@extends($layout)
@section('title', 'Payment Method')
@push('css')
<style>
    input {
        font-size: 1.4em;
        font-weight: 100;
        padding: 0.3em;
        border-radius: 2px;
        border: 1px solid #ccc;

        &:focus {
            outline: none;
        }
    }
</style>
@endpush
@section('content')
<main class="mainContent">
    <div class="paymentMethodPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.payment_method') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.payment_method') }}</h3>
            </div>
        </section>
        <section class="paymentMethodPage__inner">
            <div class="container">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
                </div>
                <div class="flexRow d-xl-flex">
                    <div class="column-1">
                        @if(Auth::check() && Auth::user()->isTutor())
                        @include('layouts.tutor.side-bar')
                        @elseif(Auth::check() && Auth::user()->isStudent())
                        @include('layouts.student.side-bar')
                        @endif
                    </div>
                    <div class="column-2">
                        <div class="paymentCard">
                            <div class="paymentCard-Box common-shadow bg-white position-relative">
                                <h4 class="font-eb mb-0">{{__('labels.saved_card')}}</h4>
                                <div class="paymentCard-Box_cards row mx-0" id="show-card-id"> 
                                </div>
                                @if(Auth::check() && Auth::user()->isTutor())
                               <div class="paymentCard-Box_addNewCard">
                                    <h4 class="font-eb">{{__('labels.bank_details')}}</h4>
                                    <form action="{{ route('tutor.payment-method.bank-details')}}" method="post" id="addBankDetailForm">
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.beneficiary_name') }}</label>
                                                    <input type="text" name="beneficiary_name" id="beneficiary_name" class="form-control" placeholder="{{ __('labels.enter_beneficiary_name') }}" value="{{$tutor->beneficiary_name}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.iban_number') }}</label>
                                                    <input type="text" name="account_number"  id="account_number" class="form-control" placeholder="{{ __('labels.enter_iban_name') }}" value="{{$tutor->account_number}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.bank_name') }}</label>
                                                    <select name="bank_code" class="form-select select-bank-code"
                                                        data-placeholder="{{ __('labels.enter_bank_name') }}" onchange="getCode()" aria-describedby="bank_code-error">
                                                        <option value=""></option>
                                                        @foreach($banks as $bank)
                                                        <option value="{{$bank->bank_code}}" {{$bank->bank_code == $tutor->bank_code ? "selected": ''}}>
                                                            {{$bank->translateOrDefault()->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="bank_code-error" class="invalid-feedback"></span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.bank_code') }}</label>
                                                    <input type="text" name="code"  id="code" class="form-control" placeholder="{{ __('labels.enter_bank_code') }}" value="{{$tutor->bank_code}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.address') }}</label>
                                                    <input maxlength='7' type="text" name="address" id="address"
                                                        class="form-control"
                                                        placeholder="{{ __('labels.enter_address_name') }}"
                                                        value="{{$tutor->address}}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-7 addBtn mx-auto">
                                                <button type="submit" id="addBankDetailBtn" class="btn btn-primary btn-lg w-100 ripple-effect">{{__('labels.edit_bank_details')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                    {!! JsValidator::formRequest('App\Http\Requests\PaymentMethod\BankDetailRequest', '#addBankDetailForm') !!}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
@push('scripts')
@if(Auth::check() && Auth::user()->isTutor())
<script>
    var cardLitUrl = "{{ route('tutor.payment-method.list') }}";
    var indexUrl = "{{route('tutor.payment-method.index')}}";
    var bankNameUrl = "{{route('tutor.payment-method.bank-name')}}";
</script>
@elseif(Auth::check() && Auth::user()->isStudent())
<script>
    var cardLitUrl = "{{ route('student.payment-method.list') }}";
    var indexUrl = "{{route('student.payment-method.index')}}";
</script>
@endif
<script type="text/javascript" src="{{asset('assets/js/frontend/payment-method.js')}}"></script>
@endpush