
@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/AddRating.css') }}"> 
<div class="cinema-rating-container">
    <div class="rating-card">
        <div class="card-header">
       
            <h2 class="title">Update <span>Rating</span></h2>
            <p class="subtitle">You can update your previous rating below</p>
            <div class="ticket-info">
                <span class="ticket-number">Ticket #{{ $rating->ticket_id }}</span>
               
            </div>
        </div>

        <form id="ratingForm" action="{{ route('rating.update', $rating->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="ticket_id" value="{{ $rating->ticket_id  }}">

            <div class="rating-grid">
                @php
                    $fields = [
                        'movie_quality' => 'Movie Quality',
                        'hall_cleanliness' => 'Hall Cleanliness',
                        'seat_comfort' => 'Seat Comfort',
                        'sound_quality' => 'Sound Quality',
                        'screen_quality' => 'Screen Quality',
                        'food_quality' => 'Food Quality',
                        'staff_behavior' => 'Staff Behavior',
                        'overall_experience' => 'Overall Experience'
                    ];
                @endphp

                @foreach($fields as $name => $label)
                    <div class="rating-item">
                        <div class="rating-header">
                            <div class="rating-icon">⭐</div>
                            <div class="rating-label">{{ $label }}</div>
                        </div>
                        <div class="star-rating">
                            @for($i=5; $i>=1; $i--)
                                <input type="radio" id="{{ $name }}-{{ $i }}" name="{{ $name }}" value="{{ $i }}" {{ $rating->$name == $i ? 'checked' : '' }}>
                                <label for="{{ $name }}-{{ $i }}" class="star" data-rating="{{ $i }}">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        @error($name)
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="comment-section">
                <div class="comment-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3C17.5 3 22 6.6 22 11C22 15.4 17.5 19 12 19C10.8 19 9.6 18.8 8.5 18.5C5.9 21 3 21 3 21C3 21 5 18 5.2 16.4C3.2 15 2 13.1 2 11C2 6.6 6.5 3 12 3Z"/>
                    </svg>
                    <label>Your Comments</label>
                </div>
                <textarea name="comments" rows="4" placeholder="Share your thoughts...">{{ old('comments', $rating->comments) }}</textarea>
                @error('comments')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-footer">
                <div class="required-note"><span class="required-mark">*</span> Required fields</div>
                <button type="submit" class="submit-button" id="submitRating">


<span class="button-text">Update Rating</span>
                    <span class="submit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 12V15H16L10.5 20.5L11.92 21.92L19.84 14L11.92 6.08L10.5 7.5L16 13H4Z"/>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@include('components.flash-message')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('ratingForm').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Confirm Update',
        text: "Do you want to update your rating?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'Cancel',
        background: '#f9f9f9',       
        color: '#1a202c',            
        confirmButtonColor: '#4f46e5', 
        cancelButtonColor: '#d1d5db', 
        customClass: {
            popup: 'rounded-xl shadow-lg p-6',
            title: 'text-lg font-semibold',
            confirmButton: 'px-6 py-2 text-white font-medium rounded-md',
            cancelButton: 'px-6 py-2 font-medium rounded-md'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit(); 
        }
    });
});
</script>
@endsection