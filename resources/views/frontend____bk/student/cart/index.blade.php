@extends('layouts.student.app')
@section('title',__('labels.cart'))
@section('content')
<main class="mainContent">
    <div class="cartPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('student/dashboard')}}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.cart') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.cart') }}</h3>
            </div>
        </section>
        <section class="cartPageInner">
            <div class="container">
                <h4 class="textGray font-sm"> <span id="cartItemCount">{{ (@$cart->items)?@$cart->items->count():'0' }}</span> {{ (@$cart->items)?((@$cart->items->count() <= 1)?__('labels.item_in_cart') : __('labels.items_in_cart')):__('labels.item_in_cart')}}</h4>
                <div class="row">
                    <div class="col-md-8">
                        <div class="cartList">
                            <div class="cartList-orderList">
                                <ul class="list-unstyled commonList mb-0">
                                    @php $itemTotal = 0; @endphp
                                    @if(@$cart->items)
                                    @forelse(@$cart->items as $item)

                                    @if(!empty(@$item->classWebinar))
                                    @php $itemPrice = 0; @endphp
                                    @if(@$item->classWebinar->total_fees)
                                    <!-- Show If item type is class -->
                                    @php 
                                        $itemTotal = $itemTotal + $item->classWebinar->total_fees; 
                                        $itemPrice = $item->classWebinar->total_fees;
                                    @endphp
                                    @elseif($item->classWebinar->hourly_fees)
                                    @php 
                                        $itemPrice = $item->classWebinar->hourly_fees * ($item->classWebinar->duration/60);
                                        $itemTotal = $itemTotal + ($item->classWebinar->hourly_fees * ($item->classWebinar->duration/60) ); 
                                    @endphp
                                    @endif

                                    <li class="commonList-item common-shadow d-md-flex bg-white" id="item-{{ $item->id }}">
                                        <div class="commonList-item_img position-relative">
                                            <img src="{{ $item->classWebinar->class_image_url }}" alt="class-image">
                                            @if(@$item->classWebinar->subject->subject_name)
                                            <span class="commonTag text-uppercase">{{ @$item->classWebinar->subject->translateOrDefault()->subject_name }}</span>
                                            @endif
                                        </div>
                                        <div class="commonList-item_info">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="font-bd mb-0">{{ $item->classWebinar->translateOrDefault()->class_name }}</h5>
                                                <span class="txtName textGray"> {{ (ucfirst($item->classWebinar->class_type) == 'Class'? __('labels.class'):__('labels.webinar')) }} </span>
                                            </div>
                                            <div class="my-3 txt" dir="{{config('constants.date_format_direction')}}">
                                                <span class="font-bd">
                                                    {{ convertDateToTz($item->classWebinar->start_time, 'UTC', 'd M Y') }}
                                                </span>
                                                {{ convertDateToTz($item->classWebinar->start_time, 'UTC', 'h:i A') }}
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="price">
                                                    {{ __('labels.sar') }} 
                                                    <span class="font-eb">
                                                        {{formatAmount($itemPrice) }}
                                                    </span>
                                                </div>
                                                @if(!$item->is_available['success'])
                                                <div class="textDanger font-bd ml-3">
                                                    <span>{{$item->is_available['message']}}</span>
                                                </div>
                                                @endif
                                                <h6 class="delete mb-0">
                                                    <a href="javascript:void(0);" class="textGray" onclick="deleteItem({{ $cart->id }},{{ $item->id }})">
                                                        <em class="icon-delete"></em> <span>{{ __('labels.delete') }} </span>
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                    @elseif(@$item->blog)
                                    <!-- Show If item type is blog -->
                                    @php $itemTotal = $itemTotal + $item->blog->total_fees; @endphp

                                    <li class="commonList-item common-shadow d-md-flex bg-white" id="item-{{ $item->id }}">
                                        <div class="commonList-item_img position-relative">
                                            <img src="{{ $item->blog->media_thumb_url }}" alt="blog-image">
                                            @if(@$item->blog->subject->subject_name)
                                            <span class="commonTag text-uppercase">{{ @$item->blog->subject->translateOrDefault()->subject_name }}</span>
                                            @endif
                                        </div>
                                        <div class="commonList-item_info">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="font-bd mb-0">{{ $item->blog->translateOrDefault()->blog_title }}</h5>
                                                <span class="txtName textGray"> {{ __('labels.blog') }} </span>
                                            </div>
                                            <div class="my-3 txt"></div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="price">{{ __('labels.sar') }}  <span class="font-eb">{{ formatAmount($item->blog->total_fees) }}</span></div>
                                                <h6 class="delete mb-0">
                                                    <a href="javascript:void(0);" class="textGray" onclick="deleteItem({{ $cart->id }},{{ $item->id }})">
                                                        <em class="icon-delete"></em> <span>{{ __('labels.delete') }} </span>
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                    @endif

                                    @empty
                                    @endforelse
                                    @else
                                    <li class="commonList-item common-shadow d-md-flex bg-white">
                                        <div class="col-12 p-0">
                                            <div class="alert alert-danger">{{ __('labels.empty_cart') }}</div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if(@$cart->items && count(@$cart->items))
                    <div class="col-md-4">
                        <div class="paymentDetail">
                            <div class="paymentDetail-Box common-shadow bg-white position-relative">
                                <h4 class="font-eb mb-0">{{ __('labels.payment_details') }}</h4>
                                <div class="paymentDetail-Box_amount">
                                    <div class="txt d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ __('labels.subtotal') }}</h5>
                                        <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ formatAmount($itemTotal) }}</span></p>
                                    </div>
                                    <div class="txt d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ __('labels.vat') }} ({{ getSetting('vat') }}%)</h5>
                                        @php
                                        $vat = formatAmount($itemTotal * (getSetting('vat')/100));
                                        @endphp
                                        <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ $vat }}</span></p>
                                    </div>
                                    <div class="txt d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ __('labels.transaction_fee') }} ({{ getSetting('transaction_fee') }}%)</h5>
                                        @php
                                        $transactionFees = formatAmount(($itemTotal+$vat) * (getSetting('transaction_fee')/100));
                                        @endphp
                                        <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ $transactionFees }}</span></p>
                                    </div>
                                    <div class="spaceBorder"></div>
                                    <div class="txt mt-4 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ __('labels.total_payable_amount') }}</h5>
                                        @php $totalAmount = formatAmount($itemTotal+$vat+$transactionFees) @endphp
                                        <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ $totalAmount }}</span></p>
                                    </div>
                                </div>
                                <a href="{{ route('student.checkout.index') }}" class="btn btn-primary btn-block btn-lg ripple-effect">{{ __('labels.proceed_to_checkout') }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/student/cart.js')}}"></script>
@endpush