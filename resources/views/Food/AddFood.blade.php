
@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food & Drinks - Cinema System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
<link rel="stylesheet" href="{{ asset('css/AddFood.css') }}"> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="food-container">
        <!-- Header Section -->
        <header class="food-header">
            <div class="food-header-content">
                <h1>Add Food & Drinks</h1>
                <p>Choose from our diverse menu and add to your ticket</p>
            </div>
            <div class="food-ticket-info">
                <div class="ticket-label">Ticket Number</div>
                <div class="food-ticket-id">#{{ $ticketId }}</div>
            </div>
        </header>
        
        <div class="food-content">
            <!-- Food Selection Section -->
            <main>
                <!-- Food Categories -->
                <div class="food-categories">
                    <button class="food-category-btn active" data-category="all">All Items</button>
                    @foreach($categories as $category)
                    <button class="food-category-btn" data-category="{{ $category->id }}">{{ $category->name }}</button>
                    @endforeach
                </div>
                
                <!-- Food Items Grid -->
                <div class="food-items-grid">
                    @foreach($foods as $food)
                    <div class="food-item-card" data-category="{{ $food->food_category_id }}">
                        <div class="food-item-image" style="background-image: url('{{ asset('imagesfoods/food/' . $food->image) }}');">
                            <div class="food-stock-info">Available: {{ $food->stock }}</div>
                            <div class="food-item-price">${{ number_format($food->price, 2) }}</div>
                        </div>
                        <div class="food-item-info">
                            <h3 class="food-item-name">{{ $food->name }}</h3>
                            @if($food->description !== null)
                            <p class="food-item-description">{{ $food->description  }}</p>
                                                   @else
                                                  <span class="text-muted">No description</span>
                                                 @endif
                           
                            <div class="food-item-actions">
                                <div class="food-quantity-control">
                                    <button class="food-quantity-btn decrease">-</button>
                                    <span class="food-quantity">1</span>
                                    <button class="food-quantity-btn increase">+</button>
                                </div>
                                <button class="food-add-btn" data-food-id="{{ $food->id }}" data-food-name="{{ $food->name }}" data-food-price="{{ $food->price }}">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </main>
            
            <!-- Cart Section -->
            <aside class="food-cart-container">
                <div class="food-cart-header">
                    <h2 class="food-cart-title">Your Cart</h2>
                    <div class="cart-icon">
                        <i class="fas fa-shopping-basket fa-lg"></i>
                    </div>
                </div>
                
                <form action="{{ route('ticket-foods.store') }}" method="POST" id="food-form">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticketId }}">
                    
                    <div class="food-cart-items" id="cart-items">
                        <div class="food-empty-cart">
                            <i class="fas fa-shopping-basket"></i>
                            <p>Your cart is empty</p>
                            <p>Select items to add</p>
                        </div>
                    </div>
                    
                    <div class="food-cart-summary">
                        <div class="food-total-row">
                            <span>Total</span>
                            <span id="total">$0.00</span>
                        </div>
                    </div>
                    
                    <button class="food-checkout-btn" id="checkout-btn" type="submit" disabled>
                        <i class="fas fa-ticket-alt"></i> Add to Ticket
                    </button>
                </form>
            </aside>
        </div>
    </div>
    @include('components.flash-message')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    let cart = [];
    
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
    
    // Quantity buttons in food cards
    document.querySelectorAll('.food-quantity-control').forEach(control => {
        const decreaseBtn = control.querySelector('.decrease');
        const increaseBtn = control.querySelector('.increase');
        const quantitySpan = control.querySelector('.food-quantity');
        
        decreaseBtn.addEventListener('click', function() {
            let quantity = parseInt(quantitySpan.textContent);
            if (quantity > 1) {
                quantity--;
                quantitySpan.textContent = quantity;
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            let quantity = parseInt(quantitySpan.textContent);
            const stock = parseInt(this.closest('.food-item-card').querySelector('.food-stock-info').textContent.replace('Available: ', ''));
            
            if (quantity < stock) {
                quantity++;
                quantitySpan.textContent = quantity;
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maximum Quantity Reached',
                    text: `You can't order more than available stock (${stock})`,
                    confirmButtonColor: '#4a6cf7',
                });
            }
        });
    });
    
    // Add to cart buttons
    document.querySelectorAll('.food-add-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const foodId = this.dataset.foodId;
            const foodName = this.dataset.foodName;
            const foodPrice = parseFloat(this.dataset.foodPrice);
            const quantity = parseInt(this.closest('.food-item-actions').querySelector('.food-quantity').textContent);
            const stock = parseInt(this.closest('.food-item-card').querySelector('.food-stock-info').textContent.replace('Available: ', ''));
            
            // Check if item already in cart
            const existingItem = cart.find(item => item.id === foodId);
            const totalRequested = existingItem ? existingItem.quantity + quantity : quantity;
            
            // Validate stock
            if (quantity > stock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Not Enough Stock',
                    text: `Sorry, we only have ${stock} ${foodName}(s) available.`,
                    confirmButtonColor: '#4a6cf7',
                });
                return;
            }
            
            if (totalRequested > stock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Exceeds Available Stock',
                    text: `You already have ${existingItem.quantity} in cart. Only ${stock} ${foodName}(s) available total.`,
                    confirmButtonColor: '#4a6cf7',
                });
                return;
            }
            
            addToCart(foodId, foodName, foodPrice, quantity);
            this.closest('.food-item-actions').querySelector('.food-quantity').textContent = '1';
            
            // Notification
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: `Added ${quantity} ${foodName}(s) to cart`,
                showConfirmButton: false,
                timer: 1500,
                toast: true
            });
        });
    });
    
    function addToCart(id, name, price, quantity) {
        const existingItem = cart.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                quantity: quantity
            });
        }
        
        updateCartDisplay();
    }
    
    function updateCartDisplay() {
        const cartItems = document.getElementById('cart-items');
        const checkoutBtn = document.getElementById('checkout-btn');
        const form = document.getElementById('food-form');
        
        document.querySelectorAll('[name^="items["]').forEach(el => el.remove());
        
        if (cart.length === 0) {
            cartItems.innerHTML = `
                <div class="food-empty-cart">
                    <i class="fas fa-shopping-basket"></i>
                    <p>Your cart is empty</p>
                    <p>Select items to add</p>
                </div>
            `;
            checkoutBtn.disabled = true;
            document.getElementById('total').textContent = '$0.00';
            return;
        }
        
        let cartHTML = '';
        let total = 0;
        
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            
            // Add hidden inputs to form
            addHiddenInput(form, `items[${index}][food_id]`, item.id);
            addHiddenInput(form, `items[${index}][quantity]`, item.quantity);
            addHiddenInput(form, `items[${index}][total_price]`, itemTotal);
            
            // Cart item display
            cartHTML += `
                <div class="food-cart-item">
                    <button class="food-remove-btn" type="button" data-item-id="${item.id}">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="food-item-details">
                        <div class="food-item-title">${item.name}</div>
                        <div class="food-item-cost">$${item.price.toFixed(2)} each</div>
                    </div>
                    <div class="food-item-qty">
                        <button class="food-quantity-btn decrease" type="button">-</button>
                        <span class="food-quantity">${item.quantity}</span>
                        <button class="food-quantity-btn increase" type="button">+</button>
                    </div>
                    <div class="food-item-total">$${itemTotal.toFixed(2)}</div>
                </div>
            `;
        });
        
        cartItems.innerHTML = cartHTML;
        document.getElementById('total').textContent = `$${total.toFixed(2)}`;
        checkoutBtn.disabled = false;
        
        // Add event listeners to cart items
        document.querySelectorAll('.food-remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                removeCartItem(itemId);
            });
        });
        
        document.querySelectorAll('.food-cart-item .decrease').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.closest('.food-cart-item').querySelector('.food-remove-btn').dataset.itemId;
                updateCartItemQuantity(itemId, -1);
            });
        });
        
        document.querySelectorAll('.food-cart-item .increase').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.closest('.food-cart-item').querySelector('.food-remove-btn').dataset.itemId;
                updateCartItemQuantity(itemId, 1);
            });
        });
    }
    
    function addHiddenInput(form, name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }
    
    function updateCartItemQuantity(id, change) {
        const item = cart.find(item => item.id === id);
        
        if (item) {
            // Get current stock
            const foodCard = document.querySelector(`.food-add-btn[data-food-id="${id}"]`).closest('.food-item-card');
            const stock = parseInt(foodCard.querySelector('.food-stock-info').textContent.replace('Available: ', ''));
            
            // Validate new quantity
            const newQuantity = item.quantity + change;
            
            if (newQuantity > stock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Not Enough Stock',
                    text: `Sorry, we only have ${stock} ${item.name}(s) available.`,
                    confirmButtonColor: '#4a6cf7',
                });
                return;
            }
            
            if (newQuantity <= 0) {
                removeCartItem(id);
                return;
            }
            
            item.quantity = newQuantity;
            updateCartDisplay();
        }
    }
    
    function removeCartItem(id) {
        Swal.fire({
            title: 'Remove Item?',
            text: "Are you sure you want to remove this item from your cart?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                cart = cart.filter(item => item.id !== id);
                updateCartDisplay();
                
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Item removed',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true
                });
            }
        });
    }
    
    // Checkout button event
    document.getElementById('checkout-btn').addEventListener('click', function(e) {
        e.preventDefault();
        
        if (cart.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Empty Cart',
                text: 'Your cart is empty! Please add items before checkout.',
            });
            return;
        }
        
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const itemsCount = cart.reduce((count, item) => count + item.quantity, 0);
        
        Swal.fire({
            title: 'Add to Ticket?',
            html: `You are about to add <strong>${itemsCount} items</strong> to your ticket<br>Total: <strong>$${total.toFixed(2)}</strong>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4a6cf7',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'sweetalert-popup',
                confirmButton: 'sweetalert-confirm',
                cancelButton: 'sweetalert-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('food-form').submit();
            }
        });
    });
});
</script>

    
   
</body>
</html>
@endsection
