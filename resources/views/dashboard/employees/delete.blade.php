<div class="modal fade" id="delete{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employees.destroy', $employee->id) }}" method="post">
                @csrf
                @method('DELETE')
                        
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{$employee->id}}">
                    <h5>Are you sure you want to delete this employee?</h5>
                    <div class="alert alert-warning mt-3">
                        <strong>Warning!</strong> This action cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>