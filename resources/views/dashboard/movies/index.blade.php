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
                                            Add New Movie
                                        </button>
                                    </div>
                                </div>
                                <br>
                               



                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <form action="{{ route('movies.Search')}}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <input class="form-control" name="textSearch" placeholder="search.." required>
                                                <button type="submit" class="btn btn-primary">Search</button>

                                            </div>

                                        </form>


                                    </div>


                                </div>
                                
                                <div class="card-body">
                                        <?php 
                          use   App\Models\Categorie;
                          $Categories=Categorie::all();



?>
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap" id="example2">
                                            <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>title</th>
                                                <th>StoreLine</th>
                                                <th>language</th>
                                                <th>Rating</th>
                                                  <th>productiondate</th>
                                                <th>director</th>
                                                <th>Actors</th>
                                                <th>Categories</th>
                                                <th>IMAGE</th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($movies as $moive)
                                           
                                               <tr>
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td>{{$moive->title}}</td>
                                                   <td>{{$moive->storyline}}</td>
                                                   <td>{{$moive->language}}</td>
                                                   <td>{{$moive->rating}}</td>
                                                   <td>{{\carbon\carbon::parse($moive->production_date)->format('Y-m-d')}}</td>
                                                   

                                                   <td>{{$moive->director}}</td>
                                                    <td>{{$moive->Actors}}</td>
                                                     <td>{{$moive->Categorie->title }}</td>
                                               
                                                <td>
                                                     <img src="{{Url::asset('imagesmoives/moive/'. $moive->image)}}"
                                                 height="100px" width="200px" alt="">


                                                </td>
                                                   <td>
                                                       <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$moive->id}}"><i class="las la-pen"></i></a>
                                                       <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$moive->id}}"><i class="las la-trash"></i></a>
                                                   </td>
                                               </tr>
                                                @include('dashboard.movies.edit')
                                                @include('dashboard.movies.delete')
                                               @endforeach
                                              

                                              

                                          
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- bd -->
                            </div><!-- bd -->
                  
                            @include('dashboard.movies.add')
                        </div>
                        <!--/div-->

                  
                    <!-- /row -->
                     @include('dashboard.movies.add')
                   

				</div>
                 @include('dashboard.movies.add')
				<!-- row closed -->

			<!-- Container closed -->

		<!-- main-content closed -->
        
@endsection
@section('js')


    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifit-custom.js')}}"></script>
    

@endsection
