<ul class="list-unstyled commonList mb-0">
    @forelse ($classes as $class)
    <li class="commonList-item common-shadow d-md-flex bg-white">
        @if($class->class_type=='class')
        @php $href = route('classes/show', ['class' => $class->slug]) @endphp
        @else
        @php $href = route('webinars/show', ['class' => $class->slug]) @endphp
        @endif
        <div class="commonList-item_img position-relative">
            <a href="{{$href}}">
                <img src="{{ $class->class_image_url }}" alt="list-image">
            </a>
            @if(@$class->subject->subject_name)
            <span class="commonTag text-uppercase">{{ $class->subject->translateOrDefault()->subject_name }}</span>
            @endif
            <div class="userInfo">
                <span class="font-sm">{{ $class->tutor->translateOrDefault()->name }}</span>
            </div>
        </div>
        <div class="commonList-item_info">
            <div class="d-flex justify-content-between">
                <a href="{{$href}}" class="linkBlack">
                    <h5 class="font-bd mb-0">{{ $class->translateOrDefault()->class_name }}</h5>
                </a>
                <div class="price">{{ __('labels.sar') }}  <span class="font-eb">{{ (!empty($class->total_fees))?number_format($class->total_fees, 2): number_format(round(($class->duration/60)*$class->hourly_fees,2),2) }}</span></div>
            </div>
            <div class="textGray my-3">
                @if($class->class_type=='class')
                {{ @$class->bookings_count }}/5 {{__('labels.students')}} <span class="dot">&#183;</span>
                @endif

                {{ getDuration($class->duration) }}
                {{__('labels.duration')}}
            </div>
            <div class="my-3" dir="{{config('constants.date_format_direction')}}"><span class="font-bd">{{ convertDateToTz($class->start_time, 'UTC', 'd M Y') }}</span> {{ convertDateToTz($class->start_time, 'UTC', 'h:i A') }}</div>
            <div class="btnRow">
                <a href="{{ $href }}" class="btn btn-primary ripple-effect">{{__('labels.view_details')}}</a>
                @php $check = checkClassBlogBooked(@$class->id, 'class') @endphp
                @if($check)
                    @if(in_array(@$class['bookings'][0]['status'], ['confirm', 'pending']))
                    <a href="Javascript:void(0)" onclick="cancelBooking($(this),'{{@$class['bookings'][0]['id']}}',true)" class="btn btn-primary btn-primary--outline ripple-effect">{{__('labels.cancel')}}</a>
                    @endif
                @else
                    @if(@$class->cart_item_count)
                    <button class="btn btn-primary--outline ripple-effect-dark" disabled>{{ __('labels.add_to_cart') }}</button>
                    @else
                    @if(Auth::check())
                    <button class="btn btn-primary--outline ripple-effect-dark add-to-cart disabled" data-start-time="{{ classBookingBefore($class->start_time) }}" onclick="addToCart($(this), {{ $class->id }}, 'class')">{{ __('labels.add_to_cart') }}</button>
                    @else
                    <a href="{{ route('show/login').'?item_id='.Crypt::encryptString($class->id).'&item_type=class' }}" class="btn btn-primary--outline ripple-effect-dark">{{ __('labels.add_to_cart') }}</a>
                    @endif
                    @endif
                @endif
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
        <div id="pagination"> {{ $classes->links() }}</div>
    </nav>
</div>