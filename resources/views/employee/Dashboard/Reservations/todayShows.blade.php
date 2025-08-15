
@extends('employee.Dashboard.layouts.app')

@section('content')
<style>
/* --- تصميم الجدول --- */
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
    color: #333;
}
h2 {
    text-align: center;
    margin-bottom: 40px;
    color: #6a3d85;
    font-weight: 700;
}
.table-container {
    max-width: 1200px;
    margin: auto;
    overflow-x: auto;
}
.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    background-color: white;
}
.custom-table thead {
    background-color: #6a3d85;
    color: #fff;
}
.custom-table th, .custom-table td {
    padding: 15px 20px;
    text-align: center;
    vertical-align: middle;
    font-size: 16px;
}
.custom-table tbody tr {
    transition: all 0.3s ease;
    cursor: pointer;
}
.custom-table tbody tr:hover {
    background-color: #f3e6fa;
    transform: scale(1.02);
}
.movie-cell {
    display: flex;
    align-items: center;
}
.movie-cell img {
    width: 80px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.btn-purple {
    background-color: #6a3d85;
    color: white;
    border: none;
    padding: 8px 18px;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.btn-purple:hover {
    background-color: #532b62;
    transform: scale(1.05);
}

/* --- تصميم popup --- */
.reservation-container {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    width: 90%;
    max-width: 700px;
    background-color: white;
    transform: translate(-50%, -50%);
    z-index: 9999;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    padding: 20px;
}
.reservation-container.active {
    display: block;
}
.seat {
    width: 25px;
    height: 25px;
    background-color: #ddd;
    margin: 5px;
    display: inline-block;
    cursor: pointer;
    border-radius: 4px;
}
.seat.selected { background-color: #6a3d85; }
.seat.sold { background-color: #555; cursor: not-allowed; }
.showcase { display:flex; justify-content:center; margin-bottom:15px; }
.showcase li { list-style:none; margin:0 10px; text-align:center; }
.screen { height:20px; background-color:#ccc; margin:10px auto 20px; border-radius:5px; }
.swal-front { z-index: 10000 !important; }
</style>

<div class="container mt-5 table-container">
    <h2>Today's Shows ({{ $today->format('F d, Y') }})</h2>

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
                        Details
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Popup -->
<div id="reservation-popup" class="reservation-container p-3">
    <!-- زر إغلاق -->
    <button type="button" id="close-popup" 
        style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:24px; cursor:pointer;">
        &times;
    </button>

    <div class="tab">
        <h2>Reserve seats</h2>
    </div>
    <div class="reservation-movie-details pt-2 pb-2">
        <div>Movie: <strong id="movie-title" class="font-weight-bold"></strong></div>
        <div>Date: <strong id="show-date" class="font-weight-bold"></strong></div>
        <div>Total price: <strong class="font-weight-bold" id="show-price"></strong></div>
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

// زر إغلاق
document.getElementById('close-popup').addEventListener('click', () => {
    popup.classList.remove('active');
});

document.querySelectorAll('.open-popup').forEach(btn => {
    btn.addEventListener('click', () => {
        const showData = JSON.parse(btn.dataset.show);

        movieTitleEl.innerText = showData.title;
        showDateEl.innerText = showData.date;
        // التعديل هنا: نبدأ السعر الكلي من 0
        showPriceEl.innerText = showData.price +'$';
        showIdInput.value = showData.id;

        // Reset the form hidden inputs
        selectedCountInput.value = "0";
        finalPriceInput.value = "0";
        selectedSeatsInput.value = "";

        const seatsPerRow = 10;
        const rows = Math.ceil(showData.capacity / seatsPerRow);
        const soldSeats = showData.reserved;
        const pricesPerRow = [15, 12, 10, 8];
        let selectedSeats = []; // reset selected seats array
        let count = 0;          // reset count
        let totalPrice = showData.price;     // reset total price

        seatingArea.innerHTML = '';

        for (let i = 0; i < rows; i++) {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'row';

            // احسب المضاعف للسطر الحالي
            // إذا كان السطر الحالي ضمن المصفوفة pricesPerRow استخدم القيمة، وإلا استخدم آخر قيمة
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

// تأكيد الحجز
document.getElementById('reservation-form').addEventListener('submit', function(e) {
    e.preventDefault();

    // إخفاء المودال قبل ظهور الرسالة
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
        customClass: {
            popup: 'swal-front'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
@endsection