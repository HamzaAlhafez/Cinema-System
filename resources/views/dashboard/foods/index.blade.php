@extends('dashboard.layouts.master')
@section('title')
    
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
      
				 <!-- breadcrumb -->
                
				 <div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
						</div>
					</div>
				</div> 
              
				<!-- breadcrumb --> 
@endsection
@section('content')
 @include('dashboard.messages_alert') 


                    

				<!-- row -->
                    <!-- row opened -->
                    <div class="row row-sm">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                                            Add New Food & Drink
                                        </button>
                                    </div>
                                </div>
                               
                               



                    
                               
                                         
                                
                                <div class="card-body">
                                <?php 
                          use App\Models\FoodCategory;
                          $FoodCategorys=FoodCategory::all();



?>
                                       
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap" id="example2">
                                            <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>name</th>
                                                <th>description</th>
                                                <th>price</th>
                                                <th>stock</th>
                                                <th>Item categore</th>
                                                <th>image</th>
                                                
                                               
                                                
                                               
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($foods as $food)
                                           
                                               <tr>
                                                   <td>{{$loop->iteration }}</td>
                                                   <td>{{$food->name}}</td>
                                                   <td>
                                                   @if($food->description !== null)
                                                    {{ $food->description }}
                                                   @else
                                                  <span class="text-muted">No description</span>
                                                 @endif
                                                 </td>
                                                   <td>{{$food->price}}</td>
                                                   <td>{{$food->stock}}</td>
                                                   <td>{{$food->stock}}</td>
                                                   <td>{{$food->FoodCategory->name}}</td>
                                                   <td>
                                                     <img src="{{Url::asset('imagesfoods/food/'. $food->image)}}"
                                                 height="100px" width="200px" alt="">


                                                </td>
                                                 
                                               
                                               
                                                   <td>
                                                       <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$food->id}}"><i class="las la-pen"></i></a>
                                                       <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$food->id}}"><i class="las la-trash"></i></a>
                                                   </td>
                                               </tr>
                                               @include('dashboard.foods.delete')
                                               @include('dashboard.foods.edit')
                                                
                                               @endforeach
                                              

                                              

                                          
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- bd -->
                            </div><!-- bd -->
                            @include('dashboard.foods.add')
                  
                            
                        </div>
                        <!--/div-->

                  
                    <!-- /row -->
                   
                   

				</div>
                
				<!-- row closed -->

			<!-- Container closed -->

		<!-- main-content closed -->
        
@endsection
@section('js')


    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifit-custom.js')}}"></script>
    

@endsection