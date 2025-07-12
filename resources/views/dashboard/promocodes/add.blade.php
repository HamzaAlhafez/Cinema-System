<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Promocode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('promocodes.store')}}" method="post"  autocomplete="off">
                @csrf
                  <div class="modal-body">
                                    <label for="code">code :</label>
                                    <input type="text" class="form-control" id="code" name="code" style=" height: 30px"
                                        placeholder="code .. " required />
                                        @php
                                        use App\Models\Promocode;

                                        @endphp

                                        <label for="Type">Type :</label>
                                        <select name="type" class="form-control">
    @foreach(PromoCode::allowedTypes() as $type)
        <option value="{{ $type }}">{{ $type }}</option>
    @endforeach
</select>
<label for="description">description :</label>
                                    <input type="text" class="form-control" id="description" name="description" style=" height: 30px"
                                        placeholder="description .. " required />

                                 <label for="value">value :</label>
                                    <input type="number" class="form-control" id="value" name="value"style=" height: 30px"
                                        placeholder="value .."   required/>

                                        <label for="expiry_date">expiry date</label>
                                    <input type="date" class="form-control" id="expiry_date" name="expiry_date" style=" height: 30px"
                                        placeholder="expiry_date.." required />

                                        <label for="max_usage">max usage :</label>
                                    <input type="number" class="form-control" id="max_usage" name="max_usage" style=" height: 30px"
                                        placeholder="max_usage.." required />
                                        <label for="max_usage_per_user">max usage per user :</label>
                                    <input type="number" class="form-control" id="max_usage_per_user" name="max_usage_per_user" style=" height: 30px"
                                        placeholder="max usage per user.." required />

                                        <label for="points_required">points required :</label>
                                    <input type="number" class="form-control" id="points_required" name="points_required" style=" height: 30px"
                                        placeholder="points_required.." required />


                                
                                   










                                </div>
                                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>