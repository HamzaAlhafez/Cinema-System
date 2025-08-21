<header class="header">
    <h2>Welcome, {{ Auth::guard('employee')->user()->name ?? 'Employee' }}</h2>
   
</header>