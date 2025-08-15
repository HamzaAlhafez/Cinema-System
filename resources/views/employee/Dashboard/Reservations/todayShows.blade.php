@extends('employee.Dashboard.layouts.app')

@section('content')
<div class="container mt-5 table-container">
    <h2>Today Shows ({{ now()->timezone('Asia/Damascus')->format('F d, Y') }})</h2>

    @if($shows->isEmpty())
        <div class="no-shows-message text-center py-5">
            <i class="fas fa-film fa-3x mb-3" style="color: #6f42c1;"></i>
            <h3 style="color: #6f42c1;">No shows available today</h3>
            <p class="text-muted">Please check back later for updates</p>
        </div>
    @else
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Movie</th>
                    <th>Hall</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Remaining Seats</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shows as $show)
                <tr>
                    <td class="movie-cell">
                        <img src="{{ asset('imagesmoives/moive/' . $show->movie->image) }}" alt="{{ $show->movie->title }}">
                        <span>{{ $show->movie->title }}</span>
                    </td>
                    <td>{{ $show->hall->hall_name }}</td>
                    <td>{{ $show->start_time->format('H:i') }}</td>
                    <td>{{ $show->end_time->format('H:i') }}</td>
                    <td>{{ $show->remaining_seats }}</td>
                    <td>
                        <button type="button" class="btn btn-purple open-popup"
                            data-show="{{ json_encode([
                                'id' => $show->id,
                                'title' => $show->movie->title,
                                'date' => $show->date->toDateString(),
                                'price' => $show->price,
                                'capacity' => $show->hall->Capacity,
                                'reserved' => \App\Models\SeatReservation::where('show_id', $show->id)->pluck('seat_number')->toArray()
                            ]) }}">
                            Reserve
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@include('employee.Dashboard.Reservations.reservation-modal-Employee')

@endsection