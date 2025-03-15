<html lang="en">
@include('layouts.head')

<body>

    <!-- =============== START OF WRAPPER =============== -->
    <div class="wrapper">
        <main class="login-register-page"
            style="background-image: url({{ asset('images/branding/posters/movie-collection.webp') }})">
            <div class="container">



                <!-- =============== START OF LOGIN & REGISTER POPUP =============== -->
                <div class="small-dialog login-register">



                    <!-- ===== Start of Signin wrapper ===== -->
                    <div class="signin-wrapper">
                        <div class="small-dialog-headline">
                            <h4 class="text-center">Admin Sign in</h4>
                        </div>



                        <div class="small-dialog-content">

                            <!-- Start of Login form -->
                            <form id="login_form" method="post" action="{{ route('admin.dashboard.check') }}">
                                @csrf

                                <div class="form-group">
                                      @if ($errors->has('errorresponse'))
                                 <span class="text-danger">
                                        <strong>{{ $errors->first('errorresponse') }}</strong>
                                    </span>



                                @endif

                                    <label for="login">Email / phone</label>
                                    <input type="text" class="form-control" id="userlogin" name="login"
                                        placeholder="Your Email / phone *" required />
                                           @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                </div>

                                <div class="form-group">
                                    <label for="password">Password*</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Your Password *" required />
                                </div>

                              


                                <div class="form-group">
                                    <input type="submit" value="Sign in" class="btn btn-main btn-effect nomargin" />
                                </div>
                            </form>
                            <!-- End of Login form -->

                            <div class="bottom-links">
                                <span>
                                    Not a member?
                                    <a href="{{ route('admin.dashboard.register') }}">Sign up</a>
                                </span>

                            </div>
                            <div class="bottom-links">
                                <span>
                                    login as user?
                                    <a href="{{ route('login') }}">User</a>
                                </span>
                        </div>

                    </div>


                <a href={{ route('home') }} class="text-white">Back to Home</a>
            </div>
        </main>
    </div>
    <!-- =============== END OF WRAPPER =============== -->


     @include('components.flash-message')




</body>

</html>
