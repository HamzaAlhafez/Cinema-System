<aside class="sidebar">
    <div class="brand">
        🎬 <span>Cinema</span>
    </div>
    <ul>
        <li><a href="{{ route('employee.home') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
        <li><a href="{{ route('employee.reservations.today') }}"><i class="fa-solid fa-ticket"></i> Today's Reservations</a></li>
        <li><a href=""><i class="fa-solid fa-burger"></i> Food Orders</a></li>
        <li><a href="#"><i class="fa-solid fa-user"></i> Profile</a></li>
        <li>
    <form action="{{ route('employee.logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit" class="logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
    </form>
</li>
    </ul>
</aside>