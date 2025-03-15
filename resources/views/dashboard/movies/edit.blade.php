<!-- Modal -->
<div class="modal fade" id="edit{{$moive->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Moive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('movies.update',$moive->id)}}" method="post" enctype="multipart/form-data" autocomplete="off">
                 @csrf
                  @method('PUT')


                <div class="modal-body">
                     <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{$moive->title}}" style=" height: 24px"
                                        placeholder="Title " required />


                                 <label for="storeline">Store Line</label>
                                    <input type="text" class="form-control" id="storeline" name="storeline" value="{{$moive->storyline}}" style=" height: 24px"
                                        placeholder="store line" required />

                                 <label for="language">language</label>
                                    <input type="text" class="form-control" id="language" name="language" value="{{$moive->language}}" style=" height: 24px"
                                        placeholder="language"   required/>


                                 <label for="rating">Rating</label>
                                    <input type="number" class="form-control" id="rating" name="rating" value="{{$moive->rating}}" max="5" min="0"   style=" height: 24px"
                                        placeholder="Rating from 0 to 5" required />

                                  <label for="productiondate">production date</label>
                                    <input type="date" class="form-control" id="language" name="productiondate" value="{{\carbon\carbon::parse($moive->production_date)->format('Y-m-d')}}"  style=" height: 24px"
                                        placeholder="production date" required />

                                 <label for="director">director</label>
                                    <input type="text" class="form-control" id="language" name="director" value="{{$moive->director}}" style=" height: 24px"
                                        placeholder="director" required />

                                <label for="Actors">Actors</label>
                                    <input type="text" class="form-control" id="language" name="Actors" value="{{$moive->Actors}}"  style=" height: 24px"
                                        placeholder="Actors" required />

                                <label for="Actors">Categories :</label>
<select name="Categories_id" class="form-control SlectBox">
                                        @foreach($Categories as $Categorie)
                                            <option
                                                value="{{$Categorie->id}}" {{$Categorie->id == $moive->categorie_id  ? 'selected':"" }}>{{$Categorie->title}}</option>
                                        @endforeach

                                        </select>




<label for="image" class="form-label"> Choose movie IMAGE</label>
  <input class="form-control" type="file" name="image" id="formFile" >
                             <img src="{{Url::asset('imagesmoives/moive/'. $moive->image)}}"
                                                 height="30px" width="40px" alt="">
    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
