
@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineMagic - Ultimate Cinema Experience</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Home.css') }}">
    
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">


            <h1>Experience The Magic of Cinema</h1>
            <p>Book your tickets now for an unforgettable movie experience</p>
            <div class="hero-btns">
                <a href="#now-showing" class="btn">Book Tickets</a>
                <a href="#promotions" class="btn btn-secondary">View Promotions</a>
            </div>
        </div>
        <div class="scroll-down">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- Now Showing Section -->
    <section class="now-showing" id="now-showing">
    <div class="container">
        <div class="section-title">
            <h2>Now Showing</h2>
        </div>
        <div class="movies-container">
            @php
                $groupedShows = $shows->groupBy('movie_id');
            @endphp
            
            @if($groupedShows->isNotEmpty())
                @foreach($groupedShows as $movieId => $showsForMovie)
                    @php
                        $movie = $showsForMovie->first()->movie;
                        $showsByDate = $showsForMovie->groupBy(function($show) {
                            return \Carbon\Carbon::parse($show->date)->format('Y-m-d');
                        });
                    @endphp
                    
                    <div class="movie-card fade-in">
                        <div class="movie-poster" style="background-image: url('{{ asset('imagesmoives/moive/' . $movie->image) }}');"></div>
                        <div class="movie-info">
                            <h3>{{ $movie->title }}</h3>
                            <div class="movie-meta">
                                <span>{{ $movie->language }}</span>
                                <span><i class="fas fa-star"></i> {{ $movie->rating }}</span>
                            </div>
                            <p>{{ \Illuminate\Support\Str::limit($movie->storyline, 100) }}</p>
                            
                            <div class="shows-container">
                                <div class="shows-title">
                                    <i class="fas fa-clock"></i> Show Times
                                </div>
                                <div class="show-dates">
                                    @foreach($showsByDate as $date => $showsOnDate)
                                        <div class="show-date">
                                            <a href="{{ route('showsmoive.show', $showsOnDate->first()->id) }}" class="date-link">
                                                <div class="date-label">
                                                    <i class="fas fa-calendar"></i>
                                                    {{ \Carbon\Carbon::parse($date)->format('l, M d') }}
                                                </div>
                                            </a>
                                            <div class="show-times">
                                                @foreach($showsOnDate as $show)
                                                    <span class="show-time">
                                                        {{ \Carbon\Carbon::parse($show->start_time)->format('H:i') }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state fade-in">
                    <i class="fas fa-film"></i>
                    <h3>No Movies Showing Today</h3>
                    <p>We don't have any movies showing today. Please check back later for our latest showings!</p>
                    <a href="#coming-soon" class="btn">View Upcoming Movies</a>
                </div>
            @endif
        </div>
    </div>
    
   

   <!-- Coming Soon Section  -->
<section class="coming-soon" id="coming-soon">
    <div class="container">
        <div class="section-title coming-title">
            <h2>Coming Soon</h2>
        </div>
        <div class="coming-soon-container">
            @if($comingSoon->isNotEmpty())
                @foreach($comingSoon as $movie)
                <div class="coming-card fade-in">
                    <div class="movie-genre">{{ $movie->Categorie->title}}</div>
                    <div class="coming-poster" style="background-image: url('{{ asset('imagesmoives/moive/' . $movie->image) }}');">
                        <div class="rating-badge">
                            <i class="fas fa-star"></i> {{ $movie->rating }}
                        </div>
                        <div class="coming-overlay">
                            <div class="coming-overlay-content">
                                <h3>{{ $movie->title }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit($movie->storyline, 100) }}</p>
                                <div class="notification-message">
                                    <i class="fas fa-envelope"></i>
                                    <span>We'll email you when this movie is available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state fade-in">
                    <i class="fas fa-calendar-plus"></i>
                    <h3>No Upcoming Movies</h3>
                    <p>We don't have any upcoming movies scheduled yet. Stay tuned for exciting announcements!</p>
                    <a href="#now-showing" class="btn">Check Current Movies</a>
                </div>
            @endif
        </div>
    </div>
