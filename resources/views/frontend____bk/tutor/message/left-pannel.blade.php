<ul class="list-unstyled mb-0 userList-Box" nice-scroll id="userListBox">
    @forelse($messageList as $list)    
        <li class="userList-searchBox d-flex justify-content-between align-items-center" data-chat_id="{{$list->uuid}}" data-chat-user="{{$list->student->id}}">
            <div class="userInfo d-flex align-items-center">
                <div class="userInfo-userImg">
                <img src="{{ $list->student->profile_image_url }}" alt="{{ $list->student->name }}" class="img-fluid" />
                </div>
                <div class="userInfo-userDetail">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="userInfo-userCnt">
                        <h5 class="font-bd text-truncate">{{ $list->student->name }}</h5>
                        <p class="mb-0 font-sm className">{{ $list->class->class_name }}</p> 
                    </div>
                    <span class="bagde" style="display:{{($list->messages_count)?'block':'none'}}">
                    @if($list->messages_count)
                    {{$list->messages_count}}
                    @endif
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

