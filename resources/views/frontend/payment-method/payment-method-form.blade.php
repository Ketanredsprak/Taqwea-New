<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="{{config('services.hyper_pay_api_url')}}/v1/paymentWidgets.js?checkoutId={{$checkoutId}}"></script>
<form action="http://localhost/taqwea/payment-method/return-url" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
<script>
    var wpwlOptions = {
    onReady: function() {
        var createRegistrationHtml = '<input type="text" name="createRegistration" value="true"/>';
        $('form.wpwl-form-card').find('.wpwl-button').before(createRegistrationHtml);
    }
}
</script>
