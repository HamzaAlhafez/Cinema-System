



<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Movie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('movies.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                  <div class="modal-body">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" style=" height: 30px"
                                        placeholder="Title .. " required />


                                 <label for="storeline">Store Line</label>
                                    <input type="text" class="form-control" id="storeline" name="storeline"style=" height: 40px"
                                        placeholder="store line.." required />

                                 <label for="language">language</label>
                                    <input type="text" class="form-control" id="language" name="language"style=" height: 30px"
                                        placeholder="language.."   required/>


                                 <label for="rating">Rating</label>
                                    <input type="number" class="form-control" id="rating" name="rating" max="5" min="0"   style=" height: 30px"
                                        placeholder="Rating from 0 to 5 " step="0.01" required />

                                  <label for="productiondate">production date</label>
                                    <input type="date" class="form-control" id="language" name="productiondate" style=" height: 30px"
                                        placeholder="production date.." required />

                                 <label for="director">director</label>
                                    <input type="text" class="form-control" id="language" name="director" style=" height: 30px"
                                        placeholder="director.." required />

                                <label for="Actors">Actors</label>
                                    <input type="text" class="form-control" id="language" name="Actors" style=" height: 40px"
                                        placeholder="Actors.." required />



<label for="Actors">Categories :</label>
<select name="Categories_id" class="form-control SlectBox">
                                        <option value="" selected disabled>------</option>
                                        @foreach($Categories as $Categorie)
                                            <option value="{{$Categorie->id}}">{{$Categorie->title}}</option>
                                        @endforeach
                                    </select>

<label for="image" class="form-label"> Choose movie IMAGE</label>
  <input class="form-control" type="file" name="image" id="formFile" required>
      @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror




                                </div>
                                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>








































                 {{-- <div class="form-group">
                              <label for="Categories_id">Categories :  </label>
                                <select name="Categories_id" class="form-select" style="width: 400px" aria-label="Default select example">
  <option selected>Open this select Categories</option>
  @foreach ($Categories as $Categorie)
                                            <option value="{{ $Categorie->id }}"
                                                {{ old('Categories_id') == $Categorie->id? 'selected' : '' }}>{{ $Categorie->title  }}
                                            </option>
                                        @endforeach

</select>

                                </div>  --}}


