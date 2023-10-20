@php
if(Auth::check() && Auth::user()->isTutor()){
    $layout = 'layouts.tutor.app';
}elseif(Auth::check() && Auth::user()->isStudent()){
    $layout = 'layouts.student.app';
}
@endphp
@extends($layout)
@section('title',__('labels.refer_earn'))
@section('content')
<main class="mainContent">
    <div class="referPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('labels.refer_earn')}}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{__('labels.refer_earn')}}</h3>
            </div>
        </section>
        <section class="">
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
                        <div class="referralWraper">
                            <div class="referralBanner">
                                <div class="referralCode text-center">
                                    <div class="referralCode__top">
                                        <img src="{{ asset('assets/images/box-top.png')}}" alt="box-top" />
                                    </div>
                                    <div class="referralCode__middle">
                                        <span class="referralCode__title">{{__('labels.you_will_earn')}}</span>
                                        <span class="referralCode__points">{{config('constants.referral.points')}} {{__('labels.points')}} = <span class="font-rg">{{ __('labels.sar') }} </span> {{config('constants.referral.sar_value')}}</span>
                                        <div class="referralCode__wrapper">
                                            <label class="referralCode__label">{{__('labels.referral_code')}}</label>
                                            <span id="referral-code" class="referralCode__number">{{$data->referral_code}}
                                                <a id="copy" data-clipboard-text="{{$data->referral_code}}" class="" href="javascript:void(0);">
                                                    <em class="icon-duplicate"></em>
                                                </a>
                                            </span>
                                            
                                        </div>
                                    </div>
                                    <div class="referralCode__bottom">
                                        <img src="{{ asset('assets/images/box-bottom.png')}}" alt="box-bottom" />
                                    </div>
                                </div>
                            </div>

                            <div class="howitWork">
                                <div class="container">
                                    <h4 class="text-center">{{__('labels.how_it_works')}}</h4>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="howitWorkBox d-flex align-items-center">
                                                <div class="howitWorkBox__icon">
                                                    <img src="{{ asset('assets/images/attach-icon.svg')}}" alt="attach-icon" />
                                                </div>
                                                <div class="howitWorkBox__txt">
                                                    {{__('labels.invite_friends')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="howitWorkBox d-flex align-items-center">
                                                <div class="howitWorkBox__icon">
                                                    <img src="{{ asset('assets/images/money-icon.svg')}}" alt="money-icon" />
                                                </div>
                                                <div class="howitWorkBox__txt">
                                                    {{__('labels.when_they_singup')}} {{ __('labels.sar') }}  {{config('constants.referral.sar_value')}}.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="howitWorkBox d-flex align-items-center">
                                                <div class="howitWorkBox__icon">
                                                    <img src="{{ asset('assets/images/redeem-icon.svg')}}" alt="redeem-icon" />
                                                </div>
                                                <div class="howitWorkBox__txt">
                                                    {{__('labels.you_will_get_at_booking')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a data-toggle="modal" data-target="#shareModal" class="btn btn-primary btn-lg ripple-effect btn-block mx-auto" href="javascript:void(0);">{{__('labels.refer_now')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<div class="modal fade" id="shareModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--referEarnModal">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{ __('labels.refer_now') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @forelse ($shareLinks as $provider => $link)
                    @if ($loop->first)
                        <ul class="list-unstyled">
                    @endif
                        <li><a href="{{$link}}"><em class="icon-{{$provider}}"></em></a></li>
                    @if ($loop->last)
                        </ul>
                    @endif
                @empty
                    <div class="alert alert-danger">{{__('message.no_sharing_options_configured')}}</div>
                @endforelse
            </div>
            <div class="modal-footer border-top-0 justify-content-center">
                
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/referral-code/index.js')}}"></script>
<script src="{{ asset('assets/js/frontend/share.js') }}"></script>
@endpush