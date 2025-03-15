<!-- Modal -->
<div class="modal fade" id="edit{{$hall->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit hall</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('halls.update',$hall->id)}}" method="post"  autocomplete="off">
                 @csrf
                  @method('PUT')


                <div class="modal-body">
                    <label for="hall_name">Hall Name</label>
                                    <input type="text" class="form-control" id="hall_name" name="hall_name" value="{{$hall->hall_name}}" style=" height: 40px"
                                        placeholder="hall name .. " required />


                                 <label for="Capacity">Capacity</label>
                                    <input type="number" class="form-control" id="Capacity" name="Capacity" value="{{$hall->Capacity}}" style=" height:30px"
                                        placeholder="Capacity .." required />
                                          


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
