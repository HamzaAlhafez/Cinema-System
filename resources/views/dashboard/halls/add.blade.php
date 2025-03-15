



<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Hall</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('halls.store')}}" method="post"  autocomplete="off">
                @csrf
                  <div class="modal-body">
                                    <label for="hall_name">hall name :</label>
                                    <input type="text" class="form-control" id="hall_name" name="hall_name" style=" height: 30px"
                                        placeholder="hall name .. " required />


                                 <label for="Capacity">Capacity :</label>
                                    <input type="number" class="form-control" id="Capacity" name="Capacity"style=" height: 40px"
                                        placeholder="Capacity .." required />
                                          













                                </div>
                                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
