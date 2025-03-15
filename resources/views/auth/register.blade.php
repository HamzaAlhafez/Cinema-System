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

                    <!-- ===== Start of Signup wrapper ===== -->
                    <div>
                        <div class="small-dialog-headline">
                            <h4 class="text-center">Sign Up</h4>
                        </div>

                        <div class="small-dialog-content">

                            <!-- Start of Registration form -->

                            <form  action="{{ route('register') }}" method="POST" autocomplete="off">
                                @csrf

                                <p class="status"></p>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="name">name</label>
                                         <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name"  placeholder="name..">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror



                                    </div>
                                    <div class="form-group col-6">
                                        <label for="phone">phone</label>
                                          <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="phone..">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror




                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">email</label>
                                     <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email..">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                </div>



                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="password">Password*</label>
                                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="password..">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                    </div>

                                    <div class="form-group col-6">
                                        <label for="password_confirmation">ReEnter Password</label>
                                        <input name="password_confirmation" id="password_confirmation"
                                            class="form-control" type="password" required  placeholder="confirmation.." />

                                    </div>
                                </div>



                                <div class="form-group">
                                    <input type="submit" class="btn btn-main btn-effect nomargin" value="Register" />
                                </div>
                            </form>
                            <!-- End of Registration form -->

                            <div class="bottom-links">
                                <span>
                                    Already have an account?
                                    <a href="{{ route('login') }}">Sign in</a>
                                </span>
                            </div>

                        </div> <!-- .small-dialog-content -->

                    </div>


                <a href={{ route('home') }} class="text-white">Back to Home</a>
            </div>
        </main>
    </div>
    <!-- =============== END OF WRAPPER =============== -->


</body>

</html>
