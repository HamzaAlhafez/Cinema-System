<header class="header">
    <h2>Welcome, {{ Auth::guard('employee')->user()->name ?? 'Employee' }}</h2>
    <div class="header-right">
        <i class="fa-solid fa-bell"></i>
        <i class="fa-solid fa-user-circle"></i>
    </div>
</header>