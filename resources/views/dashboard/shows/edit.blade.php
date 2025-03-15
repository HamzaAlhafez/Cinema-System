<!-- Modal -->
<div class="modal fade" id="edit{{$show->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Show</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('shows.update',$show->id)}}" method="post"  autocomplete="off">
                 @csrf
                  @method('PUT')


                <div class="modal-body">
                                     <label for="movie_id">Moive :</label>
<select name="movie_id" class="form-control SlectBox">
                                        @foreach($moives as $moive)
                                            <option
                                                value="{{$moive->id}}" {{$moive->id == $show->movie_id  ? 'selected':"" }}>{{$moive->title}}</option>
                                        @endforeach
                                        </select>


                                                      <label for="movie_id">Hall :</label>
<select name="hall_id" class="form-control SlectBox">
                                        @foreach($halls as $hall)
                                            <option
                                                value="{{$hall->id}}" {{$hall->id == $show->hall_id  ? 'selected':"" }}>{{$hall->hall_name}}</option>
                                        @endforeach
                                        </select>



                                 <label for="price">price</label>
                                    <input type="number" class="form-control" id="price" name="price"style=" height:30px" value="{{$show->price}}"
                                        placeholder="price .." step="0.01" required />

                                  <label for="date">date </label>
                                    <input type="date" class="form-control" id="date" name="date" style=" height: 30px" value="{{\carbon\carbon::parse($show->date)->format('Y-m-d')}}"
                                        placeholder="date .." required />

                                 <label for="start_time"> Start Time </label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" style=" height: 30px" value="{{\carbon\carbon::parse($show->start_time)->format('H:i')}}"
                                        placeholder="Start Time .." required />

                                 <label for="End_time"> End Time </label>
                                    <input type="time" class="form-control" id="End_time" name="End_time" style=" height: 30px" value="{{\carbon\carbon::parse($show->end_time)->format('H:i')}}"
                                        placeholder="End time .." required />
                                          

                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
