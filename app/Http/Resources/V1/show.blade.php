@extends('layouts.frontend.app')
@if ($type == 'class')
    @section('meta-title-facebook', __('labels.blog_details'))
@else
    @section('title', __('labels.webinar_detail'))
@endif
@section('title', $class->translateOrDefault()->class_name)
@section('meta-description-facebook')
    {!! $class->translateOrDefault()->class_detail !!}
@endsection
@section('meta-image-facebook', $class->class_image_url)
@section('meta-keywords-url', $url)
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
@section('content')
    <main class="mainContent">
        <div class="detailPage detailPage--classDetail bg-green">
            <section class="pageTitle">
                <div class="container">
                    <div class="commonBreadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                                <li class="breadcrumb-item">
                                    @if ($type == 'class')
                                        <a href="{{ route('classes') }}">{{ __('labels.classes_list') }}</a>
                                    @else
                                        <a href="{{ route('webinars') }}">{{ __('labels.webinars_list') }}</a>
                                    @endif

                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    @if ($type == 'class')
                                        {{ __('labels.class_detail') }}
                                    @else
                                        {{ __('labels.webinar_detail') }}
                                    @endif
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <h3 class="h-32 pageTitle__title">
                        @if ($type == 'class')
                            {{ __('labels.class_detail') }}
                        @else
                            {{ __('labels.webinar_detail') }}
                        @endif
                    </h3>
                </div>
            </section>
            {{-- @dd($class); --}}
            <section class="detailPageCnt">
                <div class="detailPageCnt__inner">
                    <div class="subject">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="subject__left commonBox">
                                        <h3 class="heading h-32">{{ $class->translateOrDefault()->class_name }}</h3>
                                        <p>{{ $class->translateOrDefault()->class_detail }}</p>
                                        <div class="subject__info">
                                            <div class="d-sm-flex d-block">
                                                @if ($class->class_type == 'class')
                                                    <div class="view">
                                                        <div class="label">{{ __('labels.students') }}</div>
                                                        <div class="cnt">{{ @$class->bookings_count }}<span>/</span>5
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="view">
                                                    <div class="label">{{ __('labels.duration') }}</div>
                                                    <div class="cnt">
                                                        {{ getDuration($class->duration) }}
                                                    </div>
                                                </div>
                                                <div class="view">
                                                    <div class="label">{{ __('labels.topics') }}</div>
                                                    <div class="cnt">{{ count($class->topics) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="subject__classInfo">
                                            <h5 class="h-24">{{ __('labels.class_detail') }}</h5>
                                            @if (@$class->category->name)
                                                <div class="info d-flex">
                                                    <p class="info__title mb-0">{{ __('labels.category') }}</p>
                                                    <span
                                                        class="info__view">{{ @$class->category->translateOrDefault()->name }}</span>
                                                </div>
                                            @endif
                                            @if (@$class->level->name)
                                                <div class="info d-flex">
                                                    @if ($class->category->handle === 'education')
                                                        <p class="info__title mb-0">{{ __('labels.level') }}</p>
                                                    @elseif($class->category->handle === 'language')
                                                        <p class="info__title mb-0">{{ __('labels.language') }}</p>
                                                    @else
                                                        <p class="info__title mb-0">{{ __('labels.domain') }}</p>
                                                    @endif
                                                    <span
                                                        class="info__view">{{ @$class->level->translateOrDefault()->name }}</span>
                                                </div>
                                            @endif
                                            @if (@$class->grade->grade_name)
                                                <div class="info d-flex">
                                                    <p class="info__title mb-0">{{ __('labels.grade') }}</p>
                                                    <span
                                                        class="info__view">{{ @$class->grade->translateOrDefault()->grade_name }}</span>
                                                </div>
                                            @endif
                                            @if (@$class->subject->subject_name)
                                                <div class="info d-flex">
                                                    <p class="info__title mb-0">{{ __('labels.subject_expertise') }}</p>
                                                    <span
                                                        class="info__view">{{ @$class->subject->translateOrDefault()->subject_name }}</span>
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
                                                    <div class="accordion-head w-100 text-left bg-white"
                                                        data-target="#faq-q{{ $key }}" data-toggle="collapse">
                                                        @if ($key == 0)
                                                            <h5 class="h-24">{{ __('labels.topics_list') }}</h5>
                                                        @endif
                                                        <div class="action">
                                                            <buttton class="accordion-icon" data-toggle="collapse"
                                                                data-target="#faq-q{{ $key }}"
                                                                title="{{ __('labels.view_answer') }}">
                                                                {{ $loop->iteration }}:
                                                                {{ $topic->translateOrDefault()->topic_title }}
                                                            </buttton>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-body collapse {{ $key == 0 ? 'show' : '' }}"
                                                        data-parent="#faqs" id="faq-q{{ $key }}">
                                                        <div class="accordion-inner">
                                                            <p>
                                                                {{ $topic->translateOrDefault()->topic_description }}
                                                            </p>
                                                            <ul class="list-unstyled">
                                                                @forelse(@$topic->subTopics as $subTopic)
                                                                    @if ($subTopic->sub_topic && @$subTopic->translations[0]->language == config('app.locale'))
                                                                        <li>{{ $subTopic->translateOrDefault()->sub_topic }}
                                                                        </li>
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
                                        <!-- <div class="btn-row text-center">
                                                <a href="javascript:void(0);" class="show-more text-uppercase h-16">Show
                                                    Less</a>
                                            </div> -->
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="subject__right subject--box commonBox">
                                        <div class="classImg">
                                            <img src="{{ $class->class_image_url }}"
                                                alt="{{ @$class->tutor->translateOrDefault()->name }}"
                                                class="img-fluid class-img" />
                                            <div class="teacherInfo d-flex align-items-center justify-content-between">
                                                <div class="teacherInfo__left">
                                                    <div class="userInfo d-flex align-items-center">
                                                        <div class="userInfo__img">
                                                            <img src="{{ @$class->tutor->profile_image_url }}"
                                                                alt="{{ @$class->tutor->translateOrDefault()->name }}">
                                                        </div>
                                                        <div class="userInfo__name text-truncate">
                                                            {{ @$class->tutor->translateOrDefault()->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="teacherInfo__right">
                                                    <a href="javascrpit:void(0);" data-toggle="modal"
                                                        data-target="#shareModal"
                                                        class="d-flex align-items-center justify-content-center shareLink"><em
                                                            class="icon-share"></em></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="amountInfo d-flex justify-content-between">
                                            <div class="amountInfo__left">{{ __('labels.amount') }}</div>
                                            <div class="amountInfo__right">{{ __('labels.sar') }} <span
                                                    style="text-transform: text-uppercase;">{{ !empty($class->total_fees) ? number_format($class->total_fees, 2) : number_format(round(($class->duration / 60) * $class->hourly_fees, 2), 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="dateTime d-flex align-items-center">
                                            <em class="icon-calender"></em>
                                            <p class="mb-0" dir="{{ config('constants.date_format_direction') }}">
                                                {{ convertDateToTz($class->start_time, 'UTC', 'd M Y') }}<span>
                                                    {{ convertDateToTz($class->start_time, 'UTC', 'h:i A') }}</span></p>
                                        </div>
                                        <div class="btnRow d-flex justify-content-between">



                                            @php
                                                $genderBooking = true;
                                                if (Auth::check()) {
                                                    $genderBooking = $class->gender_preference == 'both' || $class->gender_preference == Auth::user()->gender ? true : false;
                                                }
                                            @endphp

                                            @if (!$genderBooking)
                                                <div class="col-12">
                                                    <div class="alert alert-danger">
                                                        {{ __('error.class_booking_gender_wise', ['gender' => $class->gender_preference, 'class' => $class->class_type]) }}
                                                    </div>
                                                </div>
                                            @endif


                                            @if ($class->status == 'completed')
                                                @dd('1');
                                                <a class="btn btn-primary btn-primary--outline ripple-effect btn-lg"
                                                    href="{{ route('student.feedback.index', ['class' => $class->id]) }}"
                                                    tabindex="0">{{ __('labels.my_feedback') }}</a>
                                                @if ($isChat)
                                                    <a class="btn btn-primary ripple-effect btn-lg"
                                                        href="{{ route('message-student') }}?class={{ $class->id }}"
                                                        tabindex="0">{{ __('labels.chat') }}</a>
                                                @else
                                                    <a class="btn btn-primary ripple-effect btn-lg disabled"
                                                        tabindex="0">{{ __('labels.chat') }}</a>
                                                @endif
                                            @elseif($isBooked && $genderBooking && in_array(@$class['bookings'][0]['status'], ['confirm']))
                                                @dd('2');
                                                @if ($class->status == 'active')
                                                    <a class="btn btn-primary ripple-effect btn-lg w-100 mr-2 join-now disabled"
                                                        data-start-time="{{ $class->start_time }}"
                                                        href="{{ route('student.join', ['slug' => $class->slug]) }}"
                                                        tabindex="0">{{ __('labels.join_now') }}</a>
                                                @endif
                                                @if (in_array(@$class['bookings'][0]['status'], ['confirm', 'pending']))
                                                    <a href="Javascript:void(0)"
                                                        onclick="cancelBooking($(this),{{ @$class['bookings'][0]['id'] }})"
                                                        class="btn btn-primary btn-primary--outline ripple-effect btn-lg cancel-btn-disabled">{{ __('labels.cancel') }}</a>
                                                @endif
                                            @elseif($genderBooking)
                                                {{-- @dd('3'); --}}
                                                @if ((Auth::check() && !empty(@$class->cartItem)) || !$class->is_booking)
                                                @dd("4");
                                                <button
                                                class="btn btn-primary btn-primary--outline ripple-effect btn-lg add-to-cart"
                                                data-start-time="{{ classBookingBefore($class->start_time) }}"
                                                tabindex="0" disabled>{{ __('labels.add_to_cart') }}</button>
                                                @elseif(Auth::check())
                                                @dd("5");
                                                <button
                                                class="btn btn-primary btn-primary--outline ripple-effect btn-lg add-to-cart disabled"
                                                data-start-time="{{ classBookingBefore($class->start_time) }}"
                                                tabindex="0"
                                                onclick="addToCart($(this), {{ $class->id }}, 'class')">{{ __('labels.add_to_cart') }}</button>
                                                @else
                                                @dd("6");
                                                <a href="{{ route('show/login') . '?item_id=' . Crypt::encryptString($class->id) . '&item_type=class' }}"
                                                        class="btn btn-primary--outline ripple-effect btn-lg">{{ __('labels.add_to_cart') }}</a>
                                                @endif


                                                @if (Auth::check() && $class->status == 'active')
                                                    <a class="btn btn-primary ripple-effect btn-lg booking-disabled"
                                                        href="{{ route('student.checkout.index') . '?class_id=' . Crypt::encryptString($class->id) }}"
                                                        tabindex="0">{{ __('labels.book_now') }}</a>
                                                @elseif (!Auth::check())
                                                    <a href="{{ route('show/login') . '?item_id=' . Crypt::encryptString($class->id) . '&item_type=class' }}"
                                                        class="btn btn-primary--outline ripple-effect btn-lg">{{ __('labels.book_now') }}</a>
                                                @else
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary--outline ripple-effect btn-lg disabled">{{ __('labels.book_now') }}</a>
                                                @endif

                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="tutorProfile">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="h-32">{{ __('labels.tutor_profile') }}</h3>
                        </div>
                        <div class="col-lg-3">
                            <div class="tutorProfile__left">
                                <div class="tutorProfile__teacherImg">
                                    <img src="{{ @$class->tutor->profile_image_url }}"
                                        alt="{{ __('labels.tutor_profile') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="tutorProfile__right">
                                <h4 class="h-24">{{ @$class->tutor->translateOrDefault()->name }}</h4>
                                <div class="d-flex align-items-center justify-content-lg-start justify-content-center">
                                    <div class="rateStar w-auto"
                                        data-rating="{{ @$class->rating->rating ? @$class->rating->rating : '0' }}"></div>
                                </div>
                                <p>{{ @$class->tutor->translateOrDefault()->bio }}</p>
                                <a class="btn btn-primary ripple-effect"
                                    href="{{ route('featured.tutors.show', ['tutor' => $class->tutor_id]) }}"
                                    tabindex="0">{{ __('labels.view_profile') }}</a>
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
                    <h5 class="modal-title">{{ __('labels.share_now') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @forelse ($shareLinks as $provider => $link)
                        @if ($loop->first)
                            <ul class="list-unstyled">
                                <li><a id="copy" data-clipboard-text="{{ $url }}"
                                        href="javascript:void(0);"><em class="icon-copy"></em></a></li>
                        @endif
                        <li><a target="_blank" href="{{ $link }}"><em
                                    class="icon-{{ $provider }}"></em></a></li>
                        @if ($loop->last)
                            <li><a
                                    href="mailto:?body={{ __('message.share_message_text', ['type' => $typeLabel]) }}%0D%0A{{ $url }}"><em
                                        class="icon-email"></em></a></li>
                            </ul>
                        @endif
                    @empty
                        <div class="alert alert-danger">{{ __('message.no_sharing_options_configured') }}</div>
                    @endforelse
                </div>
                <div class="modal-footer border-top-0 justify-content-center">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/class-detail.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/student/cart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/booking-operations.js') }}"></script>
@endpush
