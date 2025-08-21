@extends('employee.Dashboard.layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/hall-maintenance.css') }}">

<div class="container py-5">
    <h2>Hall Maintenance</h2>

    <button type="button" class="btn btn-purple mb-3" data-bs-toggle="modal" data-bs-target="#addHallModal">
        Add Hall to Maintenance
    </button>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hall Name</th>
                    <th>Start Date</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($HallMaintenances as $maintenance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $maintenance->hall->hall_name }}</td>
                    <td>{{ $maintenance->start_date }}</td>
                    <td>{{ $maintenance->notes ?? '-' }}</td>
                    <td>
                        <form action="{{ route('HallMaintenances.destroy', $maintenance->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No halls under maintenance.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('employee.Dashboard.HallMaintenances.Add')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to remove this hall from maintenance!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5e2b97',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    })
}
</script>
@include('employee.flash-message')

@endsection
