@php

if(Auth::check() && Auth::user()->isTutor()){

$layout = 'layouts.tutor.app';

}elseif(Auth::check() && Auth::user()->isStudent()){

$layout = 'layouts.student.app';

}

@endphp

@extends($layout)

@section('title', 'Class Request')

@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" type="text/css">

@endpush

<style>
    .clock {
  width: 650px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
}
</style>

@section('content')

<main class="mainContent">

    <div class="walletPage commonPad bg-green">

        <section class="pageTitle">

            <div class="container">

                <div class="commonBreadcrumb">

                    <nav aria-label="breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home')}}</a></li>

                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.class_request')}}</li>

                        </ol>

                    </nav>

                </div>

                <h3 class="h-32 pageTitle__title">{{ __('labels.class_request')}}</h3>

               

            </div>

        </section>

        <section class="walletPage__inner">

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

                        <div class="walletPage__content common-shadow bg-white p-30">

                            <div class="walletPage__table m-0">

                                <div class="row align-items-center">

                                    <div class="col-sm-10">

                                              <h3 class="h-24">{{ __('labels.class_request') }}</h3>

                                     </div>

                                     <div class="col-sm-2">

                                            <a href="{{ route('student.classrequest.create') }}" type="button" class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-plus"></em></a>

                                     </div>

                                </div>

                                <div class="searchList common-table" nice-scroll>

                                    <div class="table-responsive" id="classRequestList">

                                        <table class="table">

                                            <thead>

                                                <tr>

                                                    <th></th>

                                                    <th>{{ __('labels.id')}}</th>

                                                    <th>{{ __('labels.status') }}</th>

                                                    <th>{{ __('labels.class_type') }}</th>

                                                    <th>{{ __('labels.class_duration') }}</th>

                                                    <th>{{ __('labels.action') }}</th> 

                                                    <th></th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                          </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

</main>

{{-- @include('frontend.wallet.add-amount-modal')

@include('frontend.wallet.redeem-amount-modal') --}}

@endsection

@push('scripts')

@if(Auth::check() && Auth::user()->isTutor())

<script >

    var walletLitUrl = "{{ route('tutor.wallet.list') }}";

</script>

@elseif(Auth::check() && Auth::user()->isStudent())

<script >

    var walletLitUrl = "{{ route('student.wallet.list') }}";

</script>

@endif



<script type="text/javascript" src="{{asset('assets/js/frontend/student/class-request.js')}}"></script>




@endpush