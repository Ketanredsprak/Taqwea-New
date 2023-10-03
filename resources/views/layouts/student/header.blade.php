<header class="header header-inner fixed-top">
    <nav class="navbar navbar-expand-lg border-0 py-0">
        <div class="container">
            <a class="navbar-brand" href="{{ route('student/dashboard') }}">
                <img src="{{ asset('assets/images/logo-frontend.png') }}" class="img-fluid" alt="Logo" />
            </a>

            <div class="search" id="search">
            <form class="form-inline">
               <input class="form-control" id="global-search-text" dir="rtl" type="search" placeholder="{{__('labels.search_keyword_here')}}" aria-label="Search">
               <button type="button" class="search-clear" id="global-search-clear" style="display: none;" ><i class="icon-close"></i></button>
            </form>
            <div class="searchList" id="searchListView">

            </div>
         </div>

            <div class="order-3 order-lg-4">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item nav-item--cart nav-item--border">
                        <a class="nav-link d-xl-none" href="javascript:void();" onclick="searchToggle()">
                        <em class="icon-search"></em>
                        </a>
                    </li>
                    <li class="nav-item nav-item--cart  nav-item--border chat-header {{($headerChattingNotifications) ? 'chat-info' : ''}}">
                        <a class="nav-link" href="{{route('message-student')}}" alt="student message">
                            <em class="icon-chat"></em>
                        </a>
                    </li>
                    <li class="nav-item nav-item--cart nav-item--border nav-item--count">
                        <a class="nav-link" href="{{ route('student.carts.index') }}">
                            <em class="icon-cart"><span class="badge badge-info">{{ ($cartCount > 0) ? $cartCount : ''}}</span></em>
                        </a>
                    </li>
                    <li class="nav-item nav-item--bell nav-item--border dropdown {{($headerNotifications->count()) ? 'status-info' : ''}}" id="notiDrop">
                        <a class="nav-link" id="notificationDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="icon-status icon-status-info"><em class="icon-bell"></em></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                            <div class="dropdown-body" nice-scroll>
                                @if ($headerNotifications->count())
                                <div class="nk-notification">
                                    @foreach ($headerNotifications as $notification)
                                    <div class="infoItem d-flex align-items-cetenr">
                                        <div class="infoItem__img">
                                            <img src="{{ asset('assets/images/notification-thumbnail.jpg') }}" alt="notification" class="img-fluid" />
                                        </div>
                                        <div class="infoItem__cnt">
                                            <p class="mb-0">{{ substr($notification->notification_message,0,40)}} ...</p>
                                            <span class="time">{{$notification->created_at->setTimezone(Session::get('timezone'))->diffForHumans()}}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="infoItem align-items-cetenr">
                                    <div class="alert alert-icon alert-danger" role="alert">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong>{{ __('labels.no_unread_notifications')}}</strong>
                                    </div>
                                </div>
                                <!-- .nk-notification -->
                                @endif
                            </div>
                            <a class="show-all" href="{{route('student.notification.index')}}">{{ __('labels.show_all') }}</a>
                        </div>
                    </li>
                    @include('layouts.student.header-menu')
                    <li class="d-flex align-items-center">
                        <button class="navbar-toggler order-1 mr-auto" type="button" data-toggle="collapse" data-target="#navCollapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                        </button>
                    </li>
                </ul>

            </div>

            <div class="collapse navbar-collapse order-4 order-lg-3" id="navCollapse">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ (\Request::route()->getName() == 'classes') ? 'active' : '' }}" href="{{ url('classes') }}">{{__('labels.online_classes')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (\Request::route()->getName() == 'webinars') ? 'active' : '' }}" href="{{ url('webinars') }}">{{__('labels.webinars')}}</a>
                    </li>
                    <li class="nav-item nav-item--border">
                        <a class="nav-link {{ (\Request::route()->getName() == 'blogs') ? 'active' : '' }}" href="{{ url('blogs') }}">{{ __('labels.blogs') }}</a>
                    </li>
                    <li class="nav-item nav-item--lang">
                        @php
                        $languages = getLanguages();
                        $locale = App::getLocale();
                        @endphp
                        <select class="form-select selectLanguage" id="changeLanguage">
                            @forelse($languages as $language)
                            <option value="{{ $language->code }}" {{ ($locale==$language->code)?'selected':''}}>{{ strtoupper($language->code) }}</option>
                            @endforeach
                        </select>
                    </li>

                </ul>
            </div>
            <div class="navbar-backdrop" id="navbarBackdrop"></div>
        </div>
    </nav>
</header>
@push('scripts')
<script>
    var setLanguageUrl = "{{ route('setLanguage') }}";
</script>
@endpush
