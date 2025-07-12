<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Show</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('shows.store') }}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <label for="movie_id">Movie :</label>
                    <select name="movie_id" class="form-control SlectBox" required>
                        <option value="" selected disabled>------</option>
                        @foreach($moives as $moive)
                            <option value="{{ $moive->id }}">{{ $moive->title }}</option>
                        @endforeach
                    </select>
                        <label for="hall_id">Hall :</label>
<select name="hall_id" class="form-control SlectBox">
                                        <option value="" selected disabled>------</option>
                                        @foreach($halls as $hall)
                                            <option value="{{$hall->id}}">{{$hall->hall_name}}</option>
                                        @endforeach
                                    </select>



                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" style="height:30px" placeholder="price .." step="0.01" required />

                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" style="height: 30px" placeholder="date .." required />

                    <label for="start_time">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time" style="height: 30px" placeholder="Start Time .." required />

                    <label for="End_time">End Time</label>
                    <input type="time" class="form-control" id="End_time" name="End_time" style="height: 30px" placeholder="End time .." required />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchAvailableHalls() {
            let date = $('#date').val();
            let startTime = $('#start_time').val();
            let endTime = $('#End_time').val();

            if (date && startTime && endTime) {
                $.ajax({
                    url: "{{ route('shows.getAvailableHalls') }}",
                    type: "GET",
                    data: { date: date, start_time: startTime, end_time: endTime },
                    success: function(response) {
                        $('#hall_id').html('<option value="" selected disabled>  Select the available hall</option>');
                        if (response.length > 0) {
                            $.each(response, function(index, hall) {
                                $('#hall_id').append('<option value="' + hall.id + '">' + hall.hall_name + '</option>');
                            });
                        } else {
                            $('#hall_id').html('<option value="" selected disabled>There are no available halls</option>');
                        }
                    }
                });
            }
        }

        $('#date, #start_time, #End_time').on('change', fetchAvailableHalls);
    });
</script>
