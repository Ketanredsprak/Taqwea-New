@php
if(Auth::check() && Auth::user()->isTutor()){
$layout = 'layouts.tutor.app';
$wallet = route('tutor.wallet.index');
$cardListUrl = route('tutor.payment-method.list',['type' => 'checkout']);
}elseif(Auth::check() && Auth::user()->isStudent()){
$layout = 'layouts.student.app';
$wallet = route('student.wallet.index');
$cardListUrl = route('student.payment-method.list',['type' => 'checkout']);
}
@endphp

@extends($layout)

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
                <form action="javascript:void(0)" method="post" id="checkout-form" novalidate>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="paymentCard">
                                <div class="paymentCard-Box common-shadow bg-white position-relative">
                                    <div class="paymentCard-Box_heading row no-gutters align-items-center">
                                        <div class="custom-control custom-radio col-md-6">
                                            <input type="radio" id="customRadio1" value="direct_payment" name="payment_method" class="custom-control-input" {{ ($walletAmount>0)?'':'checked' }} {{ ($itemType == 'wallet')?'checked':'' }}>
                                            <label class="custom-control-label" for="customRadio1">
                                                <h4 class="font-eb mb-0">{{ __('labels.payment_by_card') }}</h4>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="card_type" id="select_card" class="form-select" aria-describedby="select_card-error" data-placeholder="{{__('labels.select_card')}}">
                                                <option value="" >{{__('labels.select_card')}}</option>
                                                <option value="MADA">{{__('labels.mada')}}</option>
                                                <option value="VISA">{{__('labels.vish')}}</option>
                                                <option value="MASTER">{{__('labels.mastercard')}}</option>
                                                
                                            </select>
                                            <span id="select_card-error" class="invalid-feedback"></span>
                                        </div>
                                    </div>

                                    @if($itemType != 'wallet')
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
                                                <p class="mb-0 font-rg">{{ __('labels.sar') }}  <span class="font-bd">{{ formatAmount($walletAmount) }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <!-- card -->
                                <div class="paymentCard-orderTxt">
                                    <h4 class="font-eb mb-0">{{ __('labels.order_details') }} ({{ $totalItems }})</h4>
                                </div>
                                <div class="paymentCard-orderList">
                                    <ul class="list-unstyled commonList mb-0">
                                        @if($itemType != 'subscription')
                                        @if($itemType == 'wallet')
                                        <li class="commonList-item common-shadow d-md-flex bg-white">
                                            <div class="commonList-item_info">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="font-bd mb-0">
                                                        {{ __('labels.amount_to_be_added') }}
                                                    </h5>

                                                </div>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="price">
                                                        {{ __('labels.sar') }} 
                                                            <span class="font-eb">
                                                                {{$itemTotal}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @elseif($itemType == 'topUp')
                                        @foreach($items as $item)
                                        <li class="commonList-item common-shadow d-md-flex bg-white">
                                            <div class="commonList-item_info">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="font-bd mb-0">
                                                        {{__('labels.top_up_be_purchased')}}
                                                    </h5>
                                                </div>
                                                @if($class_hours)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{__('labels.purchase_class_hours', ["hours" => $class_hours])}}
                                                </div>
                                                @endif
                                                @if($webinar_hours)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{__('labels.purchase_webinar_hours', ["hours" => $webinar_hours])}}
                                                </div>
                                                @endif
                                                @if($blog_count)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{__('labels.purchase_blog_count', ["count"=> $blog_count])}}
                                                </div>
                                                @endif
                                                @if($is_featured)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{__('labels.featured_days', ["days"=> $is_featured])}}
                                                </div>
                                                @endif
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="price">
                                                        {{ __('labels.sar') }} 
                                                            <span class="font-eb">
                                                                {{$itemTotal}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                        @else
                                        @forelse($items as $item)
                                        <li class="commonList-item common-shadow d-md-flex bg-white">
                                            <div class="commonList-item_img position-relative">
                                                @if($item->item_type=='blog')
                                                <img src="{{$item->media_thumb_url}}" alt="list-image">
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
                                                        @if($item->item_type=='blog')
                                                        {{ $item->translateOrDefault()->blog_title }}
                                                        @else
                                                        {{ $item->translateOrDefault()->class_name }}
                                                        @endif
                                                    </h5>
                                                    <span class="txtName textGray">
                                                        @if($item->item_type=='blog')
                                                        {{ __('labels.blog') }}
                                                        @elseif($item->item_type=='class')
                                                        {{ __('labels.class') }}
                                                        @elseif($item->item_type=='webinar')
                                                        {{ __('labels.webinar') }}
                                                        @endif
                                                    </span>
                                                </div>
                                                @if($item->item_type!='blog')
                                                <div class="my-3 txt" dir="{{config('constants.date_format_direction')}}"><span class="font-bd">{{ convertDateToTz($item->start_time, 'UTC', 'd M Y') }}</span> {{ convertDateToTz($item->start_time, 'UTC', 'h:i A') }} </div>
                                                @endif
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="price">
                                                            {{ __('labels.sar') }} 
                                                            <span class="font-eb">
                                                                @if($item->item_type=='blog')
                                                                {{ formatAmount($item->total_fees) }}
                                                                @elseif($item->total_fees)
                                                                {{ formatAmount($item->total_fees)}}
                                                                @elseif($item->hourly_fees)
                                                                {{ formatAmount($item->hourly_fees * ($item->duration/60))}}
                                                                @endif
                                                            </span>
                                                        </div>
                                                        @if(!$item->is_available['success'])
                                                        <div class="textDanger font-bd ml-3">
                                                            <span>{{$item->is_available['message']}}</span>
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
                                            <div class="col-12">
                                                <div class="alert alert-danger">{{ __('labels.empty_cart') }}</div>
                                            </div>
                                        </div>
                                        @endforelse
                                        @endif
                                        @else
                                        @foreach($items as $item)
                                        <li class="commonList-item common-shadow d-md-flex bg-white">
                                            <div class="commonList-item_info">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="font-bd mb-0">
                                                        {{$item->subscription_name}}
                                                    </h5>

                                                </div>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="price">
                                                            {{ __('labels.sar') }} 
                                                            <span class="font-eb">
                                                                {{number_format($itemTotal, 2)}}
                                                            </span>
                                                        </div>

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
                                        @endforeach
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
                                            <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ formatAmount($itemTotal) }}</span></p>
                                        </div>

                                        <div class="txt d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ __('labels.vat') }} ({{ $itemType == 'wallet' ? 0 : getSetting('vat') }}%)</h5>
                                            @php
                                            $vat = formatAmount($itemTotal * (($itemType == 'wallet' ? 0 : getSetting('vat'))/100));
                                            @endphp
                                            <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ $vat }}</span></p>
                                        </div>


                                        <div class="txt d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ __('labels.transaction_fee') }} ({{ $itemType == 'wallet' ? 0 : getSetting('transaction_fee') }}%)</h5>
                                            @php
                                            $transactionFees = formatAmount(($itemTotal+$vat) *( $itemType == 'wallet' ? 0 :(getSetting('transaction_fee')/100)));
                                            @endphp
                                            <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ $transactionFees }}</span></p>
                                        </div>

                                        <div class="spaceBorder"></div>
                                        <div class="txt mt-4 d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ __('labels.total_amount') }}</h5>
                                            @php
                                            $totalAmount = formatAmount($itemTotal + $vat + $transactionFees);
                                            @endphp
                                            <p class="font-rg mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{ $totalAmount }}</span></p>
                                        </div>
                                    </div>
                                    <div class="paymentDetail-Box_dateContent">
                                        <div class="date d-flex align-items-center">
                                            <span class="dateSpace"><em class="icon-calender"></em></span>
                                            <div><span class="font-bd">{{ nowDate('d M Y') }}</span> {{ nowDate('h:i A') }}</div>
                                        </div>
                                        <div class="text-center mb-3">
                                        <a href="javascript:void(0);"><img src="{{ (app()->getLocale()=='ar') ? asset('assets/images/card-img-ar.png') : asset('assets/images/card-img.png') }}" class="img-fluid" alt="card"></a>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block btn-lg ripple-effect" id="checkoutBtn" {{ (!$totalItems)?'disabled':'' }}>{{ __('labels.place_order') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="item-id" name="item_id" value="">
                    <input type="hidden" id="item-type" name="item_type" value="">
                    <input type="hidden" name="currency" value="{{config('app.currency.default')}}">
                    <input type="hidden" name="amount" id='item-amount' value="">
                    <input type="hidden" name="duration" id='item-duration' value="">
                    <input type="hidden" name="class_hours" id='item-class-hours' value="{{@$class_hours}}">
                    <input type="hidden" name="webinar_hours" id='item-webinar-hours' value="{{@$webinar_hours}}">
                    <input type="hidden" name="blog_count" id='item-blog-count' value="{{@$blog_count}}">
                    <input type="hidden" name="is_featured" id='item-is_featured' value="{{@$is_featured}}">
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Student\CheckoutRequest', '#checkout-form') !!}
            </div>
        </section>
    </div>
</main>
<!-- successfully message modal -->
<div class="modal fade" id="successModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--successMsg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="paymentInfo text-center">
                    <h5>{{ __('labels.payment_successfully') }}</h5>
                    @if($itemType == 'class')
                    <p>{{ __('labels.your_payment_was_successful') }} <br class="d-none d-md-block">{{ __('labels.will_get_a_notification') }}
                        <br class="d-none d-md-block">{{ __('labels.sessions_starts') }}
                    </p>
                    @endif
                </div>
                <div class="paymentTxt text-center">
                    <div class="price font-rg">{{ __('labels.sar') }}  <span class="font-eb">{{ $totalAmount }}</span></div>
                    <p class="mb-0">{{ nowDate('d M Y, h:i A') }}</p>
                    <p class="mb-0">{{ __('labels.transaction_id') }}: #<span id="transactionId"></span></p>
                    @if($itemType=='blog')
                    <a href="{{ route('blogs') }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.back_to_list') }}</a>
                    @elseif($itemType=='class')
                    <a href="{{ route('classes') }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.back_to_list') }}</a>
                    @elseif($itemType=='webinar')
                    <a href="{{ route('webinars') }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.back_to_list') }}</a>
                    @elseif($itemType=='subscription' || $itemType =='topUp')
                    <a href="{{ route('tutor.subscription.index') }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.back_to_list') }}</a>
                    @elseif($itemType=='wallet')
                    <a href="{{ $wallet }}" class="btn btn-primary font-bd ripple-effect">{{ __('labels.back_to_list') }}</a>
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
    var itemTotal = "";
    var duration = "";
    var cardLitUrl = "{{$cardListUrl}}";
    var bookingType = "{{ !empty($bookingType) ?  $bookingType : '' }}";
    var walletAmount = parseFloat("{{ $walletAmount }}");
    var totalAmount = parseFloat("{{ $totalAmount }}");
    @if($itemType != 'subscription' && $itemType != 'wallet' && $itemType != 'topUp')
    if (bookingType == 'direct_booking') {
        var itemId = "{{ @$item->id }}";
        var itemType = "{{ (@$itemType=='blog')?'blog':'class' }}";
    } else {
        var itemId = '';
        var itemType = '';
    }
    @else
    var itemId = "{{ @$item->id }}";
    var itemType = "{{ @$itemType }}";
    itemTotal = "{{ @$itemTotal }}";
    duration = "{{ @$duration }}";
    @endif
    $('#item-id').val(itemId);
    $('#item-type').val(itemType);
    $('#item-amount').val(itemTotal);
    $('#item-duration').val(duration);

   let icons = {
    "{{__('labels.mada')}}": "{{ asset('assets/images/p-mada.png') }}",   
    "{{__('labels.vish')}}": "{{ asset('assets/images/p-visa.png') }}", 
    "{{__('labels.mastercard')}}": "{{ asset('assets/images/p-master.png') }}"
    } 
 
</script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/checkout.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/cart.js')}}"></script>
@endpush
@endsection