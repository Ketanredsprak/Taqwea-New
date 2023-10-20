<ul class="list-unstyled commonList mb-0">
    @forelse ($blogs as $blog )
    <li class="commonList-item common-shadow d-md-flex bg-white">
        <div class="commonList-item_img commonList-item_img--sm position-relative">
            <img src="{{ $blog->media_thumb_url }}" alt="list-image">
            @if(@$blog->subject->subject_name)
            <span class="commonTag text-uppercase">{{ $blog->subject->subject_name }}</span>
            @endif
            <!-- <span class="commonTag text-uppercase">maths</span> -->
            <div class="userInfo">
                <span class="font-sm">{{ $blog->tutor->name }}</span>
            </div>
        </div>
        <div class="commonList-item_info d-flex flex-column">
            <div class="d-flex justify-content-between">
                <h5 class="font-bd mb-0">{{ $blog->blog_title }}</h5>
                <div class="price">{{ __('labels.sar') }}  <span class="font-eb">{{ number_format($blog->total_fees, 2) }}</span></div>
            </div>
            <div class="btnRow mt-3 mt-md-auto">
                @if(@$blog->cart_item_count)
                <button class="btn btn-primary--outline ripple-effect-dark" disabled>{{ __('labels.add_to_cart') }}</button>
                @else
                @if(Auth::check())
                <button class="btn btn-primary--outline ripple-effect-dark" onclick="addToCart($(this), {{ $blog->id }}, 'blog')">{{ __('labels.add_to_cart') }}</button>
                @else
                <a href="{{ route('show/login').'?item_id='.Crypt::encryptString($blog->id).'&item_type=blog' }}" class="btn btn-primary--outline ripple-effect-dark">{{ __('labels.add_to_cart') }}</a>
                @endif
                @endif
                <a href="{{ route('blog/show', ['blog' => $blog->slug]) }}" class="btn btn-primary ripple-effect ml-2">{{ __('labels.view_details') }}</a>
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