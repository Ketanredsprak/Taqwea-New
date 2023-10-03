@if (!empty($data) && isset($data))


    <div class="chatBox common-shadow mx-auto">
        <div class="chatBox-head">
            <div class="d-flex">
                <div class="userInfo">
                    <div class="userInfo_img">
                        <img src="{{ $data->tutor->profile_image_url }}" alt="{{ $data->tutor->name }}">
                    </div>
                </div>
                <div class="userView">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="userView__cnt">
                        <h5 class="font-bd">{{ $data->class->class_name }}</h5>
                        <p class="mb-0 font-sm">{{ $data->tutor->name }}</p>
                    </div>
                    <div class="userView__time">
                        <p class="font-sm chat-now" data-date-time="{{\Carbon\Carbon::parse($data->created_at)->addDay(config('services.message_day'))}}">{{remainingChatDays($data->created_at)}}</p>
                        <div class="d-flex">
                            <div class="rateStar w-auto"></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="chatBox-body" id="chatDetailList" nice-scroll data-chat-user="{{$data->tutor->id}}" data-thread-uuid="{{$data->uuid}}">
            @foreach ($data->messages as $message)
                @if ($message->from_id == Auth::user()->id)
                    <div class="msgBox msgBox-send">
                        <div class="msgBox_body">
                            <div class="msgBox_body_textBox">{{$message->message}}</div>
                            <div class="d-flex justify-content-end">
                                <div class="msgBox_body_time">{{ convertDateToTz($message->created_at, 'UTC', 'd M Y h:i A') }}</div>
                                @if ($message->is_readed)
                                <span class="checkmark seen"></span>
                                @else
                                <span class="checkmark"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="msgBox msgBox-receive">
                        <div class="msgBox_body">
                            <div class="msgBox_body_textBox">{{$message->message}}</div>
                            <div class="msgBox_body_time" >{{ convertDateToTz($message->created_at, 'UTC', 'd M Y h:i A') }} </div>
                        </div>
                    </div>
                @endif
            @endforeach


        </div>
        <div class="chatBox-footer">
            <form action="javascript:void(0);">
                <div class="d-flex ">
                    <input type="hidden" class="form-control" id="sendMessage_fromId" name="fromId" value="{{$data->student->id}}">
                    <input type="hidden" class="form-control" id="sendMessage_toId" name="toId" value="{{$data->tutor->id}}">
                    <input type="hidden" class="form-control" id="sendMessage_thread_uuid" name="classId" value="{{$data->uuid}}">
                    <input type="hidden" class="form-control" id="sendMessage_thread_id" name="thread_id" value="{{$data->id}}">
                    <input type="text" class="form-control" dir="rtl"   id="sendMessage_message" name="message" placeholder="{{__('labels.type_here')}}">
                    <button class="btn btn-primary rounded-circle ripple-effect send_chat_message">
                    <span class="icon-send"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

@else
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">{{ __('labels.please_select_chat') }}</div>
        </div>
    </div>
@endif
