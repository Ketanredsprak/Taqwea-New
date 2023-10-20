<!DOCTYPE html>
<html lang="en-US" translate="no">
<head>
    <title>taqwea</title>
    @include('layouts.frontend.header-link')
</head>

<body> 
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
            <div class="paymentPage d-flex align-items-center justify-content-center vh-100">
                <div class="paymentPage__content text-center"> 
                    <img src="{{ asset('assets/images/payment-right.png') }}" class="img-fluid" alt="payment-right"> 
                    <h2 class="font-bd">{{__('labels.payment_successfully')}}</h2>
                   
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