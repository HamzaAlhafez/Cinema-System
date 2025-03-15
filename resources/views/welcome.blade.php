@extends('layouts.layout')

@section('content')




    <!-- =============== START OF HOW IT WORKS SECTION =============== -->


    <section class="how-it-works4 pt50 pb100">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="title">How it works?</h2>
                    <h6 class="subtitle">Feeling confused? start here.</h6>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6 col-sm-12">
                    <div class="icon-box2">
                        <i class="fa fa-film"></i>
                        <h4 class="title">Pick your movie</h4>
                        <p>Browse our extensive and exciting collection of movies. Still don't know what to watch? take a
                            look at our
                    </div>

                    <div class="icon-box2">
                        <i class="fa fa-ticket"></i>
                        <h4 class="title">Reserve your ticket</h4>
                        <p>Reserve your ticket to your favourite movie!</p>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="icon-box2">
                        <i class="icon-login"></i>
                        <h4 class="title">Register</h4>
                        <p>Register your account to reserve and pay for tickets. Also to stay up to date with the latest
                            offers and news.</p>
                    </div>

                    <div class="icon-box2">
                        <i class="icon-heart"></i>
                        <h4 class="title">Enjoy!</h4>
                        <p>Enjoy your movie at one of our cinema rooms, order snacks while you're at it. Your convinence is
                            our priority.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- =============== START OF FEATURES SECTION =============== -->
    <section class="features">
        <div class="row">

            <div class="col-md-6 col-sm-12 with-bg overlay-gradient"
                style="background: url({{ asset('images/other/people-cinema.jpg') }})"></div>

            <div class="col-md-6 col-sm-12 bg-white">
                <div class="features-wrapper">
                    <h3 class="title">Watch all newest Movies once they get released!</h3>
                    @guest
                        <p>Sign up or register now to reserve you own tickets. And get notified on new offers and news!</p>
                        <a class="btn btn-main btn-effect" href="{{ route('register') }}">Register</a>
                    @endguest

                    @auth
                        <p>Start reserving your tickets to enjoy the latest and greatest movies!</p>
                        <a class="btn btn-main btn-effect" href="{{route('showsmoive.index')}}">Shows</a>
                    @endauth
                </div>
            </div>

        </div>
    </section>
    <!-- =============== END OF FEATURES SECTION =============== -->




    @include('components.flash-message')
    <!-- =============== END OF SUBSCRIBE SECTION =============== -->
@endsection
