<ul class="list-unstyled commonList mb-0">
    @forelse($blogs as $blog)

    <li class="commonList-item common-shadow d-md-flex bg-white">
        <div class="commonList-item_img position-relative">
            @if($blog->blog->type=='video')
            <video controls style="height: 100%; width:100%;">
                <source src="{{ $blog->blog->media_url }}" id="videoPreview" controls>
                Your browser does not support HTML5 video.
            </video>
            @else
            <img src="{{ $blog->blog->media_thumb_url }}" alt="{{ $blog->blog->translateOrDefault()->blog_title }}">
            @endif
            @if(isset($blog->blog->subject->name))
            <span class="commonTag text-uppercase">{{$blog->blog->subject->translateOrDefault()->name}}</span>
            @endif
            <div class="userInfo">
                <span class="font-sm">{{$blog->blog->tutor->translateOrDefault()->name}}</span>
            </div>
        </div>
        <div class="commonList-item_info">
            <div class="d-flex justify-content-between">
                <h5 class="font-bd mb-0">{{ $blog->blog->translateOrDefault()->blog_title }}</h5>
                <div class="price">{{ __('labels.sar') }} <span class="font-eb">{{ $blog->blog->total_fees }}</span></div>
            </div>
            
            <div class="dateTime" dir="{{config('constants.date_format_direction')}}"><span class="font-bd">{{ convertDateToTz($blog->created_at, 'UTC', 'd M Y') }}</span> {{ convertDateToTz($blog->created_at, 'UTC', 'h:i A') }}</div>
            <div class="btnRow">
                <a href="{{ route('blog/show', ['blog' => $blog->blog->slug]) }}" class="btn btn-primary ripple-effect">{{__('labels.view_details')}}</a>
            </div>
        </div>
    </li>
    @empty
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
        </div>
    </div>
    @endforelse
</ul>
<div class="d-flex align-items-center paginationBottom justify-content-end ">
    <nav aria-label="Page navigation example ">
        <div id="pagination"> {{ $blogs->links() }}</div>
    </nav>
</div>
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        blogList(url);
    });
</script>