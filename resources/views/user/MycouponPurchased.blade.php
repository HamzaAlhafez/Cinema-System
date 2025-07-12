
@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/MycouponPurchased.css') }}">
<div class="container py-5">
    <h1 class="mb-5 text-center display-4 fw-bold gradient-animated">My Promo Codes</h1>
    
    <div class="row gy-4">
        @forelse($purchasedPromocodes as $purchase)
            @php
                $promo = $purchase->promocode;
                $isExpired = \Carbon\Carbon::parse($promo->expiry_date)->isPast();
                
                $userUsage = DB::table('promocodeusages')
    ->where('user_id', Auth::id())
    ->where('promocode_id', $promo->id)
    ->count();
            @endphp

            <div class="col-12 col-md-6 col-lg-4">
                <div class="voucher-card @if($isExpired) expired @endif" data-aos="zoom-in">
                    <div class="voucher-glare"></div>
                    <div class="voucher-content">
                        <div class="voucher-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="voucher-value">
                                    <span>{{ $promo->value . '%' }}</span>
                                   

                                    

                                    
                                </div>
                                <div class="voucher-status">
                                    @if($isExpired)
                                        <span class="badge bg-danger"><i class="fas fa-ban"></i> Expired</span>
                                    @elseif($userUsage==$promo->max_usage_per_user)
                                        <span class="badge bg-warning"><i class="fas fa-pause"></i> Paused</span>
                                    @else
                                        <span class="badge bg-success"><i class="fas fa-bolt"></i> Active</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="voucher-body">
                            <div class="voucher-code" onclick="copyCode('{{ $promo->code }}')">
                                {{ $promo->code }}
                                <div class="copy-hint">Click to copy</div>
                                <div class="shine"></div>
                            </div>
                            
                            <div class="voucher-meta">
                                <div class="meta-item">
                                    <i class="fas fa-user-clock"></i>
                                    <span>Your uses: {{ $userUsage }}/{{ $promo->max_usage_per_user }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-chart-line"></i>
                                    <span>Total uses: {{ $promo->used_count }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-hourglass-end"></i>
                                    <span>Expires: {{ $promo->expiry_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="voucher-progress">
                                <div class="progress-text">Usage progress</div>
                                <div class="progress-track">
                                    <div class="progress-fill" 
                                         style="width: {{ ($userUsage/$promo->max_usage_per_user)*100 }}%">
                                        <div class="progress-glow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="voucher-footer">


<div class="vendor-logo">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div class="purchase-info">
                                <div class="purchased-date">
                                    Redeemed: {{ $purchase->created_at->format('M d, Y') }}
                                </div>
                                <div class="terms-link">
                                    <a href="#" class="text-muted">Terms & Conditions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5" data-aos="fade-up">
                    <div class="empty-illustration mb-4">
                        <img src="{{ asset('images/empty-coupon.svg') }}" alt="No coupons" class="w-50">
                    </div>
                    <h3 class="mb-3 fw-bold">No Active Vouchers</h3>
                    <p class="text-muted">Collect loyalty points and unlock exclusive discounts!</p>
                    <button class="btn btn-primary mt-3 px-4 py-2">
                        <i class="fas fa-store me-2"></i>Visit Store
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="copy-success-toast position-fixed bottom-0 end-0 m-3">
    <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>Code copied to clipboard!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<script>
function copyCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        const toast = new bootstrap.Toast(document.querySelector('.copy-success-toast .toast'))
        toast.show()
    });
}
</script>
@include('components.flash-message')
@endsection