@extends('layouts.student.app')

@section('title', __('labels.class_request'))

@section('content')

    <main class="mainContent">

        <div class="editProfilePage commonPad bg-green">

            <section class="pageTitle">

                <div class="container">

                    <div class="commonBreadcrumb">

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a

                                        href="{{ route('student/dashboard') }}">{{ __('labels.home') }}</a></li>

                                <li class="breadcrumb-item active" aria-current="page">{{ __('labels.class_request') }}</li>

                            </ol>

                        </nav>

                    </div>

                    <h3 class="h-32 pageTitle__title">{{ __('labels.class_request') }}</h3>

                </div>

            </section>

            <section class="editProfilePage__inner">

                <div class="container">

                    <div class="d-flex align-items-center mb-3">

                        <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span

                                class="icon-menu"></span></button>

                    </div>

                    <div class="flexRow d-xl-flex">

                        <div class="column-1">

                            @include('layouts.student.side-bar')

                        </div>

                        
                        <div class="column-2">
                            
                            <div class="editProfilePage__Form commonBox">
                                
                                <a href="{{ route('student.classrequest.index') }}" class="btn btn-primary btn-sm"><em class="icon-arrow-back"></em></a>

                                <div class="editFormSec">



                                    <h2 class="text-center">{{ __('labels.class_request') }}</h2> <br>

                                    <div class="row">


                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.status') }} :

                                                    @if($result->status == "Active") <label class="text-success">{{ __('labels.active') }}</label> @else {{ $result->status }} @endif</label>

                                            </div>

                                        </div>
                                     
                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.level') }} :

                                                    {{ $level->name }}</label>

                                            </div>

                                        </div>

                                         @if (!empty($subject_data)) 

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.subjects') }} :

                                                    {{ $subject_data->subject_name }}</label>

                                            </div>

                                        </div>

                                        @endif

                                    

                                        @if (!empty($grade))

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.grade') }} :

                                                    {{ $grade->grade_name }}</label>

                                            </div>

                                        </div>

                                        @endif

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.preferred_gender') }} :

                                                    {{ $result->preferred_gender }}</label>

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.class_duration') }} :

                                                    {{ $result->class_duration }} {{ __('labels.hours') }}</label>

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.classes_type') }} :

                                                    {{ $result->class_type }}</label>

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.time') }} :

                                                    {{ $result->class_time }}</label>

                                            </div>

                                        </div>

                    
                                        @foreach($class_details as $cd)

                                        

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.class_date') }}:

                                                    {{ $cd->date }}</label>

                                            </div>

                                        </div>



                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.request_time') }} :

                                                    {{ $cd->start_time }}</label>

                                            </div>

                                        </div>



                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.expired_time') }} :

                                                    {{ $cd->end_time }}</label>

                                            </div>

                                        </div>



                                        @endforeach

                                    </div>



                                    <div class="btn-row">

                                            @if($result->status == 'Active')
                                            <a href="#" onclick="Cancelrequest('{{ $result->id }}')"   type="button" class="btn btn-primary btn-block btn-lg mw-300 m-auto ripple-effect" title="Cancel">{{ __('labels.cancel_request') }}</a>
                                            @endif

                                    </div>



                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

    </main>

    @include('frontend.image-cropper-modal')

@endsection

@push('scripts')

    <script type="text/javascript" src="{{ asset('assets/js/frontend/image-cropper.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/frontend/student/profile.js') }}"></script>

    <script type="text/javascript" src="{{asset('assets/js/frontend/student/student-class-request.js')}}"></script>

@endpush

