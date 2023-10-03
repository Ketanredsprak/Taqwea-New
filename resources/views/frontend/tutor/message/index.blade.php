@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
<main class="mainContent">
    <div class="chatPage chatPage--tutor commonPad bg-green ">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ $title }}</h3>
            </div>
        </section>
         <div class="container">
               <div class="d-flex align-items-center mb-3">
                  <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
               </div>
                <div class="row">
                    <div class="userList commonBox sideMenu" >
                        <a href="javascript:void(0);" id="closeMenu" class="linkPrimary closeMenu d-xl-none">&times;</a>
                        <form>
                            <div class="form-group">
                                <select class="form-select" id="tutor-classes" data-placeholder="{{__('labels.all_classes_webinar')}}">
                                    <option value="0"> {{__('labels.all_classes_webinar')}} </option>
                                    @foreach ($messageList as $class)
                                    <option value="{{$class->class->id}}" @if(@$class_id == $class->class->id) selected @endif>{{$class->class->class_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group search">
                                <em class="icon-search searchIcon"></em>
                                <input type="text" dir="rtl" id="search-text" class="form-control" id="formGroupExampleInput" placeholder="{{__('labels.search_by_student_name')}}">
                                <button type="button" class="search-clear" style="display: none;" ><i class="icon-close"></i></button>
                            </div>
                        </form>
                        <div id="chatList"></div>
                    </div>
                    <div class="col-md-8 column-2" id="chatDetail">
                        <div class="alert alert-danger">{{ __('labels.please_select_chat') }}</div>
                    </div>
                </div>
            </div>
    </div>
    </div>
</main>

@endsection
@push('scripts')

<script >
    var socketUrl = "{{ config('app.socket_url') }}";
    var uid = '{{ Auth::user()->id }}';
    var chatId = '{{ @$uuid }}';
    var studentId = '{{ @$student_id }}';
</script>
<script type="text/javascript" src="{{ config('app.socket_url') }}/socket.io/socket.io.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/chat.js')}}"></script>

@endpush
