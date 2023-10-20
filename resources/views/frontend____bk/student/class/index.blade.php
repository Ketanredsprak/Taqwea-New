@extends('layouts.student.app')
@section('title', $title)
@section('content')
<main class="mainContent">
         <div class="myClassesPage commonPad bg-green">
            <section class="pageTitle">
               <div class="container">
                  <div class="commonBreadcrumb">
                     <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('student/dashboard')}}">{{__('labels.home')}}</a></li>
                           <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                        </ol>
                     </nav>
                  </div>
                  <h3 class="h-32 pageTitle__title">{{$title}}</h3>
               </div>
            </section>
            <section class="myClassesPage__inner">
               <div class="container">
                  <div class="d-flex align-items-center mb-3">
                     <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
                  </div>
                  <div class="flexRow d-xl-flex">
                     <div class="column-1">
                     @include('layouts.student.side-bar')
                     </div>
                     <div class="column-2">
                        <div class="myClassesPage__list">
                           <div class="common-tabs mb-3 mb-lg-4">
                              <ul class="nav nav-tabs">
                                 <li class="nav-item">
                                        <a class="nav-link classListType active" data-type="upcoming" data-toggle="tab" href="#upcomingClasses">{{ ($classType=='class')?__('labels.upcoming_class'):__('labels.upcoming_webinar') }}</a>
                                 </li>
                                 <li class="nav-item">
                                 <a class="nav-link classListType" data-type="past" data-toggle="tab" href="#pastClasses">{{ ($classType=='class')?__('labels.pass_class'):__('labels.pass_webinar') }}</a>

                                 </li>
                              </ul>
                           </div>
                           <div class="tab-content">
                           <input type="hidden" id="classType" value="{{ $classType }}">
                              <div class="tab-pane fade show active" id="upcomingClasses" role="tabpanel">
                                 
                              </div>
                              <div class="tab-pane fade" id="pastClasses" role="tabpanel">
                                 
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
      </main>
    @push('scripts')
        <script type="text/javascript" src="{{asset('assets/js/frontend/student/class.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/frontend/booking-operations.js')}}"></script>
        
    @endpush
@endsection