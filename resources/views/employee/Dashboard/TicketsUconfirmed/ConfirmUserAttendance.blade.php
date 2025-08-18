
@extends('employee.Dashboard.layouts.app')

@section('content')
<div class="container">
    <h2><i class="fas fa-calendar-day"></i> Unconfirmed Tickets for Today</h2>

    <!-- ==== Search Form with Reset Button ==== -->
    <form action="{{ route('tickets.User.unconfirmed') }}" method="GET" style="text-align: center; margin-bottom: 30px;">
        <input type="text" name="ticket_id" placeholder="Enter Ticket Number" 
               style="padding: 10px 15px; border-radius: 8px; border: 1px solid #ccc; width: 250px; font-size: 14px;"
               value="{{ request('ticket_id') }}">
        <button type="submit" class="btn-purple"><i class="fas fa-search"></i> Search</button>
        <a href="{{ route('tickets.User.unconfirmed') }}" class="btn-purple" style="margin-left: 10px;">
            <i class="fas fa-redo-alt"></i> Reset
        </a>
    </form>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th><i class="fas fa-ticket-alt"></i> Ticket No</th>
                    <th><i class="fas fa-user"></i> User Name</th>
                    <th><i class="fas fa-phone"></i> Phone Number</th>
                    <th><i class="fas fa-film"></i> Movie</th>
                    <th><i class="fas fa-chair"></i> Seats Booked</th>
                    <th><i class="fas fa-list-ol"></i> Seat Numbers</th>
                    <th><i class="fas fa-utensils"></i> Food Orders</th>
                    <th><i class="fas fa-dollar-sign"></i> Total Price</th>
                    <th><i class="fas fa-check-circle"></i> Confirm Attendance</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->user->name }}</td>
                        <td>{{ $ticket->user->phone }}</td>
                        <td>{{ $ticket->show->movie->title }}</td>
                        <td>{{ $ticket->seatReservations->count() }}</td>
                        <td>{{ implode(', ', $ticket->seatReservations->pluck('seat_number')->toArray()) }}</td>
                        <td>
                            @if ($ticket->foods->isEmpty())
                                No food ordered
                            @else
                                @foreach ($ticket->foods as $foodItem)
                                    <p>{{ $foodItem->food->name }} (x{{ $foodItem->quantity }}) - ${{ $foodItem->total_Price }}</p>
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $ticket->tickets_Price }}$</td>
                        <td>
                            <form action="{{ route('attendance.confirm', $ticket->id) }}" method="POST" class="confirm-form">
                                @csrf
                                <button type="button" class="btn-purple" onclick="confirmAttendance(this)">
                                    <i class="fas fa-check-circle"></i> Confirm
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="no-shows-message">
                            <h3><i class="fas fa-smile-beam"></i> No unconfirmed tickets found.</h3>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ==== SweetAlert2 JS ==== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmAttendance(button) {
    Swal.fire({
        title: 'Are you sure?',


text: "You are confirming this user's attendance!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5e2b97',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    })
}
</script>
@if(session()->has('flash'))
<div class="flash-message {{ session('flash') }}" id="flashMessage">
    <span>{{ session('message') }}</span>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const flashMessage = document.getElementById('flashMessage');
        
        if (flashMessage) {
            
            setTimeout(() => {
                flashMessage.style.opacity = '0';
                flashMessage.style.transition = 'opacity 0.5s ease';
                
                
                setTimeout(() => {
                    flashMessage.remove();
                }, 500);
            }, 10000);
            
          
            flashMessage.addEventListener('click', function() {
                this.style.opacity = '0';
                setTimeout(() => this.remove(), 500);
            });
        }
    });
</script>
@endif
@endsection