<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger mr-2">
                <a href="javascript:void(0);" class="nk-nav-toggle nk-quick-nav-icon toggle-active" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand">
                <a href="{{route('accountantDashboard')}}" class="logo-link">
                    <img class="logo-light logo-img" src="{{ asset('assets/images/logo.png') }}" alt="logo">
                    <img class="logo-dark logo-img" src="{{ asset('assets/images/logo.png') }}" alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown notification-dropdown">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                            <div class="{{($headerNotifications->count()) ? 'icon-status' : ''}} icon-status-info"><em class="icon ni ni-bell"></em>

                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                @if ($headerNotifications->count())
                                <a href="{{url('accountant/mark-all-as-read')}}" class="mark-all-as-read">Mark All as Read</a>
                                @endif
                            </div>
                            <div class="dropdown-body">
                                @if ($headerNotifications->count())
                                <div class="nk-notification">
                                    @foreach ($headerNotifications as $notification)
                                    <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">{{ substr($notification->notification_message,0,50)}} ...</div>
                                            <div class="nk-notification-time">{{$notification->created_at->setTimezone(Session::get('timezone'))->diffForHumans()}}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="alert alert-icon alert-danger" role="alert">
                                    <em class="icon ni ni-alert-circle"></em>
                                    <strong>No unread notifications!</strong>
                                </div>
                                <!-- .nk-notification -->
                                @endif
                            </div><!-- .nk-dropdown-body -->
                            <div class="dropdown-foot center">
                                <a href="{{url('accountant/notifications')}}">View All</a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <img src="{{ Auth::guard('web')->user()->profile_image_url }}" alt="user-img" class="img-fluid">
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-name dropdown-indicator">{{Auth::guard('web')->user()->name}}</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu headerDropdown dropdown-menu-md dropdown-menu-right">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <img src="{{ Auth::guard('web')->user()->profile_image_url }}" alt="user-img" class="img-fluid">
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{Auth::guard('web')->user()->name}}</span>
                                        <span class="sub-text">{{Auth::guard('web')->user()->email}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{URL::TO('accountant/profile')}}"><em class="icon ni ni-user-alt"></em><span>Profile Settings</span></a></li>
                                    <li><a href="{{URL::TO('accountant/profile')}}"><em class="icon ni ni-lock-alt-fill"></em><span>Change Password</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><em class="icon ni ni-signout"></em><span>Logout</span></a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>