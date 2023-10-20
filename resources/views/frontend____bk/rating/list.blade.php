<div class="ratingCommentBox" nice-scroll>
    @forelse($ratings as $rating)
   
    <div class="ratingCommentBox__box">
        <div class="d-flex">
            <div class="userInfo">
                <div class="userInfo__img">
                    @if($params['rating_type'] == 'received')
                    <img src="{{@$rating->from->profile_image_url}}" alt="{{@$rating->from->name}}">
                    @else
                    <img src="{{@$rating->to->profile_image_url}}" alt="{{@$rating->to->name}}">
                    @endif
                </div>
            </div>
            <div class="userView">
                <div class="d-flex justify-content-between flex-wrap">
                        <div class="userView__cnt">
                            @if($params['rating_type'] == 'received')
                            <h6 class="font-bd text-truncate">{{@$rating->from->translateOrDefault()->name}}</h6>
                            <p class="mb-0 font-rg">{{@$rating->from->email}}</p>
                            @else
                            <h6 class="font-bd text-truncate">{{@$rating->to->translateOrDefault()->name}}</h6>
                            <p class="mb-0 font-rg">{{@$rating->to->email}}</p>
                            @endif
                        </div>
                        @if($params['rating_type'] == 'given' && Auth::user()->isStudent())
                            <a href="{{route('student.feedback.index', ['class' =>@$rating->class->id])}}">
                            @endif
                            @if($params['rating_type'] == 'received' && Auth::user()->isTutor())
                            <a href="{{route('tutor.received.feedback.index', ['class' =>@$rating->class->id, 'receiverId' => @$rating->from->id ])}}">
                            @endif
                        <div class="userView__ratingSec">
                            <p class="font-sm" dir="{{config('constants.date_format_direction')}}">{{ convertDateToTz($rating->created_at, 'UTC', 'd M Y') }}</p>
                            <div class="d-flex">
                            
                                <div class="rateStar w-auto" data-rating="{{$rating->rating}}"></div>
                            </div>

                        </div>
                        @if(($params['rating_type'] == 'given' && Auth::user()->isStudent())
                        || ($params['rating_type'] == 'received' && Auth::user()->isTutor()))
                        </a>
                        @endif
                </div>
            </div>
        </div>
        <div class="ratingCommentBox__content">
            <h6 class="font-bd">{{@$rating->class->translateOrDefault()->class_name}}</h6>
            <p>{{$rating->review}}</p>
        </div>
    </div>
   
    @empty
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
        </div>
    </div>
    @endforelse
</div>
<div class="d-flex align-items-center paginationBottom justify-content-end ">
    <nav aria-label="Page navigation example ">
        <div id="pagination"> {{ $ratings->links() }}</div>
    </nav>
</div>
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        ratingList(url);
    });
</script>
