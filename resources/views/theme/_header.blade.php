<!-- ##### Header Area Start ##### -->
<header class="header-area">

    @Auth
        @if (Auth::user()->hasVerifiedEmail() == false)
            <!-- Notification bar -->
                <div class="notification-bar">

                    <div class="d-flex justify-content-center align-items-center pt-2">

                        @if(session()->has('message'))
                            <h4>{{ session()->get('message') }}</h4>
                        @else
                            <h4>Please verify your email.</h4>
                            <form method="POST" action="{{route('verification.send')}}">
                                @csrf
                                <input type="submit"  class="link" value="Resend email" />
                            </form>
                        @endif

                    </div>
                </div>
        @endif
    @endauth

    <!-- Top Header Area -->
    <div class="top-header-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-between">

                <!-- Login/Logout/Profile -->
                <div class="col-12 col-sm-12">
                    <div class="top-social-info text-right">
                        @auth
                            <a href="{{route('user.profile.view')}}">Profile</a>
                            <a href="{{route('logout')}}">Logout</a>
                        @endauth
                        @guest
                            <a class="{{ Route::is('login.show') ? 'active' : '' }}" href="{{route('login.show')}}">
                                Login
                            </a>
                            <a class="{{ Route::is('register.show') ? 'active' : '' }}" href="{{route('register.show')}}">
                                Register
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar Area -->
    <div class="delicious-main-menu">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">
                <!-- Menu -->
                <nav class="classy-navbar justify-content-between" id="deliciousNav">

                    <!-- Logo -->
                    <a class="nav-brand" href="{{route('home')}}"><img src="/img/core-img/logo.png" alt=""></a>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">

                        <!-- close btn -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul>
                                <li class=""><a href="{{route('home')}}">Home</a></li>
                                <li><a href="recipe-post.html">Recipies</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>

                        </div>
                        <!-- Nav End -->
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ##### Header Area End ##### -->
