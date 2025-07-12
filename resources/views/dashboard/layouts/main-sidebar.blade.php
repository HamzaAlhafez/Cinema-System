<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="#"><img src="{{URL::asset('dashboard/img/brand/logo.png')}}" class="main-logo" alt="logo"></a>

			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('dashboard/img/faces/6.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{Auth::guard('admin')->user()->name}}</h4>
							<span class="mb-0 text-muted">{{Auth::guard('admin')->user()->email}}</span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
					<li class="side-item side-item-category">Main</li>
					<li class="slide">
						<a class="side-menu__item" href="{{route('admin.dashboard.home')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">Home</span></a>
					</li>
					<li class="side-item side-item-category">General</li>
					<li class="slide">

					<a class="side-menu__item" href="{{ route('movies.index') }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
        <path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14z"/>
        <path d="M9 7h6v2H9zm0 4h6v2H9zm0 4h6v2H9z" fill="currentColor"/>
    </svg>
    <span class="side-menu__label">Movies Management</span>
</a>
					</li>
                   
                    <li class="slide">
    <a class="side-menu__item" href="{{ route('categories.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" fill="black">
            <path d="M3 3h18v18H3V3zm2 2v14h14V5H5zm7 3h2v2h-2V8zm0 4h2v2h-2v-2zm-4-4h2v2H8V8zm0 4h2v2H8v-2zm0 4h2v2H8v-2zm10-4h-2v-2h2v2zm0-4h-2v-2h2v2z"/>
        </svg>
        <span class="side-menu__label">Categorie Management</span>
    </a>
</li>
					<li class="slide">
    <a class="side-menu__item" href="{{ route('halls.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" fill="black">
            <path d="M3 3h18v18H3V3zm2 2v14h14V5H5zm7 3h2v2h-2V8zm0 4h2v2h-2v-2zm-4-4h2v2H8V8zm0 4h2v2H8v-2zm0 4h2v2H8v-2zm10-4h-2v-2h2v2zm0-4h-2v-2h2v2z"/>
        </svg>
        <span class="side-menu__label">Halls Management</span>
    </a>
</li>
					<li class="slide">
    <a class="side-menu__item" href="{{ route('shows.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
            <path d="M0 0h24v24H0V0z" fill="none"/>
            <path d="M22 4h-2V2h-4v2h-8V2H4v2H2c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H2V8h20v12zm-6-8H8v-2h8v2z"/>
        </svg>
        <span class="side-menu__label">Shows Management</span>
    </a>
</li>
<li class="slide">
    <a class="side-menu__item" href="{{ route('promocodes.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
        </svg>
        <span class="side-menu__label">PromoCodes Management</span>
    </a>
</li>

					<li class="slide">
    <a class="side-menu__item" href="{{ route('mangers.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
        </svg>
        <span class="side-menu__label">Managers Management</span>
    </a>
</li>





					<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
        </svg>
        <span class="side-menu__label">My Account</span>
        <i class="angle fe fe-chevron-down"></i>
    </a>
    <ul class="slide-menu">
        <li><a class="slide-item" href="{{ route('admin.dashboard.ViewProfile')}}">View proifle</a></li>
        <li><a class="slide-item" href="{{ route('Admins.index')}}">Edit profile</a></li>
      <!--  <li><a class="slide-item" href="{{ route('admin.dashboard.ChangePassword')}}">Change password</a></li> -->
    </ul>
</li>

						<li class="slide">
    <a class="side-menu__item" href="{{ route('admin.dashboard.Contactus') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" fill="black">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-.35 0-.68-.07-1-.18-2.34-1.05-4-3.41-4-6.75 0-.5.05-1 .14-1.48.68.35 1.44.55 2.26.55 1.5 0 2.88-.5 4-1.34.57.85 1.49 1.34 2.5 1.34 1.66 0 3-1.34 3-3s-1.34-3-3-3c-1.2 0-2.25.68-2.84 1.68-1.05-.62-2.27-1-3.66-1-3.31 0-6 2.69-6 6 0 2.53 1.47 4.67 3.63 5.59-.06.27-.09.55-.09.84 0 2.79 2.24 5.03 5 5.03 1.06 0 2.05-.33 2.87-.89-.62.29-1.31.46-2.03.46z"/>
        </svg>
        <span class="side-menu__label">Contact Us</span>
    </a>
</li>


					<li class="slide">
    <form id="logout-form" action="{{ route('admin.dashboard.Logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <a class="side-menu__item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0V0z" fill="none"/>
        <path d="M10 17l5-5-5-5v4H3v2h7v4zm11-14H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h17c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H4V5h17v14z"/>
    </svg>
    <span class="side-menu__label">Logout</span>
</a>





				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
