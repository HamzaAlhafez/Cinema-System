<!-- =============== START OF RESPONSIVE - MAIN NAV =============== -->
<nav id="main-mobile-nav"></nav>
<!-- =============== END OF RESPONSIVE - MAIN NAV =============== -->

<!-- =============== START OF HEADER NAVIGATION =============== -->
<!-- Insert the class "sticky" in the header if you want a sticky header -->
<header class="header text-black">
    <div class="container-fluid">

        <!-- ====== Start of Navbar ====== -->
        <nav class="navbar navbar-expand-lg">

            <a class="navbar-brand" href="{{ route('home') }}">
                <!-- INSERT YOUR LOGO HERE -->
                <img src="{{ asset('images/branding/logos/logo-bt.png') }}" alt="logo" width="200" class="logo">
                <!-- INSERT YOUR WHITE LOGO HERE -->
                <img src="{{ asset('images/branding/logos/logo-w.png') }}" alt="white logo" width="200"
                    class="logo-white">
            </a>

           

            <!-- ====== Start of #main-nav ====== -->
            <div class="navbar-collapse" id="main-nav">

                <!-- ====== Start of Main Menu ====== -->
                <ul class="navbar-nav mx-auto" id="main-menu">
                    <!-- Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('home') }}>Home</a>
                    </li>

                    <!-- Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('showsmoive.index')}}">Movies</a>
                    </li>

                    <!-- Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="">What to Watch?</a>
                    </li>

                    <!-- Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="">Contact us</a>
                    </li>

                </ul>
                <!-- ====== End of Main Menu ====== -->


                <!-- ====== Start of Extra Nav ====== -->
                <ul class="navbar-nav extra-nav">

                    <!-- Menu Item -->


                    @auth
                        <li class="nav-item dropdown" style="z-index: 50;">
                            <a href="" class="btn btn-main btn-effect login-btn">
                                <i class="icon-user"></i>Hello, {{ Auth::user()->name}}</a>
                            <div class="dropdown-content rounded font-weight-normal">
                                <a href="">My Account</a>
                                <a href="">My Reservations</a>

                                <form id="logout_form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="javascript:{}" onclick="document.getElementById('logout_form').submit();">Log
                                        Out</a>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-main btn-effect login-btn">
                                <i class="icon-user"></i>login</a>
                        </li>
                    @endauth

                </ul>
                <!-- ====== End of Extra Nav ====== -->

            </div>
            <!-- ====== End of #main-nav ====== -->
        </nav>
        <!-- ====== End of Navbar ====== -->

    </div>
</header>
<!-- =============== END OF HEADER NAVIGATION =============== -->
