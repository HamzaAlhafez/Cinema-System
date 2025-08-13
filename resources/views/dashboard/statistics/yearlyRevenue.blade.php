@extends('dashboard.layouts.master')

@section('css')
<script src="{{ asset('js/chart.js') }}"></script>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Yearly Revenue - {{ $currentYear }}</h4>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Total Revenue in {{ $currentYear }}: 
            <span style="color: green;">${{ number_format($totalRevenue, 2) }}</span>
        </h4>
        <canvas id="revenueChart" height="100"></canvas>
    </div>
</div>
@endsection

@section('js')
<script>
    const months = @json($months);
    const totals = @json($totals);

    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line', // خط أو 'bar' لو تحب
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Revenue ($)',
                data: totals,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, labels: { color: '#333' } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.formattedValue;
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection