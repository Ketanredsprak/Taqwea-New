<div class="nk-sidebar nk-sidebar-fixed is-light sidebar" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head justify-content-between">
        <div class="nk-sidebar-brand">
            <a href="dashboard.php" class="logo-link nk-sidebar-logo">
                <img class="logo-img open" src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                <img class="logo-img closed" src="{{ asset('assets/images/logo.png') }}" alt="logo">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <!--  <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a> -->
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="{{route('adminDashboard')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub ">
                        <a href="javascript:void(0);" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                            <span class="nk-menu-icon"><em class="icon ni ni-grid"></em></span>
                            <span class="nk-menu-text">Master Setup</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{route('subjects.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Subject Management</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="{{route('categories.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Category Management</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{URL::TO('admin/commission')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Commission</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="{{route('subscriptions.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Subscriptions</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="{{URL::TO('admin/top-up')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Top Up</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('admin.running-subscription')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Running Subscriptions</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                              <a href="{{route('banks.index')}}" class="nk-menu-link">
                                   <span class="nk-menu-text">Bank Details</span>
                              </a>
                            </li><!-- .nk-menu-item -->
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{route('tutors.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon icon-tutor"></em></span>
                            <span class="nk-menu-text">Tutors</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item">
                        <a href="{{route('students.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon icon-reading"></em></span>
                            <span class="nk-menu-text">Students</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item has-sub ">
                        <a href="javascript:void(0);" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                            <span class="nk-menu-icon"><em class="icon ni ni-video"></em></span>
                            <span class="nk-menu-text">Classes, Webinars & Blogs</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{route('classes.index')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Online Classes</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('admin/webinars')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Webinar</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('blogs.index')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Blogs</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    <li class="nk-menu-item has-sub ">
                        <a href="javascript:void(0);" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                            <span class="nk-menu-icon"><em class="icon ni ni-calendar-booking"></em></span>
                            <span class="nk-menu-text">Bookings & Purchases</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{route('admin.booking.class')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Class Booking</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('admin.booking.webinar')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Webinar Booking</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('admin.blog.purchase')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Blogs Purchases</span></a>
                            </li>

                        </ul><!-- .nk-menu-sub -->
                    </li>

                    <li class="nk-menu-item has-sub">
                        <a href="javascript:void(0);" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                            <span class="nk-menu-icon"><em class="icon ni ni-coin"></em></span>
                            <span class="nk-menu-text">Payment History</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{route('transaction.history')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Transaction History</span></a>
                            </li>
                            {{-- <li class="nk-menu-item">
                                <a href="javascript:void(0);" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Payment Settlement</span></a>
                            </li> --}}
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item has-sub">
                        <a href="javascript:void(0);" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                            <span class="nk-menu-icon"><em class="icon ni ni-reports"></em></span>
                            <span class="nk-menu-text">Report</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{URL::TO('admin/class-report')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Class Report</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{URL::TO('admin/webinar-report')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Webinar Report</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{URL::TO('admin/blog-report')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Blog Report</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{URL::TO('admin/revenue-report')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Revenue Report</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{URL::To('admin/student-report')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Students Report</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{URL::To('admin/tutor-report')}}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Tutor Report</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item">
                        <a href="{{route('help-support')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon icon-info"></em></span>
                            <span class="nk-menu-text">Help & Support</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="{{route('faqs.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-question"></em></span>
                            <span class="nk-menu-text">FAQ</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="{{route('testimonials.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chat-circle"></em></span>
                            <span class="nk-menu-text">Testimonial</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item">
                        <a href="{{route('demo.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chat-circle"></em></span>
                            <span class="nk-menu-text">Demo</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    @if (@$cmsPage && $cmsPage->count())
                    <li class="nk-menu-item has-sub">
                        <a href="javascript:void(0);" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-todo"></em></span> <span class="nk-menu-text">Manage CMS</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @foreach(@$cmsPage as $page)
                            <li class="nk-menu-item">
                                <a href="{{URL::to('admin/cms/'.$page->id)}}" class="nk-menu-link"> <span class="nk-menu-text">{{$page->page_title}}</span></a>
                            </li>
                            @endforeach
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    @endif
                    <li class="nk-menu-item">
                        <a href="/admin/tracking" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-reports"></em></span>
                            <span class="nk-menu-text">Tracking</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>