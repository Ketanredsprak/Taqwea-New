@extends('layouts.tutor.app')
@section('title', __('labels.feedback'))
@section('content')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
<main class="mainContent">
         <div class="feedbackPage commonPad bg-green">
            <section class="pageTitle">
               <div class="container">
                  <div class="commonBreadcrumb">
                     <nav aria-label="breadcrumb"> 
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('labels.home')}}</a></li>
                           <li class="breadcrumb-item active" aria-current="page">{{__('labels.my_feedback')}}</li>
                        </ol>
                     </nav>
                  </div>
                  <h3 class="h-32 pageTitle__title">{{__('labels.my_feedback')}}</h3>
               </div>
            </section>
            <section class="feedbackPage__cnt">
               <div class="container">
                              <div class="feedbackGraph">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 438.295 254.253">
                            <defs>
                                <style>
                                .cls-1,
                                .cls-2 {
                                    fill: none;
                                    stroke-width: 48px;
                                }

                                .cls-1 {
                                    stroke: #ffc100;
                                    stroke-dasharray: 121 683;
                                }

                                .cls-2 {
                                    stroke: #e1e1e1;
                                    stroke-dasharray: 106 685;
                                }

                                .cls-3 {
                                    font-size: 62px;
                                }

                                .cls-3,
                                .cls-5 {
                                    font-family: NunitoSans-Bold, Nunito Sans;
                                    font-weight: 700;
                                }

                                .cls-4 {
                                    font-size: 34px;
                                    font-family: NunitoSans-Regular, Nunito Sans;
                                    font-weight: 400;
                                }

                                .cls-5 {
                                    font-size: 14px;
                                }

                                .cls-6 {
                                    filter: url(#Path_108116);
                                }

                                .cls-7 {
                                    filter: url(#Path_108118);
                                }

                                .cls-8 {
                                    filter: url(#Path_108119);
                                }

                                .cls-9 {
                                    filter: url(#Path_108120);
                                }
                                </style>
                                <filter id="Path_108120" x="0" y="101.438" width="108.103" height="149.52"
                                    filterUnits="userSpaceOnUse">
                                    <feOffset dy="3" input="SourceAlpha" />
                                    <feGaussianBlur stdDeviation="5" result="blur" />
                                    <feFlood flood-opacity="0.122" />
                                    <feComposite operator="in" in2="blur" />
                                    <feComposite in="SourceGraphic" />
                                </filter>
                                <filter id="Path_108119" x="46.303" y="17.996" width="145.093" height="148.848"
                                    filterUnits="userSpaceOnUse">
                                    <feOffset dy="3" input="SourceAlpha" />
                                    <feGaussianBlur stdDeviation="5" result="blur-2" />
                                    <feFlood flood-opacity="0.122" />
                                    <feComposite operator="in" in2="blur-2" />
                                    <feComposite in="SourceGraphic" />
                                </filter>
                                <filter id="Path_108118" x="143.167" y="0" width="155.796" height="130.685"
                                    filterUnits="userSpaceOnUse">
                                    <feOffset dy="3" input="SourceAlpha" />
                                    <feGaussianBlur stdDeviation="5" result="blur-3" />
                                    <feFlood flood-opacity="0.122" />
                                    <feComposite operator="in" in2="blur-3" />
                                    <feComposite in="SourceGraphic" />
                                </filter>
                                <filter id="Path_108116" x="246.122" y="36.943" width="147.211" height="130.17"
                                    filterUnits="userSpaceOnUse">
                                    <feOffset dy="3" input="SourceAlpha" />
                                    <feGaussianBlur stdDeviation="5" result="blur-4" />
                                    <feFlood flood-opacity="0.122" />
                                    <feComposite operator="in" in2="blur-4" />
                                    <feComposite in="SourceGraphic" />
                                </filter>
                            </defs>
                            <g id="Group_56734" data-name="Group 56734" transform="translate(-748.004 -211.26)">
                                <g id="Group_56735" data-name="Group 56735">
                                    <g id="Group_56675" data-name="Group 56675" transform="translate(720.025 105.844)">
                                        <g class="cls-9" transform="matrix(1, 0, 0, 1, 27.98, 105.42)">
                                            <path id="Path_108120-2" data-name="Path 108120" class="{{$rating_avg >= 1? 'cls-1':'cls-2'}}"
                                                d="M0,0C37.62,0,75.482,11.965,104.26,32.523"
                                                transform="translate(39 232.05) rotate(-89)" />
                                        </g>
                                        <g class="cls-8" transform="matrix(1, 0, 0, 1, 27.98, 105.42)">
                                            <path id="Path_108119-2" data-name="Path 108119" class="{{$rating_avg >= 2? 'cls-1':'cls-2'}}"
                                                d="M0,0A173.357,173.357,0,0,1,86.365,22.948"
                                                transform="translate(79.69 120.7) rotate(-50)" />
                                        </g>
                                        <g class="cls-7" transform="matrix(1, 0, 0, 1, 27.98, 105.42)">
                                            <path id="Path_108118-2" data-name="Path 108118" class="{{$rating_avg >= 3? 'cls-1':'cls-2'}}"
                                                d="M0,0A173.232,173.232,0,0,1,96.551,29.27"
                                                transform="matrix(0.96, -0.28, 0.28, 0.96, 164.78, 65.35)" />
                                        </g>
                                        <path id="Path_108117" data-name="Path 108117" class="{{$rating_avg >= 5? 'cls-1':'cls-2'}}"
                                            d="M0,0A175.686,175.686,0,0,1,97.2,29.664"
                                            transform="translate(384.577 240.294) rotate(56)" />
                                        <g class="cls-6" transform="matrix(1, 0, 0, 1, 27.98, 105.42)">
                                            <path id="Path_108116-2" data-name="Path 108116" class="{{$rating_avg >= 4? 'cls-1':'cls-2'}}"
                                                d="M0,0A173.064,173.064,0,0,1,86.917,23.286"
                                                transform="matrix(0.93, 0.37, -0.37, 0.93, 277.63, 71.2)" />
                                        </g>
                                    </g>
                                    <text id="_{{$rating_avg}}_5" data-name="{{$rating_avg}}/5" class="cls-3" transform="translate(927 396)">
                                        <tspan x="0" y="0">{{$rating_avg}}</tspan>
                                        <tspan class="cls-4" y="0">/5</tspan>
                                    </text>
                                    <text id="Overall_Rating" data-name="Overall Rating" class="cls-5"
                                        transform="translate(960 431)">
                                        <tspan x="-46.011" y="0">{{__('labels.overall_rating')}}</tspan>
                                    </text>
                                </g>
                            </g>
                        </svg>
                        <p class="feedbackGraph__note">{{__('labels.this_overall_rating_criteria')}}</p>
                    </div>
                    <h3 class="font-eb h-24">{{__('labels.ratings')}}</h3>
                    <div class="row">
                        <div class="col-sm-6 col-lg-4">
                           <div class="feedbackBox">
                              <div class="progress mx-auto" data-value='{{$rating->clarity*20}}'>
                                  <span class="progress-left">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <span class="progress-right">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <div
                                      class="progress-value rounded-circle d-flex align-items-center justify-content-center">
                                      <span class="progress-count">{{$rating->clarity}}</span>/<span class="progress-total">5</span>
                                  </div>
                              </div>
                              <h4>{{__('labels.clarity')}}</h4>
                           </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                           <div class="feedbackBox">
                              <div class="progress mx-auto" data-value='{{$rating->orgnization*20}}'>
                                  <span class="progress-left">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <span class="progress-right">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <div
                                      class="progress-value rounded-circle d-flex align-items-center justify-content-center">
                                      <span class="progress-count">{{$rating->orgnization}}</span>/<span class="progress-total">5</span>
                                  </div>
                              </div>
                              <h4>{{__('labels.organization')}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                           <div class="feedbackBox">
                              <div class="progress mx-auto" data-value='{{$rating->give_homework*20}}'>
                                  <span class="progress-left">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <span class="progress-right">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <div
                                      class="progress-value rounded-circle d-flex align-items-center justify-content-center">
                                      <span class="progress-count">{{$rating->give_homework}}</span>/<span class="progress-total">5</span>
                                  </div>
                              </div>
                              <h4>{{__('labels.give_homework')}}</h4>
                           </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                           <div class="feedbackBox">
                              <div class="progress mx-auto" data-value='{{$rating->use_of_supporting_tools*20}}'>
                                  <span class="progress-left">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <span class="progress-right">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <div
                                      class="progress-value rounded-circle d-flex align-items-center justify-content-center">
                                      <span class="progress-count">{{$rating->use_of_supporting_tools}}</span>/<span class="progress-total">5</span>
                                  </div>
                              </div>
                              <h4>{{__('labels.use_of_supporting_tools')}}</h4>
                           </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                           <div class="feedbackBox">
                              <div class="progress mx-auto" data-value='{{$rating->on_time*20}}'>
                                  <span class="progress-left">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <span class="progress-right">
                                      <span class="progress-bar"></span>
                                  </span>
                                  <div
                                      class="progress-value rounded-circle d-flex align-items-center justify-content-center">
                                      <span class="progress-count">{{$rating->on_time}}</span>/<span class="progress-total">5</span>
                                  </div>
                              </div>
                              <h4>{{__('labels.on_time')}}</h4>
                            </div>
                        </div>
                    </div>
                    <h3 class="font-eb h-24 mt-xl-4">{{__('labels.review')}}</h3>
                    <div class="reviewBox commonBox">
                       {{$rating->review}}
                    </div>
                    
               </div>
            </section>

         </div>
      </main>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/feedback.js')}}"></script>

@endpush