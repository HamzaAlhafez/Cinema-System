
@extends('layouts.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('css/ExploreCoupons.css') }}">
<div class="container py-5">
    <h1 class="mb-4 text-center fw-bold text-primary gradient-text">Available Promo Codes</h1>

    <div class="loyalty-card animateanimated animatefadeIn">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-coins fa-2x text-warning"></i>
                <span class="h4 ms-2">Your Points</span>
            </div>
            <span class="display-5 fw-bold text-success">{{ auth()->user()->loyalty_points }}</span>
        </div>
    </div>

    @if($AvailablePromoCodes->isEmpty())
        <div class="no-promo alert alert-info text-center shadow-lg">
            <i class="fas fa-tag fa-2x mb-3"></i>
            <h4 class="mb-0">No available offers currently</h4>
        </div>
    @else
        <div class="row g-4">
            @foreach($AvailablePromoCodes as $promo)
                <div class="col-lg-4 col-md-6">
                    <div class="promo-card @if($promo->expiry_date < now()) expired-card @endif">
                        <div class="ribbon"><span>{{ $promo->max_usage - $promo->used_count }} LEFT</span></div>
                        
                        <div class="card-body">
                            <div class="promo-header">
                                <div class="discount-badge">
                                    {{ $promo->value }}%
                                    <div class="triangle"></div>
                                </div>
                                <h3 class="promo-title">{{ $promo->description }}</h3>
                            </div>

                            <div class="requirements">
                                <div class="requirement-item">
                                    <i class="fas fa-clock text-danger"></i>
                                    <span class="expiry-date">{{ $promo->expiry_date->format('d M Y') }}</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-bolt text-warning"></i>
                                    <span class="points-needed">{{ $promo->points_required }} Points</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-repeat text-info"></i>
                                    <span class="usage-limit">Max {{ $promo->max_usage_per_user }} uses per user</span>
                                </div>
                            </div>

                            <div class="action-section">
                            @if(\App\Models\Purchasepromocode::where('user_id', auth()->id())
                      ->where('promocode_id', $promo->id)
                      ->exists())
                                    <div class="redeemed-badge">
                                        <i class="fas fa-check-circle"></i>
                                        Redeemed
                                    </div>
                                @else
                                    <form  method="POST" action="{{ route('promocodes.redeem') }}" class="promo-form">
                                        @csrf
                                        <input type="hidden" id="promo_id" name="promo_id" value="{{ $promo->id }}" />
                                        <input type="hidden" id="points_required" name="points_required" value="{{ $promo->points_required }}" />
                                        <button 
                                         type="submit" 
    class="@if($promo->expiry_date >= now() && $promo->is_active && auth()->user()->loyalty_points >= $promo->points_required) redeem-btn @else disabled-btn @endif"
    @if(auth()->user()->loyalty_points < $promo->points_required) disabled @endif
>
                                            <div class="btn-content">
                                                @if($promo->expiry_date < now())
                                                    <i class="fas fa-calendar-times"></i> Expired


@elseif(!$promo->is_active)
                                                    <i class="fas fa-ban"></i> Inactive
                                                @elseif(auth()->user()->loyalty_points < $promo->points_required)
                                                    <i class="fas fa-exclamation-triangle"></i> Need {{ $promo->points_required - auth()->user()->loyalty_points }} Points
                                                @else
                                                    <i class="fas fa-gift"></i> Get This Offer
                                                @endif
                                            </div>
                                            <div class="hover-effect"></div>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<script>
    document.querySelectorAll('.promo-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Confirm Redemption?',
                text: 'Are you sure you want to redeem this promo code?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, redeem it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'sweetalert-popup',
                    confirmButton: 'sweetalert-confirm',
                    cancelButton: 'sweetalert-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>


@include('components.flash-message')
@endsection