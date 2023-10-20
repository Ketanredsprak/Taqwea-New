
<ul class="list-unstyled mb-0 userList-Box" nice-scroll id="userListBox">
    @forelse($messageList as $list)    
    <li class="userList-searchBox d-flex justify-content-between align-items-center" data-chat_id="{{$list->uuid}}" >
        <div class="userInfo d-flex align-items-center">
            <div class="userInfo-userImg">
            <img src="{{ $list->tutor->profile_image_url }}" alt="{{ $list->tutor->name }}" class="img-fluid" />
            </div>
            <div class="userInfo-userDetail">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="userInfo-userCnt">
                    <h5 class="font-bd text-truncate className">{{ $list->class->class_name }}</h5>
                    <p class="mb-0 font-sm">{{ $list->tutor->name }}</p> 
                </div>
                <span class="bagde" style="display:{{($list->messages_count)?'block':'none'}}">
                {{$list->messages_count}}
                </span>
            </div>
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

