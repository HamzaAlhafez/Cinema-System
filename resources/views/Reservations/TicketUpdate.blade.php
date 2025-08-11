@extends('layouts.layout')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ticket</title>
    <link rel="stylesheet" href="{{ asset('css/ticketedit.css') }}">

    
</head>
<body>
    <div class="reservation-container">
        <div class="tab">
            <h2>Edit Ticket</h2>
            <p>You can modify your seat selection below</p>
        </div>
        
        <div class="reservation-movie-details">
            <div>Movie: <strong id="movie-title">{{ $movieTitle }}</strong></div>
            <div>Date: <strong id="show-date">{{ $showDate->toDateString() }}</strong></div>
            <div>Time: <strong id="show-time">{{ $showStartTime }} - {{ $showEndTime }}</strong></div>
            <div>Hall: <strong id="hall-name">{{ $hallName }}</strong></div>
        </div>
        
        <div class="ticket-info">
            <div class="ticket-info-item">
                <span>Ticket ID:</span>
                <span><strong>#{{ $ticket->id }}</strong></span>
            </div>
            <div class="ticket-info-item">
                <span>Booking Date:</span>
                <span><strong>{{ $ticket->Booking_date }}</strong></span>
            </div>
            <div class="ticket-info-item">
                <span>Booking Status:</span>
                <span><strong>{{ $ticket->Booking_Status }}</strong></span>
            </div>
            <div class="ticket-info-item">
                <span>Current Seats:</span>
                <span><strong id="current-seats">{{ implode(', ', $currentTicketSeats) }}</strong></span>
            </div>
        </div>
        
        <form id="edit-ticket-form" method="POST" action="{{ route('tickets.update', $ticket->id) }}">
            @csrf
            @method('PUT')
            @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            
           
            <input type="hidden" name="final_price" id="final-price-input" value="{{ $ticket->tickets_Price }}">
           
            <input type="hidden" name="seats_count" id="seats-count-input" value="{{ count($currentTicketSeats) }}">
            
            <div class="form-group">
                <label for="selected-seats">Selected Seats</label>
                <input type="text" id="selected-seats" name="selected_seats" class="form-control" 
                       value="{{ implode(',', $currentTicketSeats) }}" readonly>
            </div>
            
            <ul class="showcase">
                <li>
                    <div class="seat"></div>
                    <small>Available</small>
                </li>
                <li>
                    <div class="seat selected"></div>
                    <small>Selected</small>
                </li>
                <li>
                    <div class="seat user-seat"></div>
                    <small>Your Current Seats</small>
                </li>
                <li>
                    <div class="seat sold"></div>
                    <small>Sold</small>
                </li>
            </ul>
            
            <div class="cinema-container">
                <div class="screen">CINEMA SCREEN</div>
                <div class="seating-area" id="seating-area">
                   
                </div>
            </div>
            
            <div class="selection-summary">
                <div class="summary-item">
                    <span>Number of Selected Seats:</span>
                    <span id="selected-count">{{ count($currentTicketSeats) }}</span>
                </div>
              
                <div class="summary-total">
                    <span>Total Price:</span>
                    <span id="total-price">${{$ticket->tickets_Price }}</span>
                </div>
            </div>
            
            <button type="submit" class="btn-update">
                <i class="fas fa-sync-alt"></i> Update Ticket
            </button>
        </form>
    </div>
    <script>
    const capacity = {{$hallCapacity}};
    const seatsPerRow = 10;
    const rows = Math.ceil(capacity / seatsPerRow);
    const soldSeats = {{ json_encode($reservedSeatsExceptUser) }};
    const userSeats = {{ json_encode($currentTicketSeats) }}; 
    const selectedSeats = [...userSeats]; 
    let count = userSeats.length;
    const initialPrice = {{ $ticket->tickets_Price }}; 
    let totalPrice = initialPrice;

    const pricesPerRow = [15, 12, 10, 8]; 
    const seatingArea = document.getElementById('seating-area');
    const selectedCountInput = document.getElementById('selected-count');
    const totalPriceElement = document.getElementById('total-price');
    const selectedSeatsInput = document.getElementById('selected-seats');
    const finalPriceInput = document.getElementById('final-price-input'); 
    const seatsCountInput = document.getElementById('seats-count-input'); 

   
    function updateSummary() {
        document.getElementById('selected-count').textContent = count;
        totalPriceElement.textContent = '$' + totalPrice.toFixed(2);
        selectedSeatsInput.value = selectedSeats.join(',');
        finalPriceInput.value = totalPrice; 
        seatsCountInput.value = count; 
    }

    for (let i = 0; i < rows; i++) {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'row';

        for (let j = 0; j < seatsPerRow && (i * seatsPerRow + j) < capacity; j++) {
            const seatDiv = document.createElement('div');
            const seatIndex = i * seatsPerRow + j + 1;
            seatDiv.setAttribute('data-seat-index', seatIndex);
            seatDiv.setAttribute('data-row', i);

            // تحديد حالة المقعد
            if (soldSeats.includes(seatIndex)) {
                seatDiv.className = 'seat sold';
            } else if (userSeats.includes(seatIndex)) {
                seatDiv.className = 'seat user-seat'; 
            } else {
                seatDiv.className = 'seat';
            }

            seatDiv.addEventListener('click', function() {
                const seatIdx = parseInt(this.getAttribute('data-seat-index'));
                const rowIdx = parseInt(this.getAttribute('data-row'));
                const price = pricesPerRow[rowIdx];

               
                if (this.classList.contains('user-seat')) {
                    
                    this.classList.remove('user-seat');
                    this.classList.add('seat');
                    
                  
                    const index = selectedSeats.indexOf(seatIdx);
                    if (index !== -1) {
                        selectedSeats.splice(index, 1);
                        count--;
                        totalPrice -= price;
                    }
                }
             
                else if (this.classList.contains('seat') && !this.classList.contains('sold')) {


if (this.classList.contains('selected')) {
                      
                        this.classList.remove('selected');
                        const index = selectedSeats.indexOf(seatIdx);
                        if (index !== -1) {
                            selectedSeats.splice(index, 1);
                            count--;
                            totalPrice -= price;
                        }
                    } else {
                        // تحديد مقعد جديد
                        this.classList.add('selected');
                        selectedSeats.push(seatIdx);
                        count++;
                        totalPrice += price;
                    }
                }

                updateSummary();
            });

            rowDiv.appendChild(seatDiv);
        }

        seatingArea.appendChild(rowDiv);
    }

 
    updateSummary();
    // meassge
    document.getElementById('edit-ticket-form').addEventListener('submit', function(e) {
    e.preventDefault(); 

    Swal.fire({
        title: 'Confirm Reservation?',
        text: 'Are you sure you want to Update your reservation?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!',
        cancelButtonText: 'Cancel',
        customClass: {
            popup: 'sweetalert-popup',
            confirmButton: 'sweetalert-confirm',
            cancelButton: 'sweetalert-cancel'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit(); 
        }
    });
});
</script>
   
</body>
</html>
@include('components.flash-message')
@endsection