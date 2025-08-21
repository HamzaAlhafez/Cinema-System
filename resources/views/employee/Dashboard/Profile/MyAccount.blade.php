@extends('employee.Dashboard.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/EmployeeMyAccount.css') }}">

<div class="content">
    <div class="account-card animate-fadein">
        <!-- Header -->
        <div class="account-header">
            <i class="fa-solid fa-user-circle"></i>
            <h2 class="account-title">My Account</h2>
        </div>
        @if($errors->any())
    <div class="alert alert-danger" style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h5 class="alert-heading"><i class="fas fa-exclamation-circle"></i>An error occurred !</h5>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li><strong>{{ $error }}</strong></li>
            @endforeach
        </ul>
    </div>
@endif

        <form id="accountForm" action="{{ route('employee.account.update') }}" method="POST" class="account-form">
            @csrf
            @method('patch')

            <div class="form-grid">
                <!-- Name -->
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="form-input" required>
                    <i class="fa-solid fa-user"></i>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-input" required>
                    <i class="fa-solid fa-phone"></i>
                </div>

                <!-- Email -->
                <div class="form-group form-full">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="form-input" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
            </div>

            <button type="submit" class="btn-update">
                <i class="fa-solid fa-save"></i> Update Account
            </button>
        </form>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('accountForm').addEventListener('submit', function(e) {
    e.preventDefault(); // prevent immediate submit

    Swal.fire({
        title: 'Are you sure?',
        text: "Your account details will be updated!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6a3d85',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit(); // submit form if confirmed
        }
    });
});
</script>
@include('employee.flash-message')

@endsection