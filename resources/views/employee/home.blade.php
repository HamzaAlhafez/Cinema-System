@extends('employee.Dashboard.layouts.app')

@section('content')
@php
use App\Models\Show;
use App\Models\Ticket;
use Carbon\Carbon;

$today =Carbon::today('Asia/Damascus');

        $showsToday = Show::whereDate('date', $today)->count();

        $pendingBookings = Ticket::where('Booking_Status', false)
    ->whereHas('show', function($query) use ($today) {
        $query->whereDate('date', $today);
    })
    ->count();

@endphp
    <h1>Dashboard</h1>

    <div class="card">
        <h3>Today Reservations</h3>
        <p>{{ $showsToday }} shows scheduled</p>
    </div>

    <div class="card">
        <h3>Today's Pending Reservations</h3>
        <p>{{ $pendingBookings }} reservations pending</p>
    </div>
    @include('employee.flash-message')
@endsection