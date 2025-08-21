<aside class="sidebar">
    <div class="brand">
        🎬 <span>Cinema</span>
    </div>
    <ul>
        <li><a href="{{ route('employee.home') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
        <li><a href="{{ route('employee.reservations.today') }}"><i class="fa-solid fa-ticket"></i> Today  Reservations</a></li>
        <li><a href="{{ route('tickets.User.unconfirmed') }}"><i class="fa-solid fa-users"></i>Confirm User Attendance</a></li>
        <li><a href="{{ route('HallMaintenances.index') }}"><i class="fa-solid fa-wrench"></i>Hall Maintenance</a></li>
        <li class="dropdown">
  <a href="#"><i class="fa-solid fa-user"></i> Profile</a>
  <ul class="dropdown-menu">
    <li><a href="{{ route('employee.account') }}"><i class="fa-solid fa-id-card"></i> My Account</a></li>
    <li><a href="{{ route('employee.Change.Password') }}"><i class="fa-solid fa-key"></i> Change Password</a></li>
   
  </ul>
</li>

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