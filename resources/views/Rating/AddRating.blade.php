
@extends('layouts.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/AddRating.css') }}"> 
<div class="cinema-rating-container">
    <div class="rating-card">
        <div class="card-header">
            <div class="movie-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4ZM4 6V12H11V6H4ZM4 18H11V14H4V18ZM13 18H20V10H13V18ZM13 8H20V6H13V8Z"/>
                </svg>
            </div>
            <h1 class="title">Rate Your <span>Cinema</span> Experience</h1>
            <p class="subtitle">Help us improve by rating your recent movie experience!</p>
            <div class="ticket-info">
                <div class="ticket-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14.5 18.5L16 17L13 14L15 12L12 9L14 7L12.5 5.5L17 5C18.1 5 19 5.9 19 7V19C19 20.1 18.1 21 17 21L4 21C2.9 21 2 20.1 2 19V7C2 5.9 2.9 5 4 5L8.5 5.5L7 7L9 9L6 12L8 14L5 17L6.5 18.5L10 15.5L12.5 18L14.5 15.5L11.5 13L14.5 10.5L12 8L9.5 10.5L7.5 8.5L6.5 9.5L9.5 12.5L6.5 15.5L10 19L12.5 16.5L15 19L18.5 15.5L15.5 12.5L18.5 9.5L17.5 8.5L15.5 10.5L13 8L10.5 10.5L13 13L10.5 15.5L14.5 18.5Z"/>
                    </svg>
                </div>
                <span class="ticket-number">Ticket #{{ $ticket->id }}</span>
                <span class="movie-title">{{ $ticket->show->movie->title }}</span>
            </div>
        </div>

        <form id="ratingForm" action="{{ route('rating.store') }}" method="POST">
            @csrf
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

            <div class="rating-grid">
                @php
                    $criteria = [
                        'movie_quality' => ['label' => 'Movie Quality', 'required' => true, 'icon' => '🎬'],
                        'hall_cleanliness' => ['label' => 'Hall Cleanliness', 'required' => true, 'icon' => '🧹'],
                        'seat_comfort' => ['label' => 'Seat Comfort', 'required' => true, 'icon' => '💺'],
                        'sound_quality' => ['label' => 'Sound Quality', 'required' => true, 'icon' => '🔊'],
                        'screen_quality' => ['label' => 'Screen Quality', 'required' => true, 'icon' => '📺'],
                        'food_quality' => ['label' => 'Food Quality', 'required' => false, 'icon' => '🍿'],
                        'staff_behavior' => ['label' => 'Staff Behavior', 'required' => true, 'icon' => '💁'],
                        'overall_experience' => ['label' => 'Overall Experience', 'required' => true, 'icon' => '⭐️'],
                    ];
                @endphp

                @foreach($criteria as $name => $data)
                    <div class="rating-item">
                        <div class="rating-header">
                            <span class="rating-icon">{{ $data['icon'] }}</span>
                            <label class="rating-label">
                                {{ $data['label'] }}
                                @if($data['required'])<span class="required-mark">*</span>@endif
                            </label>
                        </div>
                        
                        <div class="star-rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input
                                    type="radio" 
                                    id="{{ $name }}-{{ $i }}" 
                                    name="{{ $name }}" 
                                    value="{{ $i }}" 
                                    @if(old($name) == $i) checked @endif
                                >


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
                <textarea name="comments" rows="4" placeholder="Share your thoughts...">{{ old('comments') }}</textarea>
                @error('comments')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-footer">
                <div class="required-note"><span class="required-mark">*</span> Required fields</div>
                <button type="submit" class="submit-button" id="submitRating">
                    <span class="button-text">Submit Rating</span>
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('ratingForm').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Confirm Submission',
        text: "Do you want to submit your rating?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, submit it!',
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