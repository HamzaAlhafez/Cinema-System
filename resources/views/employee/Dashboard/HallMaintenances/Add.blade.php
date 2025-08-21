<div class="modal fade" id="addHallModal" tabindex="-1" aria-labelledby="addHallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addHallModalLabel">Add Hall to Maintenance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('HallMaintenances.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="hall_id" class="form-label">Select Hall</label>
                <select name="hall_id" id="hall_id" class="form-select" required>
                    <option value="">-- Choose Hall --</option>
                    @foreach($halls as $hall)
                        <option value="{{ $hall->id }}">{{ $hall->hall_name }}</option>
                    @endforeach
                </select>
            </div>

            

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-purple" onclick="confirmAdd(this)">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
function confirmAdd(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to add this hall to maintenance!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5e2b97',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, add!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    })
}
</script>