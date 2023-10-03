<header class="header header-inner fixed-top">
    <nav class="navbar navbar-expand-lg border-0 py-0">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo-frontend.png') }}" class="img-fluid" alt="Logo" />
            </a>

            <div class="order-3 order-lg-4">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item nav-item--border"></li>
                    <li class="nav-item nav-item--cart nav-item--border chat-header {{($headerChattingNotifications) ? 'chat-info' : ''}}">
                        <a class="nav-link" href="{{route('message-tutor')}}" alt="tutor message">
                            <em class="icon-chat"></em>
                        </a>
                    </li>
                    <li class="nav-item nav-item--bell nav-item--border {{($headerNotifications->count()) ? 'status-info' : ''}} dropdown" id="notiDrop">
                        <a class="nav-link" id="notificationDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><em class="icon-bell"></em></a>
                        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                            <div class="dropdown-body" nice-scroll>
                                @if ($headerNotifications->count())
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
                            <a class="show-all" href="{{route('tutor.notification.index')}}">{{ __('labels.show_all') }}</a>
                        </div>
                    </li>
                    @include('layouts.tutor.header-menu')
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
                        <a class="nav-link {{ (!empty($currentPage) && $currentPage =='myClasses')?'active':'' }}" href="{{ route('tutor.classes.index') }}">{{ __('labels.my_classes') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (!empty($currentPage) && $currentPage =='myWebinars')?'active':'' }}" href="{{ route('tutor.webinars.index') }}">{{ __('labels.my_webinars') }}</a>
                    </li>
                    <li class="nav-item nav-item--border">
                        <a class="nav-link {{ (!empty($currentPage) &&  $currentPage =='myBlog')?'active':'' }}" href="{{ route('tutor.blogs.index') }}">{{ __('labels.my_blogs') }}</a>
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