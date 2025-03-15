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
                                            Add New Manger
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
                                        <form action="{{ route('mangers.Search')}}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <input class="form-control" name="textSearch" placeholder="search.." required>
                                                <button type="submit" class="btn btn-primary">Search</button>

                                            </div>

                                        </form>


                                    </div>


                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap" id="example2">
                                            <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>name</th>
                                                <th>Email</th>
                                                <th>phone</th>
                                                <th>created By</th>
                                                
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($mangers as $manger)
                                           
                                               <tr>
                                                   <td>{{$loop->iteration}}</td>
                                                   <td>{{$manger->name}}</td>
                                                   <td>{{$manger->email}}</td>
                                                   <td>{{$manger->phone}}</td>
                                                   <td>{{$manger->Admin->name}}</td>
                                                  
                                               
                                                
                                                   <td>
                                                       <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit"><i class="las la-pen"></i></a>
                                                       <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$manger->id}}"><i class="las la-trash"></i></a>
                                                   </td>
                                               </tr>
                                                {{-- @include('dashboard.movies.edit',compact('Categories'))--}}
                                                @include('dashboard.mangers.delete') 
                                               @endforeach
                                              

                                              

                                          
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- bd -->
                            </div><!-- bd -->
                  
                            @include('dashboard.mangers.add')
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