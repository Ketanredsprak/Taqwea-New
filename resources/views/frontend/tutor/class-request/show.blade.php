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

                                <a href="{{ Route('tutor.classrequest.index') }}" class="btn btn-primary btn-sm float-right"><em
                                        class="icon-arrow-back"></em></a>

                                <div class="editFormSec">



                                    @php
                                        $start_time = \Carbon\Carbon::now();
                                        $end_time = \Carbon\Carbon::parse($result->classrequest->created_at)->addMinutes(11);
                                        $diff = $start_time->diffInMinutes($end_time, false);
                                    @endphp


                                    <h4 class="h-32"> {{ __('labels.student_information') }}</h4>




                                    <div class="row class_info">

                                        @if (!empty($result->userdata))
                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="form-label">{{ __('labels.student_name') }} :

                                                        {{ $result->userdata->name }}</label>

                                                </div>

                                            </div>

                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="form-label">{{ __('labels.student_gender') }} :

                                                        {{ $result->userdata->gender }}</label>

                                                </div>

                                            </div>
                                        @else
                                            <tr>

                                                <td colspan="7" class="px-0">

                                                    <div class="alert alert-danger font-rg">

                                                        {{ __('labels.record_not_found') }}</div>

                                                </td>

                                            </tr>
                                        @endif

                                    </div>




                                    <h4 class="h-32">{{ __('labels.student_class_request') }}</h4>


                                    <div class="row class_info">

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

                                                    {{ $result->classrequest->preferred_gender }}</label>

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.class_duration') }} :

                                                    {{ $result->classrequest->class_duration }}

                                                    {{ __('labels.hours') }}</label>

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.classes_type') }} :

                                                    {{ $result->classrequest->class_type }}</label>

                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.time') }} :

                                                    {{ $result->classrequest->class_time }}</label>

                                            </div>

                                        </div>

                                        @foreach ($class_details as $cd)
                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label class="form-label">{{ __('labels.class_date') }}:

                                                        {{ $cd->date }}</label>

                                                </div>

                                            </div>
                                        @endforeach

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label class="form-label">{{ __('labels.note') }} :

                                                    {{ $result->classrequest->note }}</label>

                                            </div>


                                           








                                        </div>

                   <!---  for timer countdonw code  -->
                    @php
                           $start_time = \Carbon\Carbon::now();
                           $end_time = \Carbon\Carbon::parse($result->classrequest->created_at)->addMinutes(11);
                           $diff = $start_time->diffInMinutes($end_time, false);
                    @endphp
                     

                                    <!-- {{-- <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="form-label">
                                                <p id="demo"></p>
                                            </label>
                                        </div>
                                    
                                    </div> --}} -->



                                    </div>



                                 <!-- <div class="btn-row">

                                            <a href="#"

                                                class="btn btn-primary btn-block btn-lg mw-300 m-auto ripple-effect"><p id="demo"></p></a>

                                 </div>  -->



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
@endpush
<script>
                       // Set the date we're counting down to
                        var countDownDate = "{{ @$diff }}";
                        
                        // Update the count down every 1 second
                        var x = setInterval(function() {
                        
                        // Get today's date and time
                        var now = new Date().getTime();
                        
                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;
                        
                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        
                        // Display the result in the element with id="demo"
                        document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                        + minutes + "m " + seconds + "s ";
                        
                        // If the count down is finished, write some text
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("demo").innerHTML = "EXPIRED";
                        }
                        }, 1000);
    </script>
