@extends('layouts.tutor.app')
@section('title', __('labels.blog_details'))
@section('meta-title-facebook', $blog->translateOrDefault()->blog_title)
@section('meta-description-facebook')
{!! $blog->translateOrDefault()->blog_description !!}
@endsection
@section('meta-image-facebook', $blog->media_url)
@section('meta-keywords-url', $url)
@section('content')
<main class="mainContent">
    <div class="detailPage detailPage--blogPreview commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('labels.home')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tutor.blogs.index') }}">{{__('labels.my_blogs')}}</a></li>
                            <li class="breadcrumb-item active">{{__('labels.blog_preview')}}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{__('labels.blog_preview')}}</h3>
            </div>
        </section>
        <section class="detailPageCnt">
            <div class="detailPageCnt__inner">
                <div class="subject">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="subject__left commonBox">
                                    <h3 class="heading h-32">{{ $blog->translateOrDefault()->blog_title }}</h3>

                                    <div class="subject__moreInfo">
                                        <h5 class="h-24">{{ __('labels.blog_detail') }}</h5>
                                        <div class="subject">
                                            <div class="subject__classInfo">
                                                <div class="info d-flex">
                                                    <p class="info__title mb-0">{{ __('labels.category') }}</p>
                                                    <span class="info__view">{{ @$blog->category->translateOrDefault()->name }}</span>
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
                                                    <span class="info__view">{{ @$blog->level->translateOrDefault()->name }}</span>
                                                </div>
                                                @endif
                                                @if(@$blog->grade->grade_name)
                                                <div class="info d-flex">
                                                    <p class="info__title mb-0">{{ __('labels.grade') }}</p>
                                                    <span class="info__view">{{ @$blog->grade->translateOrDefault()->grade_name }}</span>
                                                </div>
                                                @endif
                                                @if(@$blog->subject->subject_name)
                                                <div class="info d-flex">
                                                    <p class="info__title mb-0">{{ __('labels.subject_expertise') }}</p>
                                                    <span class="info__view">{{ @$blog->subject->translateOrDefault()->subject_name }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="more mb-0">{!! $blog->translateOrDefault()->blog_description !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="subject__right subject--box commonBox">
                                    <div class="classImg">
                                        @if($blog->type=='image')
                                        <img src="{{ $blog->media_url }}" alt="class-room" class="img-fluid class-img" />
                                        @elseif($blog->type=='document')
                                        <img src="{{ $blog->media_url }}" alt="class-room" class="img-fluid class-img" />
                                        @elseif($blog->type=='video')
                                        <video controls style="height: 100%; width:100%;">
                                            <source src="{{ $blog->media_url }}" id="videoPreview" controls>
                                        </video>
                                        @endif
                                        <div class="teacherInfo d-flex align-items-center justify-content-end">
                                            <div class="teacherInfo__right">
                                                <a href="javascrpit:void(0);" data-toggle="modal" data-target="#shareModal" class="d-flex align-items-center justify-content-center shareLink"><em class="icon-share"></em></a> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="amountInfo d-flex justify-content-between">
                                        <div class="amountInfo__left">{{ __('labels.amount') }}</div>
                                        <div class="amountInfo__right text-uppercase"> {{ __('labels.sar') }}  <span>{{ number_format($blog->total_fees, 2) }}</span></div>
                                    </div>

                                    <div class="btnRow d-flex justify-content-between">
                                        <a class="btn btn-primary btn-primary--outline ripple-effect btn-lg" href="javascript:void(0)" onclick=" deleteBlog({{ $blog->id }}, '{{ route("tutor.blogs.index") }}')" tabindex="0">{{ __('labels.delete') }}</a>
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
@if(@$blog->type=='video')
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
<script >
    $(document).on('click', '.showBlogContent', function() {
        $("#videoModal").modal('show');
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/blog.js')}}"></script>
@endpush