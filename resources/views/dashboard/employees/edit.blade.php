<!-- Modal -->
<div class="modal fade" id="edit{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Food & drink Categorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employee.update-salary',$employee->id)}}" method="post"  autocomplete="off">
                 @csrf
                  @method('patch')


                <div class="modal-body">
                    

                                        <label for="salary">salary :</label>
                                    <input type="number" class="form-control" id="salary" name="salary" value="{{$employee->salary}}"  style=" height: 30px"
                                        placeholder="salary .. " required />



                                 
                                          


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>