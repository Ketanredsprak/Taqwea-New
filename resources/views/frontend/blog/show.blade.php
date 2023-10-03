@extends('layouts.frontend.app')
@section('title', __('labels.blog_details'))
@section('meta-title-facebook', $blog->translateOrDefault()->blog_title)
@section('meta-description-facebook')
{!! $blog->translateOrDefault()->blog_description !!}
@endsection
@section('meta-image-facebook', $blog->media_url)
@section('meta-keywords-url', $url)
@section('content')
<main class="mainContent">
    <div class="detailPage detailPage--blogDetail commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blogs') }}">{{ __('labels.blogs') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.blog_details') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.blog_details') }}</h3>
            </div>
        </section>
        <section class="blogDetailPageCnt">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="blogDetailPageCnt--left commonBox">
                            <h3 class="heading h-32">{{ $blog->blog_title }}</h3>
                            <h4 class="txt font-eb">{{ __('labels.blog_details') }}</h4>
                            <div class="subject">
                                <div class="subject__classInfo">
                                    <div class="info d-flex">
                                        <p class="info__title mb-0">{{ __('labels.category') }}</p>
                                        <span class="info__view">{{ @$blog->category->name }}</span>
                                    </div>
                                    
                                    @if(@$blog->level->name)
                                    <div class="info d-flex">
                                        <p class="info__title mb-0">
                                            @if(@$blog->category->handle=='education')
                                            {{ __('labels.class_level') }}
                                            @elseif(@$blog->category->handle=='general-knowledge')
                                            {{ __('labels.domain') }}
                                            @elseif(@$blog->category->handle=='language')
                                            {{ __('labels.language') }}
                                            @endif
                                        </p>
                                        <span class="info__view">{{ @$blog->level->name }}</span>
                                    </div>
                                    @endif
                                    @if(@$blog->grade->grade_name)
                                    <div class="info d-flex">
                                        <p class="info__title mb-0">{{ __('labels.grade') }}</p>
                                        <span class="info__view">{{ @$blog->grade->grade_name }}</span>
                                    </div>
                                    @endif
                                    @if(@$blog->subject->subject_name)
                                    <div class="info d-flex">
                                        <p class="info__title mb-0">{{ __('labels.subject_expertise') }}</p>
                                        <span class="info__view">{{ @$blog->subject->subject_name }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <p>{!! $blog->blog_description !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blogDetailPageCnt--right box commonBox">
                            <div class="classImg">
                                @php $check = checkClassBlogBooked(@$blog->id, 'blog') @endphp
                                @if($blog->type=='image')
                                <img src="{{ $blog->media_thumb_url }}" alt="class-room" class="img-fluid class-img" />
                                <a class=" playIcon {{ (!$check)?'showPurchaseMessage':'download' }}" data-slug='{{ $blog->slug }}' href="javascript:void(0)" >
                                    <img src="{{ asset('assets/images/download.png') }}" alt="download">
                                </a>
                                @elseif($blog->type=='document')
                                <img src="{{ $blog->media_thumb_url }}" alt="class-room" class="img-fluid class-img" />
                                <a class="  playIcon {{ (!$check)?'showPurchaseMessage':'download' }}" data-slug='{{ $blog->slug }}' href="javascript:void(0)" >
                                    <img src="{{ asset('assets/images/download.png') }}" alt="download">
                                </a>
                                @elseif($blog->type=='video')
                                <img src="{{ $blog->media_thumb_url }}" alt="class-room" class="img-fluid class-img" />
                                <a class="playIcon {{ ($check)?'showBlogContent download':'showPurchaseMessage' }}" data-slug='{{ $blog->slug }}' href="javascript:void(0);">
                                    <img src="{{ asset('assets/images/play-icon.png') }}" alt="play-icon">
                                </a>
                                @endif
                                <div class="teacherInfo d-flex align-items-center justify-content-between">
                                    <div class="teacherInfo__left">
                                        <div class="userInfo d-flex align-items-center">
                                            <div class="userInfo__img">
                                                <img src="{{ $blog->tutor->profile_image_url }}" alt="Lindsay Marsh">
                                            </div>
                                            <div class="userInfo__name text-truncate">
                                                {{ $blog->tutor->name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="teacherInfo__right">
                                        <a href="javascrpit:void(0);" data-toggle="modal" data-target="#shareModal" class="d-flex align-items-center justify-content-center shareLink"><em class="icon-share"></em></a> 
                                    </div>
                                </div>
                            </div>
                            <div class="amountInfo d-flex justify-content-between">
                                <div class="amountInfo__left">{{ __('labels.amount') }}</div>
                                <div class="amountInfo__right text-uppercase">{{ __('labels.sar') }}  <span>{{ number_format($blog->total_fees, 2) }}</span></div>
                            </div>
                            <div class="btnRow d-flex justify-content-between">
                                @if($check)
                                <!-- If blog already booked -->
                                @else
                                @if(Auth::check())
                                <button class="btn btn-primary--outline ripple-effect btn-lg" tabindex="0" onclick="addToCart($(this), {{ $blog->id }}, 'blog')">{{ __('labels.add_to_cart') }}</button>
                                <a class="btn btn-primary ripple-effect btn-lg" href="{{ route('student.checkout.index').'?blog_id='.Crypt::encryptString($blog->id) }}" tabindex="0">{{ __('labels.book_now') }}</a>

                                @else
                                <a href="{{ route('show/login').'?item_id='.Crypt::encryptString($blog->id).'&item_type=blog' }}" class="btn btn-primary--outline ripple-effect btn-lg">{{ __('labels.add_to_cart') }}</a>
                                <a class="btn btn-primary ripple-effect btn-lg" href="{{ route('show/login').'?item_id='.Crypt::encryptString($blog->id).'&item_type=blog' }}" tabindex="0">{{ __('labels.book_now') }}</a>

                                @endif

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<!-- video modal -->
@if($blog->type=='video' && $check)
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--videoMsg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="videoInfo">
                    <video controls id="video1" style="width: 100%; height: auto; margin:0 auto; frameborder:0;">
                        <source src="{{ $blog->media_url }}" type="video/mp4" />
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>
@endif



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
                        <li><a id="copy" data-clipboard-text="{{$url}}" href="javascript:void(0);"><em class="icon-copy"></em></a></li>
                    @endif
                        <li><a target="_blank" href="{{$link}}"><em class="icon-{{$provider}}"></em></a></li>
                    @if ($loop->last)
                        <li><a href="mailto:?body={{ __('message.share_message_text', ['type' => __('labels.blog')])}}%0D%0A{{$url}}"><em class="icon-email"></em></a></li>
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
<script type="text/javascript" src="{{asset('assets/js/frontend/blog-detail.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/cart.js')}}"></script>
<script src="{{ asset('assets/js/frontend/share.js') }}"></script>
@endpush