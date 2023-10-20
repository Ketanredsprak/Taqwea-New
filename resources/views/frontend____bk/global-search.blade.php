@if(!empty($globalSearchs) && count($globalSearchs))
<ul class="list-unstyled mb-0">
    @foreach($globalSearchs as $search)
        @if($search->class_type != 'blog' && $search->class_type != 'featured')
            @if($search->class_type=='class')
            @php $url = route('classes/show', ['class' => $search->slug]) @endphp
            @else
            @php $url = route('webinars/show', ['class' => $search->slug]) @endphp
            @endif
        @elseif($search->class_type == 'blog')
            @php $url = route('blog/show', ['blog' => $search->slug]) @endphp
        @elseif($search->class_type == 'featured')
            @php $url = route('featured.tutors.show', ['tutor' => $search->id]) @endphp
        @endif
        <li>
            <a href="{{$url}}">
            <div class="searchListInner d-flex align-items-center common-shadow">
                <div class="searchList__leftImg">
                    @if( $search->class_type == 'blog')
                    <img src="{{getThumbnailUrl($search->image_url, $search->type)}}" class="img-fluid" />
                    @else
                    <img src="{{getImageUrl($search->image_url)}}" class="img-fluid" />
                    @endif
                </div>
                <div class="searchList__rightText"> 
                    <p>{{$search->name}}</p>
                </div>
            </div>
            </a>
        </li>
    @endforeach
</ul>
@else
<div class="">
    <div class="alert alert-danger mb-0">{{ __('labels.record_not_found') }}</div>
</div>
@endif
