<!-- Modal -->
<div class="modal fade" id="edit{{$food->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Food & Drink</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('foods.update',$food->id)}}" method="post" enctype="multipart/form-data" autocomplete="off">
                 @csrf
                  @method('PUT')


                <div class="modal-body">
                <label for="name">name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$food->name}}"  style=" height: 30px"
                                        placeholder="name .. " required />


                                 <label for="description">description</label>
                                    <input type="text" class="form-control" id="description" name="description" value="{{$food->description}}" style=" height: 40px"
                                        placeholder="description.."  />

                                 <label for="price">price</label>
                                    <input type="number" class="form-control" id="price" name="price" value="{{$food->price}}" style=" height: 30px"
                                        placeholder="price.." step="0.01"   required/>


                                 <label for="stock">stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="{{$food->stock}}"    style=" height: 30px"
                                        placeholder="stock " step="0.01" required />

                               




                                    <label for="Categories_id"> Categories Item :</label>
<select name="Categories_id" class="form-control SlectBox">
                                        @foreach($FoodCategorys as $FoodCategory)
                                            <option
                                                value="{{$FoodCategory->id}}" {{$FoodCategory->id == $food->food_category_id  ? 'selected':"" }}>{{$FoodCategory->name}}</option>
                                        @endforeach

                                        </select>



                                <label for="image" class="form-label">Choose Item IMAGE</label>
  <input class="form-control" type="file" name="image" id="formFile" >
                             <img src="{{Url::asset('imagesfoods/food/'. $food->image)}}"
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