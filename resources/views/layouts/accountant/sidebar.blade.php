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
                        <a href="{{route('accountantDashboard')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="{{route('accountant.tutor.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon icon-tutor"></em></span>
                            <span class="nk-menu-text">Tutor Payout</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item">
                        <a href="{{route('refund-request.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon icon-reading"></em></span>
                            <span class="nk-menu-text">Student Refund Request</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    {{-- <li class="nk-menu-item">
                        <a href="javascript:void(0);" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-coin"></em></span>
                            <span class="nk-menu-text">Transactions History</span>
                        </a>
                    </li><!-- .nk-menu-item --> --}}

                    <li class="nk-menu-item">
                        <a href="{{ route('accountant.support.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon icon-info"></em></span>
                            <span class="nk-menu-text">Support</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('accountant.revenue.report')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-reports"></em></span>
                            <span class="nk-menu-text">Revenue Report</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>