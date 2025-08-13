@extends('dashboard.layouts.master')

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <h4 class="content-title mb-0 my-auto">🎬 Top Selling Movies</h4>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-body">
                <h4 class="card-title">Most Booked Movies in Cinema</h4>
                <canvas id="topMoviesChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    const movieNames = @json($movieNames);
    const ticketsCount = @json($ticketsCount);

    const ctx = document.getElementById('topMoviesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: movieNames,
            datasets: [{
                label: 'Tickets Sold',
                data: ticketsCount,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(201, 203, 207, 0.7)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54,162,235,1)',
                    'rgba(255,206,86,1)',
                    'rgba(75,192,192,1)',
                    'rgba(153,102,255,1)',
                    'rgba(255,159,64,1)',
                    'rgba(201, 203, 207, 1)'
                ],
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection