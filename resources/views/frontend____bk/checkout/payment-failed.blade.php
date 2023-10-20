<!DOCTYPE html>
<html lang="{{config('app.locale')}}" dir="{{ (app()->getLocale()=='ar')?'rtl':'ltr' }}" translate="no">
<head>
    <title>taqwea | Sign Up</title>
    @include('layouts.frontend.header-link')
</head>

<body> 
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
            <div class="paymentPage d-flex align-items-center justify-content-center vh-100">
                <div class="paymentPage__content text-center"> 
                    <img src="{{ asset('assets/images/failed-payment.png') }}" class="img-fluid" alt="failed-payment"> 
                    
                   @if($select_brand != 'MADA' && $select_brand != $response_brand)
                   <h6 class="font-bd">{{__('error.payment_failed')}}</h6>
                   @else
                   <h2 class="font-bd">{{__('labels.payment_failed')}}</h2>
                   @endif
                    <div class="paymentLoader">
                    <img src="{{ asset('assets/images/payment-loader.gif') }}" class="img-fluid" alt="payment-loaderh">  
                    </div>
                </div> 
            </div> 
            </div>
        </div>
    </div>
</body>

<script>
    var url = '{{$url}}';
</script>
<script type="text/javascript" src="{{asset('assets/js/frontend/payment-success-failed.js')}}"></script>
</html>