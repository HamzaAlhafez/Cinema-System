



<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Show</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('shows.store')}}" method="post"  autocomplete="off">
                @csrf
                  <div class="modal-body">
                                    <label for="movie_id">Movie :</label>
<select name="movie_id" class="form-control SlectBox">
                                        <option value="" selected disabled>------</option>
                                        @foreach($moives as $moive)
                                            <option value="{{$moive->id}}">{{$moive->title}}</option>
                                        @endforeach
                                    </select>
                                       <label for="hall_id">Hall :</label>
<select name="hall_id" class="form-control SlectBox">
                                        <option value="" selected disabled>------</option>
                                        @foreach($halls as $hall)
                                            <option value="{{$hall->id}}">{{$hall->hall_name}}</option>
                                        @endforeach
                                    </select>

                                 <label for="price">price</label>
                                    <input type="number" class="form-control" id="price" name="price"style=" height:30px"
                                        placeholder="price .." step="0.01" required />

                                  <label for="date">date </label>
                                    <input type="date" class="form-control" id="date" name="date" style=" height: 30px"
                                        placeholder="date .." required />

                                 <label for="start_time"> Start Time </label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" style=" height: 30px"
                                        placeholder="Start Time .." required />

                                 <label for="End_time"> End Time </label>
                                    <input type="time" class="form-control" id="End_time" name="End_time" style=" height: 30px"
                                        placeholder="End time .." required />
                                          








                                </div>
                                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
