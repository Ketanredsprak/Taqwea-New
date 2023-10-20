<!DOCTYPE html>
<html  lang="{{config('app.locale')}}" dir="{{ (app()->getLocale()=='ar')?'rtl':'ltr' }}" translate="no">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <head>
        <title>{{config('app.name')}}</title>
       @include('layouts.frontend.header-link')
         <style>
            body { background-color:#f6f6f5; }
            .dots { margin-left: 4px; }
            .dots-hidden { display: none; }

            .wpwl-wrapper :not(.wpwl-control-cardHolder):not(.customLabel){direction:ltr;}
            body.language-arabic .cardPaymentPage .cardPayment .wpwl-form .wpwl-brand-card-logo{
               right: 150px;
               left:auto;
            }
            @media (max-width: 480px) {
               body.language-arabic .cardPaymentPage .cardPayment .wpwl-form .wpwl-brand-card-logo{
               right: 0;
               }
               .cardPaymentPage .cardPayment .wpwl-form .wpwl-brand-card-logo{
                  top:38px;
               }

            }
        </style>
   </head>
   <body class="language-{{ (app()->getLocale()=='ar')?'arabic':'english' }}">
      <div class="cardPaymentPage">
          <!-- header -->
         <header class="header card-header">
            <nav class="navbar navbar-expand-lg border-0 py-0">
               <div class="container">
                  <a class="navbar-brand" href="#">
                  <img src="{{ asset('assets/images/logo-frontend.png')}}" class="img-fluid" alt="logo"/>
                  </a>
               </div>
            </nav>
         </header>

         <!-- payment content -->
         <div class="cardPayment bg-green">
            <form action="{{route('checkout.returnUrl')}}" class="paymentWidgets" data-brands="VISA MAESTRO MADA"></form>
            <script>
                    var wpwlOptions = {
                     style: "logos",

                     brandDetection: true,
                     brandDetectionType: "binlist",
                     brandDetectionPriority: ["MADA","VISA","MAESTRO"],
                     // Optional. Use SVG images, if available, for better quality.
                     imageStyle: "svg",

                        onReady: function() {
                            var createRegistrationHtml = '<div class="customLabel">{{__("labels.store_payment_details")}} <input type="checkbox" name="createRegistration" value="true" class="wpwl-control-cardHolder" /></div>';
                            $('form.wpwl-form-card').find('.wpwl-button').before(createRegistrationHtml);
                        },
                        locale: "{{config('app.locale')}}",
                        disableCardExpiryDateValidation: false,
                        showCVVHint: true,
                        brandDetection: true,
                        validation: true,
                        registrations: {
                           requireCvv: true,
                           hideInitialPaymentForms: true
                        },
                        onChangeBrand: function() {
                           hideBrands();
                        }
                    }

                    var ready = false;
                     var dotsClicked = false;
                     function hideBrands() {
                        if (!ready || dotsClicked) {
                           return;
                        }
                     }

            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="{{config('services.hyper_pay_api_url')}}/v1/paymentWidgets.js?checkoutId={{$checkoutId}}"></script>
         </div>

         <!-- footer  -->
        <footer class="footer bgwhite position-relative footer__lower">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-lg-4 col-sm-12">
                     <div class="footer__list">
                        <a class="footer__logo" href="index.php">
                        <img src="{{asset('assets/images/logo-frontend.png')}}" class="img-fluid" alt="logo" />
                        </a>
                        <p>{{ __('labels.join_millions_of_students') }}<br class="d-none d-md-block"> {{ __('labels.learning_experience_to_help') }}<br class="d-none d-md-block"> {{ __('labels.they_want_to_go') }}
                        </p>
                        <a href="https://maroof.sa/155914" class="brandLogo" target="_blank"><img src="{{ asset('assets/images/brand-logo.png') }}" class="img-fluid" alt="brand-logo" /></a>
                     </div>
                  </div>
                  <div class="col-md-12 col-lg-4">
                           <h5 class="mb-0 mt-0 font-bd">{{ __('labels.copyRight') }} {{ date('Y') }}-{{ date('Y')+1 }} | {{config('constants.website_name')}} {{ __('labels.all_rights_reserved') }}</h5>
                           <p class="mb-lg-0 mt-0 font-rg">© {{ date('Y') }}{{config('constants.website_name')}}| Pvt. Ltd. {{ __('labels.all_rights_reserved') }}</p>
                        </div>
                        <div class="col-md-12 col-lg-4">
                        <a href="javascript:void(0);"><img src="{{ (app()->getLocale()=='ar')?asset('assets/images/card-img-ar.png'):asset('assets/images/card-img.png') }}" class="img-fluid" alt="card"></a>

                           </a>
                        </div>
               </div>

            </div>
         </footer>
      </div>
   </body>
