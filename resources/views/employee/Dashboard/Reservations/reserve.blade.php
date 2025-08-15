
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div id="reservation-popup" class="reservation-container reservation-popup mfp-hide p-3">
    <div class="tab">
        <h2>Reserve seats</h2>
    </div>
    <div class="reservation-movie-details pt-2 pb-2">
        <div>Movie: <strong id="movie-title" class="font-weight-bold">{{ $show->movie->title ?? '' }}</strong></div>
        <div>Date: <strong id="show-date" class="font-weight-bold">{{ $show->date->toDateString() ?? '' }}</strong></div>
        <div>Total price: <strong class="font-weight-bold" id="show-price">{{ $show->price ?? '' }}$</strong></div>
    </div>

    <form id="reservation-form" action="{{ route('tickets.store') }}" method="post" autocomplete="off">
        @csrf
        <input type="hidden" id="selected-count" name="selected_count" value="0" />
        <input type="hidden" id="final-price" name="final_price" value="{{ $show->price ?? '' }}" />
        <input type="hidden" id="Show-Id" name="show_id" value="{{ $show->id ?? '' }}" />
        <input type="hidden" id="selected-seats-input" name="selected_seats" value="" />

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
                <div class="seat sold"></div>
                <small>Sold</small>
            </li>
        </ul>
        <div class="container">
            <div class="screen"></div>
            <div id="seating-area"></div>
        </div>

        <div style="overflow:auto;">
            <div style="float:right;" class="mt-3">
                <button type="submit" class="btn btn-red">Get a Ticket</button>
            </div>
        </div>
    </form>
</div>

@php
use App\Models\SeatReservation;
use App\Models\Promocode;
$reservedSeats = SeatReservation::where('show_id', $show->id)->pluck('seat_number')->toArray();
@endphp

<script>
    const capacity = {{ $show->hall->Capacity ?? 0 }}; 
    const seatsPerRow = 10; 
    const rows = Math.ceil(capacity / seatsPerRow); 
    const soldSeats = {{ json_encode($reservedSeats) }}; 
    const selectedSeats = []; 
    let count = 0; 
    let totalPrice = {{ $show->price ?? 0 }}; 

    const pricesPerRow = [15, 12, 10, 8]; 
    const seatingArea = document.getElementById('seating-area');
    const selectedCountInput = document.getElementById('selected-count');
    const showPriceElement = document.getElementById('show-price');
    const finalPriceInput = document.getElementById('final-price');
    const selectedSeatsInput = document.getElementById('selected-seats-input'); 

    for (let i = 0; i < rows; i++) {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'row';

        for (let j = 0; j < seatsPerRow && (i * seatsPerRow + j) < capacity; j++) {
            const seatDiv = document.createElement('div');
            const seatIndex = i * seatsPerRow + j + 1; 

            if (soldSeats.includes(seatIndex)) {
                seatDiv.className = 'seat sold'; 
                seatDiv.addEventListener('click', function() {});
            } else {
                seatDiv.className = 'seat'; 
                seatDiv.addEventListener('click', function() {
                    if (selectedSeats.includes(seatIndex)) {
                        selectedSeats.splice(selectedSeats.indexOf(seatIndex), 1);
                        count--; 
                        totalPrice -= pricesPerRow[i]; 
                        seatDiv.classList.remove('selected');
                    } else {
                        selectedSeats.push(seatIndex);
                        count++; 
                        totalPrice += pricesPerRow[i];
                        seatDiv.classList.add('selected');
                    }


selectedCountInput.value = count;
                    showPriceElement.innerText = totalPrice + '$';
                    finalPriceInput.value = totalPrice; 
                    selectedSeatsInput.value = selectedSeats.toString(); 
                });
            }

            rowDiv.appendChild(seatDiv);
        }
        seatingArea.appendChild(rowDiv);
    }

    document.getElementById('reservation-form').addEventListener('submit', function(e) {
        e.preventDefault(); 
        Swal.fire({
            title: 'Confirm Reservation?',
            text: 'Are you sure you want to confirm your reservation?',
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
            if (result.isConfirmed) this.submit(); 
        });
    });
</script>