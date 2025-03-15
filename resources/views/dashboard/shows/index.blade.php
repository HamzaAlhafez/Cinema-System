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
                                            Add New Show
                                        </button>
                                    </div>
                                </div>
                                <br>
                                 @if(session('error'))

                     <div class="alert alert-danger">

                        <strong>{{session('error')}}</strong>

                    </div>


                    @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <form action="{{ route('shows.Search')}}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <input class="form-control" name="textSearch" placeholder="search..">
                                                <button type="submit" class="btn btn-primary">Search</button>

                                            </div>

                                        </form>


                                    </div>


                                </div>
                                
                                <div class="card-body">
                                                <?php 
                          use   App\Models\Movie;
                          use   App\Models\Hall;
                          $moives=Movie::all();
                          $halls=Hall::all();





?>
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap" id="example2">
                                            <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Moive</th>
                                                <th>Hall</th>
                                                <th>price</th>
                                                <th>date</th>
                                                  <th>Start time</th>
                                                <th>End Time</th>
                                                <th>remaining seats</th>
                                                
                                                
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($shows as $show)
                                           
                                               <tr>
                                                   <td>{{$loop->iteration}}</td>
                                                   <td>{{$show->Movie->title}}</td>
                                                   <td>{{$show->Hall->hall_name}}</td>
                                                   <td>{{$show->price . '$'}}</td>
                                                   <td>{{\carbon\carbon::parse($show->date)->format('Y-m-d')}}</td>
                                                   <td>{{\carbon\carbon::parse($show->start_time)->format('H:i')}}</td>
                                                   <td>{{\carbon\carbon::parse($show->end_time)->format('H:i')}}</td>
                                                   <td>{{$show->remaining_seats}}</td>
                                                    
                                               
                                                
                                                   <td>
                                                       <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$show->id}}"><i class="las la-pen"></i></a>
                                                       <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$show->id}}"><i class="las la-trash"></i></a>
                                                   </td>
                                               </tr>
                                                @include('dashboard.shows.edit')
                                               
                                                 @include('dashboard.shows.delete')
                                               
                                               @endforeach 

                                              

                                              

                                          
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- bd -->
                            </div><!-- bd -->
                 
                  
                            @include('dashboard.shows.add')
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