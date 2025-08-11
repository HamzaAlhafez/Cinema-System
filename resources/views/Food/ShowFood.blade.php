
@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Menu - Cinema System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/ShowFood.css') }}">
</head>
<body>
    <div class="food-container">
        <!-- Header Section -->
        <header class="food-header">
            <div class="food-header-content">
                <h1>Cinema Menu</h1>
                <p>Discover our delicious selection of food and beverages</p>
            </div>
        </header>
        
        <div class="food-content">
            <!-- Food Selection Section -->
            <main>
                <!-- Food Categories -->
                <div class="food-categories">
                    <button class="food-category-btn active" data-category="all">All</button>
                    @foreach($categories as $category)
                    <button class="food-category-btn" data-category="{{ $category->id }}">{{ $category->name }}</button>
                    @endforeach
                </div>
                
                <!-- Food Items Grid -->
                <div class="food-items-grid">
                    @if($foods->count() > 0)
                        @foreach($foods as $food)
                        <div class="food-item-card" data-category="{{ $food->food_category_id }}">
                            <div class="food-item-image" style="background-image: url('{{ asset('imagesfoods/food/' . $food->image) }}');">
                                <div class="food-stock-info">Available: {{ $food->stock }}</div>
                                <div class="food-item-price">${{ number_format($food->price, 2) }}</div>
                            </div>
                            <div class="food-item-info">
                                <h3 class="food-item-name">{{ $food->name }}</h3>
                                @if($food->description !== null)
                                <p class="food-item-description">{{ $food->description }}</p>
                                @else
                                <span class="food-no-description">No description available</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="no-food-message">
                            <i class="fas fa-utensils-slash"></i>
                            <h3>No food items available at the moment</h3>
                            <p>We're sorry, but there are currently no food items in our menu. Please check back later.</p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
    
    <!-- Call to Action -->
    @if($foods->count() > 0)
    <div class="food-cta">
        <div class="food-cta-content">
            <div class="food-cta-text">
                <h2>Enjoy the complete cinema experience!</h2>
                <p>Book your ticket now to add these items to your order and enjoy an unforgettable experience</p>
            </div>
            <a href="{{ route('showsmoive.index') }}" class="food-cta-btn">
                <i class="fas fa-ticket-alt"></i> Book Now
            </a>
        </div>
    </div>
    @endif
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category selection
            const categoryBtns = document.querySelectorAll('.food-category-btn');
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {


              const categoryId = this.dataset.category;
                    
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const foodCards = document.querySelectorAll('.food-item-card');
                    foodCards.forEach(card => {
                        if (categoryId === 'all' || card.dataset.category === categoryId) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
@endsection