</section>

    <!-- Premium Experience Section -->
    <section class="premium" id="premium">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;">Cinema Experience</h2>
            </div>
            <div class="premium-container">
                <div class="premium-feature fade-in">
                    <div class="premium-icon">
                        <i class="fas fa-couch"></i>
                    </div>
                    <h3>Luxury Seating</h3>
                    <p>Experience ultimate comfort with our premium leather recliners that feature adjustable headrests, footrests, and personal cup holders.</p>
                </div>
                
                <div class="premium-feature fade-in">
                    <div class="premium-icon">
                        <i class="fas fa-film"></i>
                    </div>
                    <h3>IMAX & 3D</h3>
                    <p>Immerse yourself in crystal-clear images and powerful surround sound with our state-of-the-art IMAX and 3D projection systems.</p>
                </div>
                
                <div class="premium-feature fade-in">
                    <div class="premium-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h3>Loyalty Rewards</h3>
<p>Earn points with every purchase and redeem them for exclusive discount coupons towards your next movie tickets.</p>
                 
                </div>
            </div>
        </div>
    </section>


<!-- Promotions Section - Redesigned -->
<section class="promotions" id="promotions">
    <div class="container">
        <div class="section-title promotions-title">
            <h2>Special Offers</h2>
            <p>Exclusive discounts for our valued customers</p>
        </div>
        <div class="promo-container">
            @if($promocodes->isNotEmpty())
                @foreach($promocodes as $promo)
                <div class="promo-card fade-in">
                    <div class="promo-glow"></div>
                    <div class="promo-badge">
                        <span class="promo-value">{{ $promo->value }}%</span>
                        <span class="promo-off">OFF</span>   
                    </div>
                    <div class="promo-content">
                        <div class="promo-header">
                            <h3>{{ $promo->description }}</h3>
                            <span class="promo-type">{{ $promo->type }}</span>
                        </div>
                        <div class="promo-details">
                            <p>Use code: <strong class="promo-code">MOVIE{{ $promo->id }}</strong> at checkout</p>
                            <div class="promo-meta">
                                <div class="promo-expiry">
                                    <i class="fas fa-clock"></i>
                                    <span>Expires: {{ \Carbon\Carbon::parse($promo->expiry_date)->format('M d, Y') }}</span>
                                </div>
                                <span class="promo-uses">Uses left: {{ $promo->max_usage }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                @auth
                <div class="promo-action">
                    <a href="{{ route('promocodes.Show') }}" class="promo-main-btn">
                        <i class="fas fa-ticket-alt"></i> Buy Coupons Now
                    </a>
                </div>
                @endauth
                
            @else
                <div class="empty-state fade-in">
                    <i class="fas fa-tag"></i>
                    <h3>No Current Promotions</h3>
                    <p>We don't have any active promotions at the moment. Check back later for special offers!</p>
                    <a href="#now-showing" class="btn">View Movies</a>
                </div>
            @endif
        </div>
    </div>
</section>
                        



                           
                       

    <!-- Recommended Section -->
    @auth
        @if(isset($recommendedShows) && $recommendedShows->isNotEmpty())
            <section class="recommended" id="recommended">
                <div class="container">
                    <div class="recommended-title">
                        <div></div>
                        <h2>Recommended For You</h2>
                        <div></div>
                    </div>
                    
                    <div class="recommended-container">
                        @foreach($recommendedShows as $show)
                            @php
                                $movie = $show->movie;
                                $date = \Carbon\Carbon::parse($show->date);
                            @endphp
                            
                            <div class="recommended-card fade-in">
                                <div class="recommended-badge">
                                       <a href="{{ route('showsmoive.show', $show->id) }}" class="date-link">
                                    <i class="fas fa-star"></i> TOP PICK
                                </div>
                                </a>
                                <div class="recommended-poster" 
                                     style="background-image: url('{{ asset('imagesmoives/moive/' . $movie->image) }}');">
                                    <div class="recommended-overlay">
                                        <h3>{{ $movie->title }}</h3>
                                        <div class="recommended-meta">
                                            <span>{{ $movie->categorie->title }}</span>
                                            
                                        </div>
                                        <div class="recommended-times">
                                            <div class="date-label">
                                                <i class="fas fa-calendar"></i>
                                                {{ $date->format('l, M d') }}
                                            </div>
                                            <div class="show-times">
                                            <span class="show-time recommended">
                                                    {{ \Carbon\Carbon::parse($show->start_time)->format('H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endauth
    @include('components.flash-message')

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Add fade-in animation when elements come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.movie-card, .coming-card, .promo-card, .empty-state, .recommended-card, .premium-feature').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>
@endsection