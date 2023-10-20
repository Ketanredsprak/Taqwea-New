@extends('layouts.tutor.app')
@section('title', $title)

@section('content')
<main class="">
    <div class="videoCallPage">
        <div class="videoBox d-flex">
            <div class="videoBox-left">
                <div class="videoBox-left-top d-flex align-items-center justify-content-between">
                    <div class="videoBox-head">
                        <h3 class="font-bd">{{ $class->translateOrDefault()->class_name }}</h3>
                        <div class="duration">
                            <span>{{count($class->topics)}} {{ (count($class->topics) > 1) ? __('labels.topics') : __('labels.topic') }}</span>
                            <span>{{ getDuration($class->duration) }} {{__('labels.duration')}}</span>
                        </div>
                    </div>
                    <div class="videoBox-timer d-flex align-items-center">
                        <img src="{{ asset('assets/images/timer.svg') }}" class="img-fluid" alt="timer">
                        <div class="text-white ml-3">
                            <ul class="videoBox-timer_time font-bd list-unstyled mb-0" id="class-timer">
                                <li><span class="hours">00</span></li>
                                <li class="seperator">:</li>
                                <li><span class="minutes">00</span></li>
                                <li class="seperator">:</li>
                                <li><span class="seconds">00</span></li>
                            </ul>
                            <span>{{__('labels.remaining')}}</span>
                        </div>
                    </div>
                </div>
                <div class="videoBox-thumb" id="videoBox">
                    <div class="videoBox-thumb" id="local-video">
                        {{-- <emmg src="{{ asset('assets/images/v-call.jpg') }}" class="img-fluid" alt="video-call"> --}}
                    </div>
                    <div style="display: none" class="videoBox-thumb" id="tutorImageScreen">
                        <div class="videoBox-thumb-user">
                            <img src="{{$class->tutor->profile_image_url}}" class="img-fluid" alt="video-call">
                        </div>
                    </div>
                    <div id="remote-video" class="videoBox-thumb-small">
                        
                    </div>
                    <div style="display: none" class="videoBox-thumb-small" id="studentImageScreen">
                        <div class="videoBox-thumb-user">
                            <img src="" class="img-fluid" alt="video-call">
                        </div>
                    </div>
                </div>
                <div class="videoBox-thumb videoBox-thumb--whiteboard" id="whiteBox" style="display: none;">
                    <div id="whiteboard" style="width: 100%; height: 100%;">
                    </div>
                    <!--Define the style of the toolbar and add it to the web page-->
                    {{-- <div id="toolbar" style="position:absolute; bottom:0;z-index:10;">
                    </div> --}}
                    <aside id="sidebar" style="position: absolute;top:0;">
                        <ul class="list-unstyled mb-0" id="toolbarUl">
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <em class="icon-undo" data-toggle="tooltip" data-placement="bottom" title="Undo"></em>
                                </a>
                                <div class="dropdown-menu shapeDropdown" aria-labelledby="dropdownMenuLink">
                                    <a id="undo" class="dropdown-item" href="javascript:void(0);">
                                        <em class="icon-undo"></em>
                                    </a>
                                    <a id="redo" class="dropdown-item" href="javascript:void(0);">
                                        <em class="icon-redo"></em>
                                    </a>
                                    <a id="duplicate" class="dropdown-item" href="javascript:void(0);">
                                        <em class="icon-duplicate"></em>
                                    </a>
                                    <a id="delete" class="dropdown-item" href="javascript:void(0);">
                                        <em class="icon-delete"></em>
                                    </a>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <em class="icon-highliter" data-toggle="tooltip" data-placement="bottom" title="Draw"></em>
                                </a>
                                <div class="dropdown-menu arrowDropdown" aria-labelledby="dropdownMenuLink">
                                    <ul class="list-inline colorList">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-color="[0,0,0]" class="selectedColor" style="background-color:#000000"></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-color="[255,193,0]" class="selectedColor" style="background-color:#FFCA2E"></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-color="[255,144,0]" class="selectedColor" style="background-color:#FB671F"></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-color="[27,0,255]" class="selectedColor" style="background-color:#0920E8"></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-color="[60,93,75]" class="selectedColor" style="background-color:#3c5d4b"></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-color="[255,0,0]" class="selectedColor" style="background-color:#EE0A01"></a>
                                        </li>
                                    </ul>
                                    <div class="range">
                                        <span>{{__('labels.size')}}</span>
                                        <div class="slidecontainer">
                                            <emnput type="range" min="1" max="100" value="5" class="slider" id="update-stroke">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </aside>
                </div>

                
                <div class="videoBox-callPanel d-flex">
                    <a id="extra-hour-btn" href="javascript:void(0);" class="videoBox-callPanel_link" style="display: none">
                        <span class="icon-extra-our"></span>
                        {{ __('labels.extra_hour') }}
                    </a>
                    <a href="javascript:void(0);" class="videoBox-callPanel_link d-lg-none" onclick="userAside()">
                        <span class="icon-chat"></span>
                        {{ __('labels.chat') }}
                    </a>
                    <div class="videoBox-callPanel-center d-flex mx-auto">
                        <a href="javascript:void(0);" class="videoBox-callPanel_link video-off">
                            <span class="icon-video-camera"></span>
                            {{ __('labels.video') }}
                        </a>
                        <a href="javascript:void(0);" class="videoBox-callPanel_link" id="showHideWhiteBox" onclick="showHideWhiteBox()">
                            <span class="icon-white-board"></span>
                            {{ __('labels.white_board') }}
                        </a>
                        <a href="javascript:void(0);" class="videoBox-callPanel_link mute">
                            <span class="icon-mic"></span>
                            {{ __('labels.mic') }}
                        </a>
                        <a href="javascript:void(0);" class="videoBox-callPanel_link screen-share-on">
                            <span class="icon-arrow_upward"></span>
                            <div class="screen-sharing">{{ __('labels.screen_share') }}</div>
                        </a>
                    </div>
                    <a href="javascript:void(0);" onclick="endCall()" id="leave" class="videoBox-callPanel_link ml-0">
                        <span class="icon-call red"></span>
                        {{ __('labels.end_call') }}
                    </a>
                </div>
            </div>
            <div class="videoBox-right">
                <div class="handRaiseList">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="font-eb">{{ __('labels.raise_hand_by') }} (<span class="raise-hand-count">{{ count($raiseHandRequests) }}</span>)</h4>
                        <a href="javascript:void(0);" class="closeAside d-lg-none"
                            onclick="closeAside()">&times;</a>
                    </div>
                    <ul id="raisHandList" class="list-unstyled mb-0 participantList" nice-scroll>
                        @forelse ($raiseHandRequests as $request)  
                        <li id="raise-hand-{{ $request->student_id }}" data-raise-hand-id="{{ $request->id }}">
                            <a href="javascript:void(0);"
                                class="d-flex align-items-center justify-content-between participantList-item flex-wrap">
                                <div class="participantList__left">
                                    <div class="d-flex align-items-center">
                                        <div class="participantList-item_img">
                                            <img src="{{ $request->student->profile_image_url }}" alt="">
                                        </div>
                                        <span class="font-bd participantList-item_name text-truncate">{{ $request->student->translateOrDefault()->name }}</span>
                                    </div>
                                </div>
                                <div id="raise-hand-actions-{{ $request->id }}" class="participantList__right">
                                    @if ($request->status == RaiseHand::STATUS_PENDING)
                                    <button type="button" data-id="{{ $request->id }}" class="btn btn-light btn-sm ripple-effect reject">{{ __('labels.reject') }}</button>
                                    <button type="button" data-id="{{ $request->id }}" class="btn btn-primary btn-sm ripple-effect accept">{{ __('labels.accept') }}</button>
                                    @else
                                    <button type="button" data-id="{{ $request->id }}" class="btn btn-primary btn-sm ripple-effect end-request">{{ __('labels.complete') }}</button>
                                    @endif
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="no_data"><div class="alert alert-danger">{{__('message.no_raise_hand_request_found')}}</div></li>
                        @endforelse
                    </ul>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="font-eb">{{ __('labels.participants') }} (<span class="participant-count">0</span>)</h4>
                    <a href="javascript:void(0);" class="closeAside d-lg-none" onclick="closeAside()">&times;</a>
                </div>
                <ul id="participantsList" class="list-unstyled mb-0 participantList" nice-scroll>
                    
                </ul>
            </div>
        </div>
    </div>
