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
                            <h4 class="text-center">Sign in</h4>
                        </div>



                        <div class="small-dialog-content">

                            <!-- Start of Login form -->
                            <form id="login_form" method="post" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                      @if ($errors->has('errorresponse'))
                                 <span class="text-danger">
                                        <strong>{{ $errors->first('errorresponse') }}</strong>
                                    </span>



                                @endif

                                    <label for="userlogin">Email / phone</label>
                                    <input type="text" class="form-control" id="userlogin" name="userlogin"
                                        placeholder="Your Email / phone *" required />
                                           @error('userlogin')
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
                                    <a href="{{ route('register') }}">Sign up</a>
                                </span>

                            </div>
                            <div class="bottom-links">
                                <span>
                                    login as admin?
                                    <a href="{{ route('admin.dashboard.login') }}">admin</a>
                                </span>
                        </div>






                    </div>
                    <!-- ===== End of Signin wrapper ===== -->





                <!-- =============== END OF LOGIN & REGISTER POPUP =============== -->

                <a href={{ route('home') }} class="text-white">Back to Home</a>
            </div>
        </main>
    </div>
    <!-- =============== END OF WRAPPER =============== -->


     @include('components.flash-message')




</body>

</html>
