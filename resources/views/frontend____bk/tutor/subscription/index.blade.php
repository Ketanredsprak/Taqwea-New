@extends('layouts.tutor.app')
@section('title',__('labels.subscription'))
@section('content')
<main class="mainContent">
    <div class="subscriptionPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="pageTitle__leftSide">
                        <div class="commonBreadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{ __('labels.home') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.subscription') }}</li>
                                </ol>
                            </nav>
                        </div>
                        <h3 class="h-32 pageTitle__title">{{ __('labels.subscription') }}</h3>
                    </div>
                </div>
        </section>
        <section class="subscriptionPage__inner">
            <div class="container">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
                </div>
                <div class="flexRow d-xl-flex">
                    <div class="column-1">
                        @include('layouts.tutor.side-bar')
                    </div>
                    <div class="column-2">
                        <div class="subscriptionPage__rightSideBox common-shadow bg-white">
                            <div class="common-tabs mb-3 mb-lg-4">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#newPlanSubscription">{{__('labels.new_plans')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#purchasedSubscription">{{__('labels.purchased_plans')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#topUp">{{__('labels.purchased_top_up')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="newPlanSubscription" role="tabpanel">
                                    <!-- New Subscription Plan List -->
                                </div>
                                <div class="tab-pane fade" id="purchasedSubscription" role="tabpanel">
                                    <div class="myTransactionsPage__table p-0">
                                        <div class="searchList common-table" nice-scroll>
                                            <div class="table-responsive" id="subscriptionList">
                                                <!-- //subscription list -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="topUp" role="tabpanel">
                                    @if($is_top_up)
                                    <div class="text-right add-btn">
                                        <button class="btn btn-primary purchaseTopUp">{{__('labels.purchase_top')}}</button>
                                    </div>
                                    @endif
                                    <div class="myTransactionsPage__table px-0 pb-0">
                                        <div class="searchList common-table" nice-scroll>
                                            <div class="table-responsive" id="topUpList">
                                                <!-- New Top Up Plan List -->
                                            </div>
                                        </div>
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
<div class="modal fade" id="transactionDetailModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
</div>
<div class="modal fade" id="purchaseTopUpModel" tabindex="-1" role="dialog" aria-hidden="true">
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/subscription.js')}}"></script>
<script>

</script>
@endpush