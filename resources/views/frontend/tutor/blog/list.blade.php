@forelse ($blogs as $blog )
<div class="col-lg-4 col-sm-6" id="blog-{{ $blog->id }}">
    <div class="gridList">
        <div class="gridList__img">
            <img src="{{ $blog->media_thumb_url }}" alt="{{ $blog->translateOrDefault()->blog_title }}" class="img-fluid" />
            @if(@$blog->subject->subject_name)
            <span class="commonTag text-uppercase">{{ $blog->subject->translateOrDefault()->subject_name }}</span>
            @endif
        </div>
        <div class="gridList__cnt">
            <a href="{{ route('tutor.blogs.detail', ['slug' => $blog->slug]) }}" class="linkBlack">
                <h4 class="gridList__title text-truncate">{{ $blog->translateOrDefault()->blog_title }}</h4>
            </a>
        </div>
        <div class="gridList__footer d-flex justify-content-between">
            <div class="gridList__footer__price">
                <div class="font-rg text-uppercase">
                {{ __('labels.sar') }}  <span class="font-eb">{{ number_format($blog->total_fees, 2) }}</span>
                </div>
            </div>
            <div class="gridList__footer__delete">
                <a href="javascript:void(0);" class="linkBlack" onclick="deleteBlog({{ $blog->id }})"> <em class="icon-delete"></em></a>
            </div>
        </div>
    </div>
</div>
@empty 
<div class="col-12">
    <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
</div>

@endforelse
<div class="col-12">
    <div class="d-flex align-items-center paginationBottom justify-content-end ">
        <nav aria-label="Page navigation example ">
            <div id="pagination"> {{ $blogs->links() }}</div>
        </nav>
    </div>
</div>
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        blogList(url);
    });
</script>