</main>

<!-- Extra Hour Request -->
<div class="modal fade" id="extraHourRequestModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--redeemPoint">
        <div class="modal-content">
            <form id="extraHourForm" action="{{ route('classes.add-extra-hour', ['class' => $class->id]) }}" method="POST">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{ __('labels.extra_hour_request') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group mb-0">
                        <label class="form-label">{{__('labels.time')}}</label>
                        <div class="input-group">
                            <select name="duration" id="durationOfClass" class="form-select" data-placeholder="{{__('labels.duration')}}" aria-describedby="durationOfClass-error">
                                <option value="">{{__('labels.select_duration')}}</option>
                                <option value="0.5">30 {{__('labels.min')}}</option>
                                <option value="1">1 {{__('labels.hours')}}</option>
                                <option value="1.5">1 {{__('labels.hours')}} 30 {{__('labels.min')}}</option>
                                <option value="2">2 {{__('labels.hours')}}</option>
                                <option value="2.5">2 {{__('labels.hours')}} 30 {{__('labels.min')}}</option>
                                <option value="3">3 {{__('labels.hours')}}</option>
                                <option value="3.5">3 {{__('labels.hours')}} 30 {{__('labels.min')}}</option>
                                <option value="4">4 {{__('labels.hours')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">{{__('labels.amount')}}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('labels.sar') }} </span>
                            </div>
                            <input type="number" name="extra_hour_charge" class="form-control" value="" />
                        </div>
                    </div>
            </div>
            <div class="modal-footer border-top-0 justify-content-center flex-nowrap">
                <button type="button" class="btn btn-light btn-lg font-bd ripple-effect" data-dismiss="modal">{{__('labels.cancel')}}</button>
                <button type="submit" id="extra-hour-submit" class="btn btn-primary btn-lg font-bd ripple-effect">{{__('labels.request')}}</button>
            </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Tutor\AddExtraHourRequest', '#extraHourForm') !!}
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.7.1.js"></script>
<script>
    var appId = "{{ config('agora.app_id') }}";
    var token = "{{ $token }}";
    var channelName = "channel-{{$class->id}}";
    var uid = {{ $class->tutor_id }};
    var tutorName = "{{ $class->tutor->name }}";
    var classId = {{ $class->id }};
    var timeInterval = '';
    var endTime = "{{ $class->end_time }}";
    var socketUrl = "{{ config('app.socket_url') }}";
    var whiteBoardToken = "{{$whiteBoardToken}}";
    var hasExtraHourRequest = {{($extraHourRequest) ? '1' : '0'}};
    var hasRaiseHandRequest = null;
    var appIdentifier = "{{ config('agora.app_identifier') }}";
    var region = "{{ config('agora.app_region') }}";
    var classUuid = "{{ $class->uuid }}";
    var classRoomToken = "{{ $class->room_token }}";
</script>
<script type="text/javascript" src="{{ config('app.socket_url') }}/socket.io/socket.io.js"></script>
<script src="https://sdk.netless.link/white-web-sdk/2.13.11.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/frontend/tutor/video-call.js') }}"></script>
@endpush

