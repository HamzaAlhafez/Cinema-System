
@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/MyReservations.css') }}">

<div class="container-fluid py-5 cinematic-bg">
    <div class="container">
        <div class="header-section text-center mb-5">
            <h1 class="text-light display-4 fw-bold mb-3 neon-title">
                🍿 My Movie Tickets
            </h1>
            <div class="animated-divider"></div>
        </div>

        <div class="row g-4 justify-content-center">
            @if($tickets->isEmpty())
                <div class="col-12 col-md-6 text-center">
                    <div class="empty-state p-5 rounded-4">
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-popcorn fa-4x text-warning"></i>
                        </div>
                        <h3 class="text-light mb-3">No Tickets Found</h3>
                        <p class="text-muted">Your movie adventures will appear here</p>
                        <a href="{{ route('movies.index') }}" class="btn btn-glow-primary">
                            Explore Movies <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            @else
                @foreach($tickets as $ticket)
                <div class="col-12 col-md-8">
                    <div class="ticket-card elevation-3d">
                        <div class="movie-header">
                            <div class="poster-wrapper">
                                <img src="{{ asset('imagesmoives/moive/' . $ticket->show->movie->image) }}" class="movie-poster" alt="{{ $ticket->show->movie->title }}">
                            </div>
                          
                            <div class="movie-info">
                                <h2 class="movie-title">{{$ticket->show->movie->title}}</h2>
                                <div class="movie-meta">
                                    <span class="badge bg-primary">{{$ticket->show->hall->cinema->name ?? 'Cinema'}}</span>
                                    <span class="badge bg-dark">Hall {{$ticket->show->hall->hall_name}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="ticket-body">
                            <div class="details-grid">
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <div>
                                        <small>Date</small>
                                        <div>{{$ticket->show->date->format('d M Y')}}</div>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <small>Time</small>
                                        <div>{{ $ticket->show->start_time->format('H:i') }} - {{ $ticket->show->end_time->format('H:i') }}</div>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-couch"></i>
                                    <div>
                                        <small>Seats</small>
                                        <div>{{$ticket->Seats_Booked}}</div>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-tag"></i>
                                    <div>
                                        <small>Price</small>
                                        <div>{{$ticket->tickets_Price}} $</div>
                                    </div>
                                </div>
                            </div>
                        </div>


<div class="ticket-actions">
<form action="{{ route('ticket-foods.create') }}" method="GET" class="d-inline">
    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
    <button type="submit" class="btn btn-add-item">
        <i class="fas fa-plus-circle"></i>Food & Drinks
    </button>
</form>



              
                            <form action="{{ route('tickets.edit', $ticket->id) }}" method="GET" class="d-inline">
                                <button type="submit" class="btn btn-second btn-effect">
                                    Edit
                                </button>
                            </form>

                              
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-soft-danger delete-btn">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('components.flash-message')

<!-- SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Confirmation with SweetAlert
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                
                Swal.fire({
                    title: 'Delete Ticket?',
                    text: "Are You Sure You want Delete This Ticket!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        popup: 'sweetalert-popup',
                        confirmButton: 'sweetalert-confirm',
                        cancelButton: 'sweetalert-cancel'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection

