


<div id="reservation-popup" class="reservation-container p-3">
    <button type="button" id="close-popup">&times;</button>

    <div class="tab">
        <h2>Reserve seats</h2>
    </div>
    <div class="reservation-movie-details">
        <div>Movie: <strong id="movie-title"></strong></div>
        <div>Date: <strong id="show-date"></strong></div>
        <div>Total price: <strong id="show-price"></strong></div>
    </div>

    <form id="reservation-form" action="{{ route('tickets.store') }}" method="post" autocomplete="off">
        @csrf
        <input type="hidden" id="selected-count" name="selected_count" value="0" />
        <input type="hidden" id="final-price" name="final_price" value="0" />
        <input type="hidden" id="Show-Id" name="show_id" value="" />
        <input type="hidden" id="selected-seats-input" name="selected_seats" value="" />

        <ul class="showcase">
            <li><div class="seat"></div><small>Available</small></li>
            <li><div class="seat selected"></div><small>Selected</small></li>
            <li><div class="seat sold"></div><small>Sold</small></li>
        </ul>
        <div class="container">
            <div class="screen"></div>
            <div id="seating-area"></div>
        </div>


<div style="overflow:auto;">
            <div style="float:right;" class="mt-3">
                <button type="submit" class="btn btn-purple">Get a Ticket</button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

const popup = document.getElementById('reservation-popup');
const movieTitleEl = document.getElementById('movie-title');
const showDateEl = document.getElementById('show-date');
const showPriceEl = document.getElementById('show-price');
const showIdInput = document.getElementById('Show-Id');
const seatingArea = document.getElementById('seating-area');
const selectedCountInput = document.getElementById('selected-count');
const finalPriceInput = document.getElementById('final-price');
const selectedSeatsInput = document.getElementById('selected-seats-input');


document.getElementById('close-popup').addEventListener('click', () => {
    popup.classList.remove('active');
});


document.querySelectorAll('.open-popup').forEach(btn => {
    btn.addEventListener('click', () => {
        const showData = JSON.parse(btn.dataset.show);

        movieTitleEl.innerText = showData.title;
        showDateEl.innerText = showData.date;
        showPriceEl.innerText = showData.price + '$';
        showIdInput.value = showData.id;

       
        selectedCountInput.value = "0";
        finalPriceInput.value = "0";
        selectedSeatsInput.value = "";

        const seatsPerRow = 10;
        const rows = Math.ceil(showData.capacity / seatsPerRow);
        const soldSeats = showData.reserved;
        const pricesPerRow = [15, 12, 10, 8];
        let selectedSeats = [];
        let count = 0;
        let totalPrice = showData.price;

        seatingArea.innerHTML = '';

        for (let i = 0; i < rows; i++) {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'row';

            const rowMultiplier = i < pricesPerRow.length ? pricesPerRow[i] : pricesPerRow[pricesPerRow.length - 1];

            for (let j = 0; j < seatsPerRow && (i * seatsPerRow + j) < showData.capacity; j++) {
                const seatDiv = document.createElement('div');
                const seatIndex = i * seatsPerRow + j + 1;

                if (soldSeats.includes(seatIndex)) {
                    seatDiv.className = 'seat sold';
                } else {
                    seatDiv.className = 'seat';
                    seatDiv.addEventListener('click', function() {
                        if (selectedSeats.includes(seatIndex)) {
                            selectedSeats.splice(selectedSeats.indexOf(seatIndex), 1);
                            count--;
                            totalPrice -= rowMultiplier;
                            seatDiv.classList.remove('selected');
                        } else {
                            selectedSeats.push(seatIndex);
                            count++;
                            totalPrice += rowMultiplier;
                            seatDiv.classList.add('selected');
                        }
                        selectedCountInput.value = count;
                        finalPriceInput.value = totalPrice;
                        showPriceEl.innerText = totalPrice + '$';
                        selectedSeatsInput.value = selectedSeats.toString();
                    });
                }
                rowDiv.appendChild(seatDiv);
            }
            seatingArea.appendChild(rowDiv);
        }

        popup.classList.add('active'); 
    });
});


document.getElementById('reservation-form').addEventListener('submit', function(e) {
    e.preventDefault();
    popup.classList.remove('active');


Swal.fire({
        title: 'Confirm Reservation?',
        text: 'Are you sure you want to confirm your reservation?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!',
        cancelButtonText: 'Cancel',
        customClass: { popup: 'swal-front' }
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>