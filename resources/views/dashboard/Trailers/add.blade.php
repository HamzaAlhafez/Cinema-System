





<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Trailer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Trailers.store')}}" method="post"  autocomplete="off">
                @csrf
                  <div class="modal-body">
                                   

                                        <label for="trailer_url">trailer URL:</label>
    <input type="url" class="form-control" id="target_url" name="trailer_url"
           style="height: 30px" placeholder="https://example.com" 
           pattern="https://.*" required />

           <label for="movie_id">Movie :</label>
<select name="movie_id" class="form-control SlectBox">
    <option value="" selected disabled>------</option>
    @foreach($Movies as $Movie)
        @if(!$Movie->trailer) 
            <option value="{{ $Movie->id }}">{{ $Movie->title }}</option>
        @endif
    @endforeach
</select>




                                 
                                          













                                </div>
                                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>