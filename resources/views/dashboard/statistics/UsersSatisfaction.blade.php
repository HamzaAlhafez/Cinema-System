@extends('dashboard.layouts.master')
@section('css')
    {{-- Chart.js --}}
    <script src="{{ asset('js/chart.js') }}"></script>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Statistics</h4>
            <span class="text-muted mt-1 tx-13 ms-2 mb-0">/ User Satisfaction</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">User Satisfaction Ratings (Averages)</h4>
        <div style="height:420px; position:relative;">
            <canvas id="satisfactionChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
(function () {
    const canvas = document.getElementById('satisfactionChart');
    if (!canvas) return;

    // 🧹 دمر أي مخطط سابق
    if (window.Chart && typeof Chart.getChart === 'function') {
        const existing = Chart.getChart(canvas);
        if (existing) existing.destroy();
    }

    /
    const rawKeys   = @json($criteria ?? []);
    const rawValues = @json($values ?? []);

   
    const labelsMap = {
        'movie_quality': 'Movie Quality',
        'hall_cleanliness': 'Hall Cleanliness',
        'seat_comfort': 'Seat Comfort',
        'sound_quality': 'Sound Quality',
        'screen_quality': 'Screen Quality',
        'food_quality': 'Food Quality',
        'staff_behavior': 'Staff Behavior',
        'overall_experience': 'Overall Experience'
    };

   
    const rows = rawKeys.map((k, i) => ({
        label: labelsMap[k] || k,
        val: Number(rawValues[i])
    })).filter(r => Number.isFinite(r.val));

    const labels = rows.map(r => r.label);
    const data   = rows.map(r => r.val);

 
    new Chart(canvas, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Average Rating',
                data,
                borderWidth: 2,
                borderRadius: 8,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1,
                        callback: (v) => v + '/5'
                    },
                    title: { display: true, text: 'Average Rating (out of 5)' }
                },
                y: {
                    title: { display: true, text: 'Rating Criteria' }
                }
            },
            plugins: {
                legend: { display: true, position: 'top' },
                tooltip: {
                    callbacks: {
                        label: (ctx) => 'Rate' + Number(ctx.raw).toFixed(2) + '/5'
                    }
                }
            },
            animation: { duration: 700, easing: 'easeOutQuart' }
        }
    });
})();
</script>
@endsection