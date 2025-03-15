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
				 @include('dashboard.messages_alert')
                <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<div class="container bootstrap snippets bootdey">
    <section id="contact" class="gray-bg padding-top-bottom">
    	<div class="container bootstrap snippets bootdey">
            <div class="row">
				<form id="Highlighted-form" class="col-sm-6 col-sm-offset-3" action="{{route('Admins.update',$admin->id)}}" method="post" novalidate="">
					   @csrf
					    @method('PATCH')


					<div class="form-group">
					  <label class="control-label" for="contact-name">Name</label>
					  <div class="controls">
						<input type="text" id="name" name="name" placeholder="Your name" class="form-control requiredField Highlighted-label" data-new-placeholder="Your name" type="text" data-error-empty="Please enter your name" value="{{$admin->name}}" required>
						<i class="fa fa-user"></i>
					  </div>
					</div>

					<div class="form-group">
					  <label class="control-label" for="contact-mail">Email</label>
					  <div class=" controls">
						<input type="email" id="email" name="email" placeholder="Your email" class="form-control requiredField Highlighted-label" data-new-placeholder="Your email" type="email" data-error-empty="Please enter your email" data-error-invalid="Invalid email address" value="{{$admin->email}}" required>
						<i class="fa fa-envelope"></i>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label" for="contact-mail">phone</label>
					  <div class=" controls">
						<input type="number" id="phone" name="phone" placeholder="Your phone" class="form-control requiredField Highlighted-label" data-new-placeholder="Your email" type="email" data-error-empty="Please enter your email" data-error-invalid="Invalid email address" value="{{$admin->phone}}" required>
						<i class="fa fa-phone"></i>
					  </div>
					</div>
					</div>
					<p><button name="submit" type="submit" class="btn btn-info btn-block" data-error-message="Error!" data-sending-message="Sending..." data-ok-message="Message Sent"><i class="fa fa-save"></i>Save Change</button></p>
					<input type="hidden" name="submitted" id="submitted" value="true">
				</form>
			</div>
		</div>
	</section>
    </div>
				<!-- breadcrumb -->
@endsection


@section('js')


    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifit-custom.js')}}"></script>


@endsection
