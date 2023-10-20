@extends('layouts.student.app')
@section('title', 'Checkout')
@section('content')
<main class="mainContent">
    <div class="bookingPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('student/dashboard')}}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.booking') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.booking') }}</h3>
            </div>
        </section>
        <section class="bookingPageInner">
            <div class="container">
                <form action="" id="checkout-form">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="paymentCard">
                                <div class="paymentCard-Box common-shadow bg-white position-relative">
                                    <div class="paymentCard-Box_heading">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" value="direct_payment" name="payment_method" class="custom-control-input" {{ ($walletAmount>0)?'':'checked' }}>
                                            <label class="custom-control-label" for="customRadio1">
                                                <h4 class="font-eb mb-0">{{ __('labels.payment_by_card') }}</h4>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="paymentCard-Box_cards row" id="show-cards">

                                    </div>
                                    <div class="paymentCard-Box_payOption position-relative">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio3" value="new_card" name="payment_method" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio3">
                                                <h4 class="font-eb mb-0">{{ __('labels.new_card') }}</h4>
                                            </label>
                                        </div>
                                        <div class="wallet d-flex align-items-center">
                                            <div style="display: none" id="new-card-form">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.card_number') }}</label>
                                                    <input type="text" name="card_number" id="card-number" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.name_on_card') }}</label>
                                                    <input type="text" name="card_holder_name" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.card_brand') }}</label>
                                                    {!! getCardTypes() !!}
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col form-group mb-0">
                                                            <label class="form-label">{{ __('labels.expire_date') }}</label>
                                                            <input maxlength='7' type="text" name="expired_date" id="expired_date" class="form-control" placeholder="MM/YYYY">
                                                        </div>
                                                        <div class="col form-group mb-0">
                                                            <label class="form-label">{{ __('labels.cvv') }}</label>
                                                            <input type="text" name="cvv" class="form-control" placeholder="_ _ _">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="custom-control custom-checkbox">
                                                                <input name="is_card_save" value="1" type="checkbox" class="custom-control-input" id="is_card_save" aria-describedby="is_card_save-error">
                                                                <label class="custom-control-label" for="is_card_save">{{ __('labels.save_card') }}</label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="paymentCard-Box_payOption position-relative">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio2" value="wallet" name="payment_method" class="custom-control-input" {{ ($walletAmount>0)?'checked':'' }}>
                                            <label class="custom-control-label" for="customRadio2">
                                                <h4 class="font-eb mb-0">{{ __('labels.other_payment_methods') }}</h4>
                                            </label>
                                        </div>
                                        <div class="wallet d-flex align-items-center">
                                            <div class="wallet_icon"><em class="icon-wallet"></em></div>
                                            <div class="wallet_txt">
                                                <h5>{{ __('labels.wallet') }}</h5>
                                                <p class="mb-0 font-rg">{{ __('labels.sar') }}  <span class="font-bd">{{ number_format($walletAmount, 2) }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- card -->
                                <div class="paymentCard-orderTxt">
                                    <h4 class="font-eb mb-0">{{ __('labels.order_details') }} ({{ $totalItems }})</h4>
                                </div>
                                <div class="paymentCard-orderList">
                                    <ul class="list-unstyled commonList mb-0">
                                        @if($itemType != 'subscription')
                                        @forelse($items as $item)
                                        <li class="commonList-item common-shadow d-md-flex bg-white">
                                            <div class="commonList-item_img position-relative">
                                                @if($item->type=='blog')
                                                <img src="{{ $item->media_thumb_url }}" alt="list-image">
                                                @else
                                                <img src="{{ $item->class_image_url }}" alt="list-image">
                                                @endif
                                                @if(@$item->subject->subject_name)
                                                <span class="commonTag text-uppercase">{{ $item->subject->translateOrDefault()->subject_name }}</span>
                                                @endif
                                            </div>
                                            <div class="commonList-item_info">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="font-bd mb-0">
                                                        @if($item->type=='blog')
                                                        {{ $item->translateOrDefault()->blog_title }}
                                                        @else
                                                        {{ $item->translateOrDefault()->class_name }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                @if($item->type!='blog')
                                                <div class="my-3 txt" dir="{{config('constants.date_format_direction')}}"><span class="font-bd">{{ convertDateToTz($item->start_time, 'UTC', 'd M Y') }}</span> {{ convertDateToTz($item->start_time, 'UTC', 'h:i A') }} </div>
                                                @endif
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="price">
                                                            {{ __('labels.sar') }} 
                                                            <span class="font-eb">
                                                                @if($item->type=='blog')
                                                                {{ number_format($item->total_fees, 2) }}
                                                                @else
                                                                {{ (!empty($item->total_fees))? number_format($item->total_fees, 2): number_format(round(($item->duration/60)*$item->hourly_fees,2),2)}}
                                                                @endif
                                                            </span>
                                                        </div>
                                                        @if(!$item->is_available['success'])
                                                        <div class="textDanger font-bd ml-3">
                                                            <span>{{__('labels.invalid_item')}}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @if($bookingType == 'cart_booking')
                                                    <h6 class="delete mb-0">
                                                        <a href="javascript:void(0);" class="textGray" onclick="deleteItem({{ $cart->id }},{{ $item->cart_item_id }})">
                                                            <em class="icon-delete"></em> <span>{{__('labels.delete')}} </span>
                                                        </a>
                                                    </h6>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                        @empty
                                        <div class="row">
                                            <div class="alert-box">
                                                <div class="alert alert-danger">{{ __('labels.empty_cart') }}</div>
                                            </div>
                                        </div>
                                        @endforelse
                                        @endif
                                    </ul>
                                </div>
                                <div class="showLink">
                                    <!-- <a href="javascript:void(0);">SHOW MORE</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="paymentDetail">
                                <div class="paymentDetail-Box common-shadow bg-white position-relative">
                                    <h4 class="font-eb mb-0">{{ __('labels.payment_details') }}</h4>
                                    <div class="paymentDetail-Box_amount">
                                        <div class="txt mt-4 d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ __('labels.total') }}</h5>
                                            <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ number_format($itemTotal, 2) }}</span></p>
                                        </div>
                                        @if($itemType != 'subscription')
                                        <div class="txt d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ __('labels.vat') }} ({{ getSetting('vat') }}%)</h5>
                                            @php
                                            $vat = $itemTotal * (getSetting('vat')/100);
                                            @endphp
                                            <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ number_format($vat, 2) }}</span></p>
                                        </div>


                                        <div class="txt d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ __('labels.transaction_fee') }} ({{ getSetting('transaction_fee') }}%)</h5>
                                            @php
                                            $transactionFees = ($itemTotal+$vat) * (getSetting('transaction_fee')/100);
                                            @endphp
                                            <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ number_format($transactionFees, 2) }}</span></p>
                                        </div>
                                        @endif
                                        <div class="spaceBorder"></div>
                                        <div class="txt mt-4 d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ __('labels.total_amount') }}</h5>
                                            @php
                                            if($itemType != 'subscription') {
                                            $totalAmount = $itemTotal+$vat+$transactionFees;
                                            } else {
                                            $totalAmount = $itemTotal;
                                            }
                                            @endphp
                                            <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ number_format($totalAmount, 2) }}</span></p>
                                        </div>
                                       
                                    </div>
                                    <div class="paymentDetail-Box_dateContent">
                                        <div class="date d-flex align-items-center">
                                            <span class="dateSpace"><em class="icon-calender"></em></span>
                                            <div><span class="font-bd">{{ nowDate('d M Y') }}</span> {{ nowDate('h:i A') }}</div>
                                        </div>
                                        <div class="text-center mb-3">
                                            <a href="javascript:void(0);"><img src="{{ (app()->getLocale()=='ar')?asset('assets/images/card-img-ar.png'):asset('assets/images/card-img.png') }}" class="img-fluid" alt="card"></a>
                                        </div>
                                        <button class="btn btn-primary btn-block btn-lg ripple-effect" id="checkoutBtn" {{ (!$totalItems)?'disabled':'' }}>{{ __('labels.place_order') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="item-id" name="item_id" value="">
                    <input type="hidden" id="item-type" name="item_type" value="">
                    <input type="hidden" name="currency" value="{{config('app.currency.default')}}">
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Student\CheckoutRequest', '#checkout-form') !!}
            </div>
        </section>
    </div>
</main>
<!-- successfully message modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--successMsg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="paymentInfo text-center">
                    <h5>{{ __('labels.payment_successfully') }}</h5>
                    <p>{{ __('labels.your_payment_was_successful') }} <br class="d-none d-md-block">{{ __('labels.will_get_a_notification') }}
                        <br class="d-none d-md-block">{{ __('labels.sessions_starts') }}
                    </p>
                </div>
                <div class="paymentTxt text-center">
                    <div class="price font-rg">{{ __('labels.sar') }}  <span class="font-eb">{{ number_format($totalAmount, 2) }}</span></div>
                    <p class="mb-0">{{ nowDate('d M Y, h:i A') }}</p>
                    <p class="mb-0">{{ __('labels.transaction_id') }}: #<span id="transactionId"></span></p>
                    @if($itemType=='blog')
                    <a href="{{ route('blogs') }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.back_to_list') }}</a>
                    @elseif($itemType=='class')
                    <a href="{{ route('classes') }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.back_to_list') }}</a>
                    @elseif($itemType=='webinar')
                    <a href="{{ route('webinars') }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.back_to_list') }}</a>
                    @else
                    <a href="{{ route('home') }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.home') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    @if($itemType != 'subscription')
    var cardLitUrl = "{{ route('student.payment-method.list',['type' => 'checkout']) }}";
    @else
    var cardLitUrl = "{{ route('tutor.payment-method.list',['type' => 'checkout']) }}";
    @endif
    var bookingType = "{{ $bookingType }}";
    var walletAmount = parseInt("{{ $walletAmount }}");
    var totalAmount = parseInt("{{ $totalAmount }}");
    var Amount = parseInt('{{amount}}');
    if (bookingType == 'direct_booking') {
        var itemId = "{{ @$item->id }}";
        var itemType = "{{ (@$itemType=='blog')?'blog':'class' }}";
    } else {
        var itemId = '';
        var itemType = '';
    }
    $('#item-id').val(itemId);
    $('#item-type').val(itemType);
</script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/checkout.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/cart.js')}}"></script>
@endpush
@endsection