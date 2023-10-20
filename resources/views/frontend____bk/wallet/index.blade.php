@php
if(Auth::check() && Auth::user()->isTutor()){
$layout = 'layouts.tutor.app';
}elseif(Auth::check() && Auth::user()->isStudent()){
$layout = 'layouts.student.app';
}
@endphp

@extends($layout)
@section('title', 'Wallet')
@section('content')
<main class="mainContent">
    <div class="walletPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.wallet')}}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.wallet')}}</h3>
            </div>
        </section>
        <section class="walletPage__inner">
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
                        <div class="walletPage__content common-shadow bg-white p-30">
                            <div class="walletPage__Box">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="availableBox availableBox--one d-md-flex align-items-center justify-content-between">
                                            <div class="availableBox__left d-md-flex align-items-center flex-wrap">
                                                <div class="availableBox__icon">
                                                    <img src="{{ asset('assets/images/available-balance.svg') }}" alt="available-balance">
                                                </div>
                                                <div class="availableBox__cnt">
                                                    <h6 class="title font-rg">{{__('labels.available_balance')}}</h6>
                                                    <div class="price font-eb"><span class="font-rg text-uppercase mr-1">{{__('labels.sar')}}</span>{{ number_format($availableBalance, 2) }}</div>
                                                </div>
                                            </div>
                                            <div class="availableBox__btnSec">
                                                <button class="btn btn-primary ripple-effect" onclick="addAmountModal()">+{{ __('labels.add_amount')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="availableBox availableBox--two d-md-flex align-items-center justify-content-between">
                                            <div class="availableBox__left d-md-flex align-items-center flex-wrap">
                                                <div class="availableBox__icon">
                                                    <img src="{{ asset('assets/images/point-available.svg') }}" alt="point-available">
                                                </div>
                                                <div class="availableBox__cnt">
                                                    <h6 class="title font-rg">{{ __('labels.point_available')}}</h6>
                                                    <div class="price font-eb">{{ $availablePoints }}</div>
                                                </div>
                                            </div>
                                            <div class="availableBox__btnSec">
                                                <button class="btn btn-primary ripple-effect" onclick="redeemPointModal()" {{$availablePoints ? "" : "disabled"}}>{{__('labels.redeem')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="walletPage__table">
                                <h3 class="h-24">{{ __('labels.transaction_history') }}</h3>
                                <div class="searchList common-table" nice-scroll>
                                    <div class="table-responsive" id="transactionList">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>{{ __('labels.transaction_id')}}</th>
                                                    <th>{{ __('labels.name') }}</th>
                                                    <th>{{ __('labels.purpose') }}</th>
                                                    <th>{{ __('labels.date_time') }}</th>
                                                    <th>{{ __('labels.amount') }}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@include('frontend.wallet.add-amount-modal')
@include('frontend.wallet.redeem-amount-modal')
@endsection
@push('scripts')
@if(Auth::check() && Auth::user()->isTutor())
<script >
    var walletLitUrl = "{{ route('tutor.wallet.list') }}";
</script>
@elseif(Auth::check() && Auth::user()->isStudent())
<script >
    var walletLitUrl = "{{ route('student.wallet.list') }}";
</script>
@endif

<script type="text/javascript" src="{{asset('assets/js/frontend/wallet.js')}}"></script>
@endpush