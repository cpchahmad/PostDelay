<!DOCTYPE html>
<html lang="en">
@include('inc.header')
<body>
{{--@if(config('shopify-app.appbridge_enabled'))--}}
{{--    <script src="https://unpkg.com/@shopify/app-bridge{{ config('shopify-app.appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>--}}
{{--    <script>--}}
{{--        var AppBridge = window['app-bridge'];--}}
{{--        var createApp = AppBridge.default;--}}
{{--        var app = createApp({--}}
{{--            apiKey: '{{ config('shopify-app.api_key') }}',--}}
{{--            shopOrigin: '{{ \OhMyBrew\ShopifyApp\Facades\ShopifyApp::shop()->shopify_domain }}',--}}
{{--            forceRedirect: true,--}}
{{--        });--}}
{{--    </script>--}}
{{--@endif--}}

<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>
</div>

<div class="header-bg">
    <!-- Navigation Bar-->
    <header id="topnav">
        <div class="topbar-main">
            <div class="container-fluid">
                <div>

                    <a href="{{ route('shop.dashboard') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="" height="26">
                    </a>

                </div>
                <!-- End Logo-->

                <div class="menu-extras topbar-custom navbar p-0">
                    <ul class="list-inline d-none d-lg-block mb-0">
                        <li class="list-inline-item notification-list">
                            <a href="{{ route('shop.dashboard') }}" class="nav-link waves-effect">
                                Dashboard
                            </a>
                        </li>

                        <li class="list-inline-item notification-list">
                            <a href="{{ route('shop.orders') }}" class="nav-link waves-effect">
                                Orders
                            </a>
                        </li>

                        <li class="list-inline-item notification-list">
                            <a href="{{ route('shop.customers') }}" class="nav-link waves-effect">
                                Customers
                            </a>
                        </li>

                        <li class="list-inline-item notification-list">
                            <a href="{{ route('shop.settings') }}" class="nav-link waves-effect">
                                Settings
                            </a>
                        </li>


                    </ul>


                    <ul class="list-inline ml-auto mb-0">

                        <li class="list-inline-item dropdown notification-list" style="display: none;">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-bell-outline noti-icon"></i>
                                <span class="badge badge-pill noti-icon-badge">3</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5>Notification (3)</h5>
                                </div>

                                <div class="slimscroll-noti">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                        <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                        <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                        <p class="notify-details"><b>New Message received</b><span class="text-muted">You have 87 unread messages</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info"><i class="mdi mdi-filter-outline"></i></div>
                                        <p class="notify-details"><b>Your item is shipped</b><span class="text-muted">It is a long established fact that a reader will</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                                        <p class="notify-details"><b>New Message received</b><span class="text-muted">You have 87 unread messages</span></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-warning"><i class="mdi mdi-cart-outline"></i></div>
                                        <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                    </a>

                                </div>


                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item notify-all">
                                    View All
                                </a>

                            </div>
                        </li>
                        <!-- User-->
                        <li class="list-inline-item dropdown notification-list nav-user">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <img src="{{asset('assets/images/users/avatar-6.jpg')}}" alt="user" class="rounded-circle">
                                <span class="d-none d-md-inline-block ml-1">Post Delay <i class="mdi mdi-chevron-down"></i> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                <a class="dropdown-item" href="#"><i class="dripicons-exit text-muted"></i> Logout</a>
                            </div>
                        </li>
                        <li class="menu-item list-inline-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>

                    </ul>

                </div>
                <!-- end menu-extras -->

                <div class="clearfix"></div>

            </div> <!-- end container -->
        </div>
        <!-- end topbar-main -->

        <div id="navbar-custom" class="navbar-custom" style="display: none;">
            <div class="container-fluid">

                <div id="navigation">

                    <!-- Navigation Menu-->
                    <ul class="navigation-menu">

                        <li>
                            <a href=""></a>
                        </li>

                        <li >
                            <a href="{{route('shape.index')}}"><i class="dripicons-suitcase"></i> Shapes </a>

                        </li>

                        <li >
                            <a href="{{route('types.index')}}"><i class="dripicons-help"></i> Post Types</a>

                        </li>

                        <li>
                            <a href="{{route('scales.index')}}"><i class="dripicons-archive"></i> Scales </a>

                        </li>

                        <li>
                            <a href="{{route('locations.index')}}"><i class="dripicons-duplicate"></i> Locations </a>

                        </li>

                        <li>
                            <a href="{{route('postdelayfee.index')}}"><i class="dripicons-duplicate"></i> Post Delay Fee </a>
                        </li>

                        <li>
                            <a href="{{route('statuses.index')}}"><i class="dripicons-link"></i> Statuses </a>
                        </li>

                        <li>
                            <a href="{{route('threshold.index')}}"><i class="dripicons-link"></i> Threshold Settings </a>
                        </li>

                        <li>
                            <a href="{{route('api_credentials.index')}}"><i class="dripicons-link"></i> Api Settings </a>
                        </li>

                        <li>
                            <a href="{{route('app_messages.index')}}"><i class="dripicons-link"></i> App Messages </a>
                        </li>

                    </ul>
                    <!-- End navigation menu -->
                </div> <!-- end #navigation -->
            </div> <!-- end container -->
        </div> <!-- end navbar-custom -->
    </header>

</div>
<!-- header-bg -->

<div class="wrapper">

    @include('flash_message.message')
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                © 2019 Postdelay.
            </div>
        </div>
    </div>
</footer>


@include('inc.footer')

</body>
</html>
