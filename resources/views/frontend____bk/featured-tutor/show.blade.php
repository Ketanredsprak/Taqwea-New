@extends('layouts.frontend.app')
@section('title', __('labels.tutor_detail'))
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
@section('content')
<main class="mainContent">
    <div class="detailPage detailPage--tutorDetail bg-green commonPad">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tutors') }}">{{ __('labels.tutors') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.tutor_detail') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.tutor_detail') }}</h3>
            </div>
        </section>
        <section class="detailPageCnt">
            <div class="detailPageCnt__inner">
                <div class="subject">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="subject__left commonBox">
                                    <div class="subject__info">
                                        <div class="d-sm-flex d-block">
                                            <div class="view">
                                                <div class="label">{{__('labels.experience')}}</div>
                                                <div class="cnt">{{ @$user->tutor->experience }}<span>{{ (@$user->tutor->experience)?'+':'' }}</span></div>
                                            </div>
                                            <div class="view">
                                                <div class="label">{{__('labels.classes')}}</div>
                                                <div class="cnt">{{ @$user->total_classes }}</div>
                                            </div>
                                            <div class="view">
                                                <div class="label">{{__('labels.webinars')}}</div>
                                                <div class="cnt">{{ @$user->total_webinars }}</div>
                                            </div>
                                            <div class="view">
                                                <div class="label">{{__('labels.blogs')}}</div>
                                                <div class="cnt">{{ @$user->total_blogs }}</div>
                                            </div>

                                        </div>
                                    </div>
                                    <h5 class="h-24 mb-0">{{ __('labels.bio') }}</h5>
                                    <div class="subject__moreInfo">
                                        <p class="more mb-0">
                                            {{ @$user->translateOrDefault()->bio }}
                                        </p>

                                    </div>
                                    <div class="subject__moreDetail">
                                        <div class="subject__educationDetail">
                                            <h5 class="h-24">{{ __('labels.education') }}</h5>
                                            <p>{{ __('labels.levels') }}</p>
                                            <ul class="list-unstyled">
                                                @forelse(@$user->levels as $level)
                                                <li><span>{{ $level->translateOrDefault()->name }}</span></li>
                                                @empty

                                                @endforelse
                                            </ul>
                                            <p>{{ __('labels.grades') }}</p>
                                            <ul class="list-unstyled">
                                                @forelse(@$user->grades as $grade)
                                                <li><span>{{ $grade->translateOrDefault()->grade_name }}</span></li>
                                                @empty

                                                @endforelse
                                            </ul>
                                            <p>{{ __('labels.subjects') }}</p>
                                            <ul class="list-unstyled">
                                                @forelse(@$user->subjects as $subject)
                                                <li><span>{{ $subject->translateOrDefault()->subject_name }}</span></li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                        <div class="subject__educationDetail">
                                            <h5 class="h-24">{{ __('labels.general_knowledge') }}</h5>
                                            <p>{{ __('labels.levels') }}</p>
                                            <ul class="list-unstyled">
                                                @forelse(@$user->generalKnowledge as $gk)
                                                <li><span>{{ $gk->translateOrDefault()->name }}</span></li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                        <div class="subject__educationDetail">
                                            <h5 class="h-24">{{ __('labels.languages') }}</h5>
                                            <p>{{ __('labels.language') }}</p>
                                            <ul class="list-unstyled">
                                                @forelse(@$user->languages as $language)
                                                <li><span>{{ $language->name }}</span></li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="subject__experience commonBox">
                                    <h5 class="h-24">{{ __('labels.education') }}</h5>
                                    <div class="subject__education">
                                        <div class="table-responisve">
                                            <table>
                                                <tr>
                                                    <th>{{__('labels.degree')}}</th>
                                                    <th>{{__('labels.university')}}</th>
                                                </tr>
                                                @forelse(@$user->educations as $education)
                                                <tr>
                                                    <td>{{ $education->translateOrDefault()->degree }}</td>
                                                    <td>{{ $education->translateOrDefault()->university }}</td>
                                                </tr>
                                                @empty

                                                @endforelse
                                            </table>
                                        </div>
                                    </div>
                                    <h5 class="h-24">{{ __('labels.certificate') }}</h5>
                                    <div class="subject__education">
                                        <ul class="list-unstyled mb-0">
                                            @forelse(@$user->certificates as $certificate)
                                            <li>{{ $certificate->translateOrDefault()->certificate_name }}</li>
                                            @empty

                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="subject__right commonBox">
                                    <div class="tutorInfo">
                                        <div class="tutorInfo__img">
                                            <img src="{{ $user->profile_image_url }}" alt="Lindsay Marsh">
                                        </div>
                                        <div class="tutorInfo__name">
                                            {{ $user->translateOrDefault()->name }}
                                        </div>
                                        <div class="tutorInfo__ratingSec d-flex align-items-center justify-content-center">
                                            <div class="rateStar w-auto" data-rating="{{$user->rating}}"></div>
                                        </div>

                                    </div>
                                    <div class="scheduleBtn">
                                        <a class="btn btn-primary ripple-effect btn-lg" href="{{route('classes.schedules')}}?tutor={{ Crypt::encrypt($user->id) }}" tabindex="0">{{ __('labels.check_schedule_classes') }}</a>
                                    </div>
                                </div>
                                <div class="subject__video commonBox p-0">
                                    <img src="{{ @$user->tutor->introduction_video_thumb }}" class="videoImg" alt="video-img">
                                    <a class="playIcon" href="javascript:void(0);" tabindex="0" data-toggle="modal" data-target="#videoModal">
                                        <img src="{{ asset('assets/images/play-icon.png') }}" alt="play-icon">
                                    </a>
                                </div>
                                <div class="subject__ratings commonBox">
                                    <h5 class="h-24">{{ __('labels.ratings') }}</h5>
                                    <div class="ratingCommentBox" nice-scroll>
                                        @forelse($ratingReviews as $ratingReview)
                                        <div class="ratingCommentBox__box">
                                            <div class="d-flex">
                                                <div class="userInfo">
                                                    <div class="userInfo__img">
                                                        <img src="{{ @$ratingReview->from->profile_image_url }}" alt="{{ @$ratingReview->from->name }}">
                                                    </div>
                                                </div>
                                                <div class="userView">
                                                    <div class="d-flex justify-content-between flex-wrap">
                                                        <div class="userView__cnt">
                                                            <h6 class="font-eb text-truncate">{{ @$ratingReview->from->translateOrDefault()->name }}</h6>
                                                            <p class="mb-0 font-rg">{{ @$ratingReview->from->email }}</p>
                                                        </div>
                                                        <div class="userView__ratingSec d-flex">
                                                            <div class="rateStar w-auto" data-rating="{{$ratingReview->rating}}"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ratingCommentBox__content">
                                                <p>{{ @$ratingReview->review }}</p>
                                            </div>
                                        </div>
                                        @empty

                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if(!empty($blogs) && ($blogs->count()>0))
        <section class="blogSilder bg-transparent">
            <div class="container">
                <div class="commonHead d-flex justify-content-between align-items-end flex-wrap">
                    <div class="commonHead-left">
                        <h2 class="commonHead_title font-eb">{{ __('labels.blogs') }}</h2>
                        <p class="textGray">{{ __('labels.you_are_in_the_drivers_seat') }}</p>
                    </div>
                    <div class="commonHead-right">
                        <a class="linkPrimary text-uppercase font-eb" href="{{ route('blogs').'?tutor_id='.Crypt::encryptString($user->id) }}">{{ __('labels.show_all') }}</a>
                    </div>
                </div>
                <div class="listSlider commonSlider">
                    @forelse($blogs as $blog)
                    <div class="listSlider-item">
                        <div class="gridList">
                            <div class="gridList__img">
                                <img src="{{ $blog->media_thumb_url }}" alt="Quantum Computing & Quantum Physics For Beginners" class="img-fluid" />
                            </div>
                            <div class="gridList__cnt">
                                <h4 class="gridList__title"><a href="{{ route('blog/show', ['blog' => $blog->slug]) }}" class="linkBlack">{{ $blog->translateOrDefault()->blog_title }}</a></h4>
                            </div>
                            <div class="gridList__footer d-flex justify-content-between align-items-center">
                                <div class="gridList__footer__left blogPrice">
                                    <span class="font-rg text-uppercase">{{ __('labels.sar') }} </span>
                                    <span class="font-eb">{{ number_format($blog->total_fees, 2) }}</span>
                                </div>
                                @if(Auth::check() && Auth::user()->isStudent())
                                <div class="gridList__footer__left">
                                    @if(@$blog->cart_item_count)
                                    <button class="btn btn-primary ripple-effect" disabled>{{ __('labels.add_to_cart') }}</button>
                                    @else
                                    @if(Auth::check())
                                    <button class="btn btn-primary ripple-effect" onclick="addToCart($(this), {{ $blog->id }}, 'blog')">{{ __('labels.add_to_cart') }}</button>
                                    @else
                                    <a href="{{ route('show/login').'?item_id='.Crypt::encryptString($blog->id).'&item_type=blog' }}" class="btn btn-primary ripple-effect">{{ __('labels.add_to_cart') }}</a>
                                    @endif
                                    @endif
                                </div>
                                @elseif(!Auth::check())
                                <div class="gridList__footer__left">
                                    <a href="{{ route('show/login').'?item_id='.Crypt::encryptString($blog->id).'&item_type=blog' }}" class="btn btn-primary ripple-effect">{{ __('labels.add_to_cart') }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty

                    @endforelse
                </div>
            </div>
        </section>
        @endif
    </div>
</main>
<!-- video modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--videoMsg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="videoInfo">
                    <video controls id="video1" style="width: 100%; height: auto; margin:0 auto; frameborder:0;">
                        <source src="{{ $user->tutor->introduction_video_url }}" type="video/mp4" />
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/cart.js')}}"></script>
@endpush