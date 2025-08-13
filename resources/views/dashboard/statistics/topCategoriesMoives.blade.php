@extends('dashboard.layouts.master')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <h4 class="content-title mb-0 my-auto">Top Movie Categories by Bookings</h4>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Most Popular Categories</h5>

                @if(empty($categoryNames))
                    <p class="text-muted text-center">No booking data available</p>
                @else
                    <canvas id="categoriesChart" height="150"></canvas>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const categoryNames = @json($categoryNames);
    const bookingsCount = @json($bookingsCount);

    if (categoryNames.length > 0) {
        new Chart(document.getElementById('categoriesChart'), {
            type: 'bar', // تغيير النوع هنا (يمكنك استخدام 'bar'، 'pie'، 'line'، إلخ)
            data: {
                labels: categoryNames,
                datasets: [{
                    label: 'Bookings',
                    data: bookingsCount,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56',
                        '#4BC0C0', '#9966FF', '#FF9F40'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                // إضافة خيارات إضافية للشريط إذا كان النوع 'bar'
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
@endsection
