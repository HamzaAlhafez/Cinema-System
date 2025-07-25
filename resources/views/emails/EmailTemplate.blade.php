<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/email.css') }}">
    <title>{{ $type === 'show' ? 'New Cinema Show' : 'Booking Confirmation' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
        {!! file_get_contents(public_path('css/email.css')) !!}
    </style>
   
    
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                @if($type === 'show')
                    New Movie Show
                @else
                    Booking Confirmation
                @endif
            </h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $type === 'booking' ? 'Valued Customer' : 'Movie Lover' }},</p>
            
            @if($type === 'show')
                <p>We're excited to announce a new movie show at our cinema! Here are the details:</p>
            @else
                <p>Thank you for your booking. Your reservation details are below:</p>
            @endif
            
            <div class="details-container">
                <h2 class="section-title">Movie Information</h2>
                
                <div class="detail-row">
                    <div class="detail-label">Movie Title:</div>
                    <div class="detail-value">
                        {{ $type === 'show' ? ($data->movie->title ?? 'Not specified') : ($data->ticket->show->movie->title ?? 'Not specified') }}
                    </div>
                </div>
                
                <div class="detail-row">
    <div class="detail-label">Location:</div>
    <div class="detail-value">
        Damascus, Syria - Mazzeh<br>
        <span style="font-size: 0.9em; color: #666;">
            <i class="fas fa-phone"></i> +963 953248544 | 
            <i class="fas fa-clock"></i> Daily 10:00 AM - 2:00 AM
        </span>
    </div>
</div>
                
                <div class="showtime-box">
                    <h2 class="section-title">Showtime Details</h2>
                    
                    <div class="detail-row">
                        <div class="detail-label">Date:</div>
                        <div class="detail-value">
                            {{ $type === 'show' ? ($data->date->format('l, F j, Y') ?? 'N/A') : ($data->ticket->show->date->format('l, F j, Y') ?? 'N/A') }}
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">Start Time:</div>
                        <div class="detail-value">
                            {{ $type === 'show' ? (\Carbon\Carbon::parse($data->start_time)->format('g:i A') ?? 'N/A') : (\Carbon\Carbon::parse($data->ticket->show->start_time)->format('g:i A') ?? 'N/A') }}
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">End Time:</div>
                        <div class="detail-value">
                            {{ $type === 'show' ? (\Carbon\Carbon::parse($data->end_time)->format('g:i A') ?? 'N/A') : (\Carbon\Carbon::parse($data->ticket->show->end_time)->format('g:i A') ?? 'N/A') }}
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">Hall:</div>
                        <div class="detail-value">
                            {{ $type === 'show' ? ($data->hall->hall_name ?? 'Not specified') : ($data->ticket->show->hall->hall_name ?? 'Not specified') }}
                        </div>
                    </div>
                    
                    @if($type === 'show')
                        <div class="detail-row">
                            <div class="detail-label">Ticket Price:</div>
                            <div class="detail-value price-highlight">{{ $data->price ?? 'N/A' }} $</div>
                        </div>
                    @endif
                </div>
                
                @if($type === 'booking')
                    <h2 class="section-title">Booking Details</h2>
                    
                    <div class="detail-row">
                        <div class="detail-label">Seats:</div>
                        <div class="detail-value">
                            <div class="seats-list">
                                @foreach($data->seats as $seat)
                                    <span class="seat-badge">Seat {{ $seat->seat_number }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">Total Price:</div>
                        <div class="detail-value price-highlight">{{ $data->ticket->tickets_Price ?? 'N/A' }} $</div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">Booking Date:</div>
                        <div class="detail-value">
                            {{ $data->ticket->Booking_date->format('F j, Y \a\t g:i A') ?? 'N/A' }}
                        </div>
                    </div>
                @endif
            </div>
            
            @if($type === 'booking')
                <div class="important-note">
                    <h3>Important Reminders</h3>
                    <ul>
                        <li>Please arrive at least <strong>30 minutes before showtime</strong></li>
                        <li>Bring this confirmation for entry</li>
                        <li>Seats will be released 15 minutes after showtime</li>
                        <li>No refunds after showtime</li>
                    </ul>
                </div>
            @else
                <div class="important-note">
                    <h3>Special Discount Offer</h3>
                    <p>Use your coupon code during checkout to get <strong>exclusive discounts</strong> on your booking!</p>
                </div>
            @endif
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ $type === 'show' ? route('showsmoive.show', $data->id) : route('tickets.index') }}" class="btn">
                    @if($type === 'show')
                        Book Tickets Now
                    @else
                        View Booking Details
                    @endif
                </a>
            </div>
            
            <p style="text-align: center; margin-top: 20px;">
                Questions? Contact us at <a href="mailto:support@cinema.com">support@cinema.com</a>
            </p>
        </div>
        
        <div class="footer">
            <div>{{ config('app.name') }}</div>
            <p>This is an automated message. Please do not reply.</p>
            <p>© {{ date('Y') }} All rights reserved</p>
        </div>
    </div>
</body>
</html>
  