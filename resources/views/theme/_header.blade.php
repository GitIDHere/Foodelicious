<!-- ##### Header Area Start ##### -->
<header class="header-area">

    <!-- Top Header Area -->
    <div class="top-header-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center text-right">
                <!-- Top Social Info -->
                <div class="col-xl col-sm-6">
                    <div class="top-header-info ">
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
                                <li><a href="receipe-post.html">Recipies</a></li>
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