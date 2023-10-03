@extends('layouts.tutor.app')
@section('title',__('labels.my_classes'))
@section('content')
<main class="mainContent">
    <div class="changePasswordPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.change_password')}}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.change_password')}}</h3>
            </div>
        </section>
        <section class="changePasswordPage__inner">
            <div class="container">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
                </div>
                <div class="flexRow d-xl-flex">
                    <div class="column-1">
                        @include('layouts.tutor.side-bar')
                    </div>
                    <div class="column-2">
                        <div class="changePasswordPage__form common-shadow bg-white h-100 p-30">
                            <div class="changePasswordSec">
                                <form action="{{ route('tutor.change-password.update') }}" method="POST" id="changePasswordForm" novalidate>
                                    <div class="form-group form-group-icon">
                                        <label class="form-label">{{ __('labels.current_password') }}</label>
                                        <input name="current_password" type="password" dir="rtl" class="form-control" placeholder="{{__('labels.enter_current_password')}}" value="" />
                                        <a href="javascript:void(0);" id="showPassword" class="icon"><span class="icon-eye"></span></a>
                                    </div>
                                    <div class="form-group form-group-icon">
                                        <label class="form-label">{{ __('labels.new_password') }}</label>
                                        <input name="new_password" type="password" dir="rtl" class="form-control" placeholder="{{__('labels.enter_new_password')}}" value="" />
                                        <a href="javascript:void(0);" id="showPassword2" class="icon"><span class="icon-eye"></span></a>
                                    </div>
                                    <div class="form-group form-group-icon">
                                        <label class="form-label">{{ __('labels.confirm_password') }}</label>
                                        <input name="confirm_password" type="password" dir="rtl" class="form-control" placeholder="{{__('labels.enter_confirm_password')}}" value="" />
                                        <a href="javascript:void(0);" id="showPassword3" class="icon"><span class="icon-eye"></span></a>
                                    </div>
                                    <div class="submitBtn">
                                        <button type="submit" id="changePasswordBtn" class="btn btn-primary btn-block btn-lg ripple-effect mw-448">{{ __('labels.save') }}</button>
                                    </div>
                                </form>
                                {!! JsValidator::formRequest('App\Http\Requests\Tutor\ChangePasswordRequest', '#changePasswordForm') !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<!-- Password Change -->
<div class="modal fade" id="changedSuccessfuly" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--success">
        <div class="modal-content">
            <div class="modal-body">
                <div class="innerBox text-center">
                    <img src="{{ asset('assets/images/password-correct.svg') }}" class="img-fluid" alt="correct">
                    <h5>{{ __('message.changed_password_title') }}</h5>
                    <p class="mb-0 textGray">{{ __('message.changed_password') }}</p>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="submit" class="btn btn-primary btn-lg w-100 ripple-effect" data-dismiss="modal">{{__('labels.okay')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/change-password.js')}}"></script>
@endpush
