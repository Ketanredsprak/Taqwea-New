<footer class="footer bgwhite position-relative">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-4 col-sm-12">
                <div class="footer__list">
                    <a class="footer__logo" href="index.php">
                        <img src="{{ asset('assets/images/logo-frontend.png') }}" class="img-fluid" alt="logo" />
                    </a>
                    <p>{{ __('labels.join_millions_of_students') }}<br class="d-none d-md-block"> {{ __('labels.learning_experience_to_help') }}<br class="d-none d-md-block"> {{ __('labels.they_want_to_go') }}</p>
                    <a href="https://maroof.sa/155914" class="brandLogo" target="_blank"><img src="{{ asset('assets/images/brand-logo.png') }}" class="img-fluid" alt="brand-logo" /></a>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="footer__link">
                            <h4 class="font-bd mb-0">{{ __('labels.navigation') }}</h4>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                                <li><a href="{{ url('about-us') }}">{{ __('labels.about_us') }}</a></li>
                                <li><a href="{{ url('terms-and-condition') }}">{{ __('labels.terms') }}</a></li>
                                <li><a href="{{ url('privacy-policy') }}">{{ __('labels.privacy_policy') }}</a></li>
                                <li><a href="{{ url('faq') }}">{{ __('labels.faq') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="footer__link">
                            <h4 class="font-bd mb-0">{{ __('labels.classes_caps') }}</h4>
                            <ul class="list-unstyled">
                                <li><a href="{{ url('classes') }}">{{ __('labels.online_classes') }}</a></li>
                                <li><a href="{{ url('webinars') }}">{{ __('labels.webinars') }}</a></li>
                                <li><a href="{{ url('blogs') }}">{{ __('labels.blogs') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="footer__link">
                            <h4 class="font-bd mb-0">{{ __('labels.contact_us') }}</h4>
                            <div class="footer__contact d-flex align-items-center">
                                <em class="icon-paper-plane"></em>
                                <a href="{{route('contact-us')}}">{{ __('labels.contact_support') }}</a>
                            </div>
                            <div class="footer__contact d-flex align-items-center">
                                <em class="icon-telephone"></em>
                                <p class="mt-0 mb-0" dir='ltr'>{{getSetting('phone_number')}}</p>
                            </div>
                            <div class="footer__socialIcon">
                                <h4 class="font-bd mb-0">{{ __('labels.follow_us') }}</h4>
                                <ul class="list-unstyled mb-0">
                                    <li><a href="{{getSetting('facebook_link')}}" target="_blank"><em class="icon-facebook"></em></a></li>
                                    <li><a href="{{getSetting('twitter_link')}}" target="_blank"><em class="icon-twitter"></em></a></li>
                                    <li><a href="{{getSetting('youtube_link')}}" target="_blank"><em class="icon-youtube"></em></a></li>
                                    <li><a href="{{getSetting('instagram_link')}}" target="_blank"><em class="icon-instagram"></em></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- =============================== footer lower =============================== -->
        <div class="row footer__lower">
            <div class="col-lg-4">
                <div class="footer__img footer__img--footerlogo d-flex align-items-center">
                    <a href="{{getSetting('google_link')}}" target="_blank">
                        <img src="{{ asset('assets/images/google-play.jpg') }}" class="img-fluid" alt="google-play">
                    </a>
                    <a href="{{getSetting('app_store_link')}}" target="_blank">
                        <img src="{{ asset('assets/images/app-store.jpg') }}" class="img-fluid" alt="app-store">
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row align-items-center">
                    <div class="col-md-12 col-lg-8">
                        <h5 class="mb-0 mt-0 font-bd">{{ __('labels.copyRight') }} {{ date('Y') }}-{{ date('Y')+1 }} | {{config('constants.website_name')}} {{ __('labels.all_rights_reserved') }}</h5>
                        {{--<p class="mb-lg-0 mt-0 font-rg">© {{ date('Y') }} {{config('constants.website_name')}}| Pvt. Ltd. {{ __('labels.all_rights_reserved') }}</p>--}}
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <a href="javascript:void(0);"><img src="{{ (app()->getLocale()=='ar')?asset('assets/images/card-img-ar.png'):asset('assets/images/card-img.png') }}" class="img-fluid" alt="card"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
