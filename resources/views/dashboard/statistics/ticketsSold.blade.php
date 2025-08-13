@extends('dashboard.layouts.master')

@section('css')
    {{-- ربط ملف Chart.js --}}
    <script src="{{ asset('js/chart.js') }}"></script> 
    {{-- ربط ملف Chart.js DataLabels --}}
    <script src="{{ asset('js/chartjs-plugin-datalabels.min.js') }}"></script>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Statistics</h4>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tickets Sold in {{ $currentYear }}</h4> <!-- تغيير العنوان -->
        <canvas id="ticketsChart" height="100"></canvas>
    </div>
</div>
@endsection

@section('js')
<script>
    // تسجيل البلجن
    Chart.register(ChartDataLabels);

    // البيانات من الـ Controller
    const months = @json($months);  // مثال: ["June", "July", "August"]
    const totals = @json($totals);  // مثال: [5, 42, 35]

    const ctx = document.getElementById('ticketsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Tickets Sold',
                data: totals,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#000',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => value
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection