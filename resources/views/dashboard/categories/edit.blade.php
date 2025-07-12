<!-- Modal -->
<div class="modal fade" id="edit{{$Categorie->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Categorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('categories.update',$Categorie->id)}}" method="post"  autocomplete="off">
                 @csrf
                  @method('PUT')


                <div class="modal-body">
                    

                                        <label for="Title">Title :</label>
                                    <input type="text" class="form-control" id="Title" name="Title" value="{{$Categorie->title}}"  style=" height: 30px"
                                        placeholder="Title .. " required />



                                 
                                          


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>