@php
if(Auth::check() && Auth::user()->isTutor()){
$layout = 'layouts.tutor.app';
}elseif(Auth::check() && Auth::user()->isStudent()){
$layout='layouts.student.app';
}
@endphp

@extends($layout)
@section('title',__('labels.my_transactions'))
@section('content')
<main class="mainContent">
    <div class="walletPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('student/dashboard')}}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.my_transactions') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.my_transactions') }}</h3>
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
                    @if(Auth::check() && Auth::user()->isTutor())
                            <div class="walletPage__Box">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="availableBox availableBox--one">
                                            <div class="availableBox__left d-md-flex align-items-center flex-wrap">
                                                <div class="availableBox__icon">
                                                    <img src="{{ asset('assets/images/available-balance.svg') }}" alt="available-balance">
                                                </div>
                                                <div class="availableBox__cnt">
                                                    <h6 class="title font-rg">{{__('labels.total_earning')}}</h6>
                                                    <div class="price font-eb"><span class="font-rg text-uppercase mr-1">{{__('labels.sar')}}</span>{{$total_paid_tutor}}</div>
                                                    <div class="totalPrice font-eb"><span class="font-rg  mr-1">{{__('labels.total_sales')}} -: {{__('labels.sar')}}</span>{{$total_sale}}</div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="availableBox availableBox--two">
                                            <div class="availableBox__left d-md-flex align-items-center flex-wrap">
                                                <div class="availableBox__icon">
                                                    <img src="{{ asset('assets/images/available-balance.svg') }}" alt="point-available">
                                                </div>
                                                <div class="availableBox__cnt">
                                                    <h6 class="title font-rg">{{ __('labels.total_payment_due')}}</h6>

                                                    <div class="price font-eb">{{__('labels.sar')}} {{$total_due}}</div>
                                                    <div class="totalPrice font-eb"><span class="font-rg  mr-1">{{__('labels.penalty_paid')}} -: {{__('labels.sar')}}</span>{{$currentFine}}</div>
                                                    <div class="totalPrice font-eb"><span class="font-rg  mr-1">{{__('labels.commission_paid')}} -: {{__('labels.sar')}}</span>{{$commission}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif
                    <div class="walletPage__table">
                            <div class="common-tabs mb-3 mb-lg-4">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link transactionType active" data-type="transaction" data-toggle="tab" href="#transactionHistory">{{ __('labels.transaction_history') }}</a>
                                    </li>
                                    @if(Auth::check() && Auth::user()->isTutor())
                                    <li class="nav-item">
                                        <a class="nav-link transactionType" data-type="payout" data-toggle="tab" href="#payoutHistory">{{ __('labels.payout_history') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="transactionHistory" role="tabpanel">
                                    <div class="searchList common-table" nice-scroll>
                                        <div class="table-responsive" id="transactionList">

                                        </div>
                                    </div>
                                </div>
                                @if(Auth::check() && Auth::user()->isTutor())
                                <div class="tab-pane fade" id="payoutHistory" role="tabpanel">
                                    <div class="searchList common-table" nice-scroll>
                                        <div class="table-responsive" id="payoutList">

                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                            <!-- <h3 class="h-24" id="mydesc">{{ __('labels.transaction_history') }}</h3>
                            <div class="searchList common-table" nice-scroll>
                                <div class="table-responsive" id="transactionList">

                                </div>
                            </div> -->
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
    var transactionLitUrl = "{{ route('tutor.transactions.list') }}";
    var payoutLitUrl = "{{ route('tutor.transactions.payout-list') }}";
</script>
@elseif(Auth::check() && Auth::user()->isStudent())
<script>
    var transactionLitUrl = "{{ route('student.transactions.list') }}";
</script>
@endif

<script type="text/javascript" src="{{asset('assets/js/frontend/transactions.js')}}"></script>
@endpush