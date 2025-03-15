@extends('layouts.layout')

@section('content')
    <!-- =============== START OF MOVIE DETAIL INTRO =============== -->
    <section class="movie-detail-intro overlay-gradient ptb100"
        style="background: url({{ asset('images/branding/posters/movie-detail-bg.webp') }});">
    </section>
    <!-- =============== END OF MOVIE DETAIL INTRO =============== -->



    <!-- =============== START OF MOVIE DETAIL INTRO 2 =============== -->
    <section class="movie-detail-intro2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="movie-poster">
                        <img src="{{ asset('imagesmoives/moive/' . $shows->movie->image) }}" style="height: 440px" alt="">
                    </div>

                           <?php
                          use   App\Models\Categorie;
                          $Categories=Categorie::findorfail($shows->movie->categorie_id);




?>



                    <div class="movie-details">
                        <h3 class="title">{{ $shows->movie->title }}</h3>

                        <ul class="movie-subtext">
                            <li>Pg-3</li>
                             <li>{{$Categories->title}}</li>
                            <li>{{ $shows->date->format('d M Y') }}</li>


                        </ul>

                        <a href="#reserve-now" class="btn btn-main btn-effect">Get tickets</a>
                        <a href="#" class="btn rate-movie"><i class="icon-heart"></i></a>

                        <div class="rating mt10">
                            @php
                             $ratingshows=$shows->movie->rating;

                            

                            @endphp
                            @include('components.rating-stars', ['rating' => $ratingshows])
                            <span>{{ number_format($shows->movie->rating, 1) }}/5</span>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
    </section>

    <!-- =============== END OF RECOMMENDED MOVIES SECTION =============== -->
     <section class="movie-detail-main ptb100">
        <div class="container">

            <div class="row">
                <!-- Start of Movie Main -->
                <div class="col-lg-8 col-sm-12">
                    <div class="inner pr50">

                        <!-- Storyline -->
                        <div class="storyline">
                            <h3 class="title">Storyline</h3>

                            <p>{{ $shows->movie->storyline }}</p>
                        </div>

                        <!-- Shows -->
                        <div class="movie-media mt50">
                            <h3 id="reserve-now" class="title">Reserve your ticket!</h3>
                            {{-- {{ ddd($shows->first()->date) }} --}}


                                <div class="bg-light p-3 font-weight-bold rounded text-center">
                                    This service is currently unavailable at our site, check
                                    back later!
                                </div>

                        </div>

                    </div>
                </div>
                 <div class="col-lg-4 col-sm-12">
                    <div class="sidebar">

                        <!-- Start of Details Widget -->
                        <aside class="widget widget-movie-details">
                            <h3 class="title">Details</h3>

                            <ul>
                                <li><strong>production date:
                                    </strong>{{ $shows->movie->production_date->toFormattedDateString() }}
                                </li>
                                <li><strong>Director:
                                    </strong>{{ $shows->movie->director }}</li>
                                     <li><strong>Actors:
                                    </strong>{{ $shows->movie->Actors }}</li>
                                <li><strong>Language:
                                    </strong>{{ $shows->movie->language }}</li>
                                <li><strong>rating:
                                    </strong>{{ $shows->movie->rating }}</li>
                                <li><strong>Start Time:
                                    </strong>{{\carbon\carbon::parse($shows->start_time)->format('H:i')}}
                                </li>
                                 <li><strong>End Time:
                                    </strong>{{\carbon\carbon::parse($shows->end_time)->format('H:i')}}
                                </li>
                            </ul>
                        </aside>
                        <!-- End of Details Widget -->

                    </div>
                </div>
                <!-- End of Sidebar -->
            </div>

        </div>
    </section>


@endsection
