@extends('dashboard.layouts.master')

@section('css')
    <script src="{{ asset('js/chart.js') }}"></script>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <h4 class="content-title mb-0 my-auto">Top Users by Points</h4>
    </div>
</div>
@endsection

@section('content')




    <!-- الرسم البياني -->
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-body">
                
                <canvas id="topUsersChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    const userNames = @json($userNames);
    const userPoints = @json($pointsCount);

    const ctx = document.getElementById('topUsersChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: userNames,
            datasets: [{
                label: 'النقاط',
                data: userPoints,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54,162,235,1)',
                    'rgba(255,206,86,1)',
                    'rgba(75,192,192,1)',
                    'rgba(153,102,255,1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y', // عرض أفقي
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
</script>
@endsection