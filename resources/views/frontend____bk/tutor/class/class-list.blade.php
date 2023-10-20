<ul class="list-unstyled commonList mb-0">
    @forelse($classes as $class)
    <li class="commonList-item common-shadow d-md-flex bg-white">
        @if($class->class_type=='class')
        @php $url = route('tutor.classes.detail', ['slug' => $class->slug]) @endphp
        @else
        @php $url = route('tutor.webinars.detail', ['slug' => $class->slug]) @endphp
        @endif
        <div class="commonList-item_img position-relative">
            <a href="{{$url}}">
                <img src="{{ $class->class_image_url }}" alt="list-image">
            </a>
            @if(@$class->subject->subject_name)
            <span class="commonTag text-uppercase">{{ $class->subject->translateOrDefault()->subject_name }}</span>
            @endif
        </div>
        <div class="commonList-item_info">
            <div class="d-flex justify-content-between">                
                <a href="{{ $url }}" class="linkBlack">
                    <h5 class="font-bd mb-0">{{ $class->translateOrDefault()->class_name }}</h5>
                </a>
                <div class="price">{{ __('labels.sar') }}  <span class="font-eb">{{ (!empty($class->total_fees))? number_format($class->total_fees, 2): number_format(round(($class->duration/60)*$class->hourly_fees,2),2) }}</span></div>

            </div>
            <div class="textGray my-3">
                @if($class->class_type=='class')
                {{ @$class->bookings_count }}/5 {{__('labels.students')}} <span class="dot">&#183;</span>
                @else
                {{ @$class->bookings_count }} {{__('labels.students')}} <span class="dot">&#183;</span>
                @endif
                {{ getDuration($class->duration) }} {{__('labels.duration')}}
            </div>
            <div class="my-3" dir="{{config('constants.date_format_direction')}}">
                @if(!empty($class->start_time))
                <span class="font-bd">{{ convertDateToTz($class->start_time, 'UTC', 'd M Y') }}</span> {{ convertDateToTz($class->start_time, 'UTC', 'h:i A') }}
                @endif
            </div>
            @if($type=='upcoming' && $class->status=='active')
            <div class="btnRow">
                <a href="{{$url}}" class="btn btn-primary ripple-effect">{{ __('labels.view_details') }}</a>
                <a href="javascript:void(0);" class="btn btn-primary--outline ripple-effect" onclick="cancelClass($(this),{{ $class->id }},'{{$class->class_type}}',true)">{{ __('labels.cancel') }}</a>
            </div>
            @else
            <div class="btnRow d-flex justify-content-between align-items-end">
                <a href="{{ $url }}" class="btn btn-primary ripple-effect">{{__('labels.view_details')}}</a>
                <p class="font-bd mb-0 {{$class->status == 'completed' ? 'textSuccess' : 'textDanger'}} text-capitalize">{{__("labels.$class->status")}}</p>
            </div>
            @endif
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
        <div id="pagination"> {{ $classes->links() }}</div>
    </nav>
</div>
<script >
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        classList(url);
    });
</script>