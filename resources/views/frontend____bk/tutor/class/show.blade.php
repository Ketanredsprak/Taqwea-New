@extends('layouts.tutor.app')
@section('title', $title)
@section('title', $class->translateOrDefault()->class_name)
@section('meta-description-facebook')
{!! $class->translateOrDefault()->class_detail !!}
@endsection
@section('meta-image-facebook', $class->class_image_url)
@section('meta-keywords-url', $shareUrl)
@section('content')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
<main class="mainContent">
    <div class="detailPage detailPage--classDetail bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('labels.home')}}</a></li>
                            <li class="breadcrumb-item">
                                @if($classType=='class')
                                <a href="{{ route('tutor.classes.index') }}">{{__('labels.my_classes')}}</a>
                                @else
                                <a href="{{ route('tutor.webinars.index') }}">{{__('labels.my_webinars')}}</a>
                                @endif
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ $title }}</h3>
            </div>
        </section>
        <section class="detailPageCnt">
            <div class="detailPageCnt__inner">
                <div class="subject">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="subject__left commonBox">
                                    <h3 class="heading h-32">{{ $class->translateOrDefault()->class_name }}
                                    </h3>
                                    <p>{{ $class->translateOrDefault()->class_detail }}</p>
                                    <div class="subject__info">
                                        <div class="d-sm-flex d-block">
                                            <div class="view">
                                                <div class="label">{{__('labels.students')}}</div>
                                                @if($classType=='class')
                                                <div class="cnt">{{ @$class->bookings_count }}<span>/</span>5</div>
                                                @else
                                                <div class="cnt">{{ @$class->bookings_count }}</div>
                                                @endif
                                            </div>
                                            <div class="view">
                                                <div class="label">{{__('labels.duration')}}</div>
                                                <div class="cnt">{{ getDuration($class->duration) }}</div>
                                            </div>
                                            <div class="view">
                                                <div class="label">{{__('labels.topics')}}</div>
                                                <div class="cnt">{{ count($class->topics) }}</div>
                                            </div>
                                            @if($class->gender_preference != 'both')
                                            <div class="view">
                                                <div class="label">{{__('labels.gender')}}</div>
                                                @if($class->gender_preference =='male' || $class->gender_preference =='female' )
                                                <div class="cnt">{{ $class->gender_preference }}</div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="subject__classInfo">
                                        <h5 class="h-24">{{ ($classType=='class')?__('labels.class_detail'):__('labels.webinar_detail') }}</h5>
                                        @if(@$class->category->name)
                                        <div class="info d-flex">
                                            <p class="info__title mb-0">{{__('labels.category')}}</p>
                                            <span class="info__view">{{ @$class->category->translateOrDefault()->name }}</span>
                                        </div>
                                        @endif
                                        @if(@$class->level->name)
                                        <div class="info d-flex">
                                            <p class="info__title mb-0">{{__('labels.level')}}</p>
                                            <span class="info__view">{{ @$class->level->translateOrDefault()->name }}</span>
                                        </div>
                                        @endif
                                        @if(@$class->grade->grade_name)
                                        <div class="info d-flex">
                                            <p class="info__title mb-0">{{__('labels.grade')}}</p>
                                            <span class="info__view">{{ @$class->grade->translateOrDefault()->grade_name }}</span>
                                        </div>
                                        @endif
                                        @if(@$class->subject->subject_name)
                                        <div class="info d-flex">
                                            <p class="info__title mb-0">{{__('labels.subject_expertise')}}</p>
                                            <span class="info__view">{{ @$class->subject->translateOrDefault()->subject_name }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="subject__moreInfo">
                                        <p class="more mb-0">
                                            {!! @$class->translateOrDefault()->class_description !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="subject__topicList">
                                    <div id="faqs" class="accordion customAccordion">
                                        @forelse(@$class->topics as $key => $topic)
                                        <div class="accordion-item commonBox">
                                            <div class="accordion-head w-100 text-left bg-white" data-target="#faq-q{{ $key }}" data-toggle="collapse">
                                                @if($loop->index == 0)
                                                <h5 class="h-24">{{ __('labels.topics_list') }}</h5>
                                                @endif
                                                <div class="action">
                                                    <buttton class="accordion-icon" data-toggle="collapse" data-target="#faq-q{{ $key }}" title="View Answer">{{ $loop->iteration }}: {{ $topic->translateOrDefault()->topic_title }}
                                                    </buttton>
                                                </div>
                                            </div>
                                            <div class="accordion-body collapse {{ ($key==0)?'show':'' }}" data-parent="#faqs" id="faq-q{{ $key }}">
                                                <div class="accordion-inner">
                                                    <p>
                                                        {{ $topic->translateOrDefault()->topic_description }}
                                                    </p>
                                                    <ul class="list-unstyled">
                                                        @forelse(@$topic->subTopics as $subTopic)
                                                        @if(@$subTopic->translateOrDefault()->sub_topic && @$subTopic->translations[0]->language == config('app.locale'))
                                                        <li>{{ $subTopic->translateOrDefault()->sub_topic }}</li>
                                                        @endif
                                                        @empty

                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        @endforelse
                                    </div>
                                    <!-- .accordion -->
                                    <div class="btn-row text-center">
                                        <!-- <a href="javascript:void(0);" class="show-more text-uppercase h-16">Show
                                            Less</a> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="subject__right subject--box commonBox">
                                    <div class="classImg">
                                        <img src="{{ $class->class_image_url }}" alt="class image" class="img-fluid class-img" />
                                        <div class="teacherInfo d-flex align-items-center justify-content-between">
                                            <div class="teacherInfo__left">
                                                <div class="userInfo d-flex align-items-center">
                                                    <div class="userInfo__img">
                                                        <img src="{{ @$class->tutor->profile_image_url }}" alt="{{ @$class->tutor->translateOrDefault()->name }}">
                                                    </div>
                                                    <div class="userInfo__name text-truncate">
                                                        {{ @$class->tutor->translateOrDefault()->name }}
                                                    </div>
                                                </div>
                                            </div>
                                            @if($class->status != 'inactive' && $class->status != 'cancelled')
                                            <div class="teacherInfo__right">
                                                <a href="javascrpit:void(0);" data-toggle="modal" data-target="#shareModal" class="d-flex align-items-center justify-content-center shareLink"><em class="icon-share"></em></a> 
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="amountInfo d-flex justify-content-between">
                                        <div class="amountInfo__left">{{__()}}</div>
                                        <div class="amountInfo__right">{{ __('labels.sar') }}  <span>{{ (!empty($class->total_fees))?number_format($class->total_fees, 2): number_format(round(($class->duration/60)*$class->hourly_fees,2),2) }}</span></div>
                                    </div>
                                    @if($class->start_time)
                                    <div class="dateTime d-flex align-items-center" >
                                        <em class="icon-calender"></em>
                                        <p dir="{{config('constants.date_format_direction')}}" class="mb-0">{{ convertDateToTz($class->start_time, 'UTC', 'd M Y') }}<span> {{ convertDateToTz($class->start_time, 'UTC', 'h:i A') }}</span></p>
                                    </div>
                                    @endif
                                    @if($class->status !== 'completed')
                                    <div class="btnRow d-flex justify-content-between">
                                        @if($class->class_type=='class')
                                        @php $url = route('tutor.classes.edit', ['class' => $class->id]) @endphp
                                        @else
                                        @php $url = route('tutor.webinars.edit', ['webinar' => $class->id]) @endphp
                                        @endif
                                        @if($class->status=='active')
                                        <a class="btn btn-primary ripple-effect btn-lg join-now disabled" data-start-time="{{ $class->start_time }}" href="{{route('tutor.class.start', ['slug' => $class->slug])}}" tabindex="0">{{__('labels.start_class')}}</a>
                                        <a href="javascript:void(0);" class="btn btn-primary ripple-effect btn-lg cancel-btn-disabled" onclick="cancelClass($(this),{{ $class->id }},'{{$class->class_type}}')">{{ __('labels.cancel') }}</a>
                                        @elseif($class->is_published==0 && ($class->status=='active' || $class->status=='inactive'))
                                        <a class="btn btn-primary btn-primary--outline ripple-effect btn-lg" href="{{ $url }}" tabindex="0">{{ ($classType=='class')?__('labels.edit_class'):__('labels.edit_webinar') }}</a>
                                        <a class="btn btn-primary ripple-effect btn-lg" href="javascript:void(0);" tabindex="0" onclick="publishClass($(this),{{ $class->id }}, '{{ ($classType=='class')?'class':'webinar' }}')">{{__('labels.publish')}}</a>
                                        @else
                                        <p class="font-bd mb-0 {{$class->status == 'completed' ? 'textSuccess' : 'textDanger'}} text-capitalize">{{__('labels.'.$class->status)}}</p>
                                        @endif
                                    </div>
                                    <div class="btnRow d-flex justify-content-between">
                                        @php
                                        $redirectUrl = ($class->class_type=='class')?route("tutor.classes.index"):route("tutor.webinars.index");
                                        @endphp
                                    </div>
                                    @else
                                    <div class="btnRow d-flex justify-content-between">
                                        <a class="btn btn-primary btn-primary--outline ripple-effect btn-lg" href="{{route('tutor.feedback.index', ['class' =>$class->id])}}" tabindex="0">{{__('labels.my_feedback')}}</a>
                                        @if($is_chat)
                                        <a class="btn btn-primary ripple-effect btn-lg" href="{{route('message-tutor')}}?class={{$class->id}}" tabindex="0">{{__('labels.chat')}}</a>
                                        @else
                                        <a class="btn btn-primary ripple-effect btn-lg disabled" tabindex="0">{{__('labels.chat')}}</a>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- class webinar student list  -->
        @if(!empty($class->bookings) && count($class->bookings))
        <section class="studentList">
            <div class="container">
                <div class="commonHead d-flex justify-content-between align-items-center flex-wrap">
                    <div class="commonHead-left">
                        <h2 class="commonHead_title font-eb">{{__('labels.student_list')}}</h2>
                    </div>
                    @php $url = route('tutor.student.list', ['id' => $class->id]) @endphp
                    <div class="commonHead-right">
                        <a class="show-all text-uppercase font-eb" href="{{$url}}">{{__('labels.show_all')}}</a>
                    </div>
                </div>
                <div class="listSlider commonSlider">
                    @foreach(@$class->bookings as $booking)
                    <div class="listSlider-item">
                        <div class="studentList__box commonBox">
                            <div class="studentListImg">
                                <img src="{{$booking->student->profile_image_url}}" alt="Lindsay Marsh">
                            </div>
                            <div class="studentListName">
                                {{$booking->student->name}}
                            </div>
                            <div class="studentListRatingSec d-flex align-items-center justify-content-center">
                                <div class="rateStar w-auto" data-rating="{{getAverageRating($booking->student->id)}}"></div>
                            </div>
                            <div class="studentListBtn">
                            <a href="{{route('tutor.student.details', ['id' => $booking->student->id])}}"><button class="btn btn-primary ripple-effect btn-block">{{__('labels.view_details')}}</button></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </div>
</main>


<div class="modal fade" id="shareModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--referEarnModal">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{ __('labels.share_now') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @forelse ($shareLinks as $provider => $link)
                    @if ($loop->first)
                        <ul class="list-unstyled">
                        <li><a id="copy" data-clipboard-text="{{$shareUrl}}" href="javascript:void(0);"><em class="icon-copy"></em></a></li>
                    @endif
                        <li><a target="_blank" href="{{$link}}"><em class="icon-{{$provider}}"></em></a></li>
                    @if ($loop->last)
                        <li><a href="mailto:?body={{ __('message.share_message_text', ['type' => $typeLabel])}}%0D%0A{{$shareUrl}}"><em class="icon-email"></em></a></li>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/class-list.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/booking-operations.js')}}"></script>
@endpush