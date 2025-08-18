@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/MyRatings.css') }}">

<div class="cinema-rating-container">
    <h1 class="page-title">My <span>Ratings</span></h1>

    @if($ratings->isEmpty())
        <p class="no-ratings">You haven't submitted any ratings yet.</p>
    @else
        <div class="ratings-grid">
            @foreach($ratings as $rating)
                <div class="rating-card">
                    <div class="card-header">
                        <div>
                            <span class="ticket-number">Ticket #{{ $rating->ticket_id }}</span>
                            <div class="movie-title">{{ $rating->ticket->show->movie->title }}</div>
                        </div>
                    </div>

                    <div class="rating-details">
                        @php
                            $criteria = [
                                'movie_quality' => 'Movie Quality',
                                'hall_cleanliness' => 'Hall Cleanliness',
                                'seat_comfort' => 'Seat Comfort',
                                'sound_quality' => 'Sound Quality',
                                'screen_quality' => 'Screen Quality',
                                'food_quality' => 'Food Quality',
                                'staff_behavior' => 'Staff Behavior',
                                'overall_experience' => 'Overall Experience',
                            ];
                        @endphp

                        @foreach($criteria as $key => $label)
                            <div class="rating-row">
                                <div class="label">{{ $label }}</div>
                                <div class="stars">
                                    @if($rating->$key)
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $rating->$key ? 'filled' : '' }}">&#9733;</span>
                                        @endfor
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="comments">
                        <strong>Comment:</strong> {{ $rating->comments ?? 'N/A' }}
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('rating.edit', $rating->id) }}" class="update-button">Update</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection