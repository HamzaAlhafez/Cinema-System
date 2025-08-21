@extends('employee.Dashboard.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/EmployeeChangePassword.css') }}">

<div class="content">
    <div class="account-card animate-fadein">
        <!-- Header -->
        <div class="account-header">
            <i class="fa-solid fa-shield-halved"></i>
            <h2 class="account-title">Change Password</h2>
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

        <form id="changePasswordForm" action="{{ route('employee.password.update') }}" method="POST" class="account-form">
            @csrf
            @method('PATCH')

            <div class="form-grid">
                <!-- Current Password -->
                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-input" required>
                    <i class="fa-solid fa-lock"></i>
                    @error('current_password')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-input" required minlength="8">
                    <i class="fa-solid fa-key"></i>
                    @error('password')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required minlength="8">
                    <i class="fa-solid fa-check-double"></i>
                </div>
            </div>

            <button type="submit" class="btn-update">
                <i class="fa-solid fa-floppy-disk"></i> Change Password
            </button>
        </form>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to change your password?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6a3d85',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});


</script>
@include('employee.flash-message')

@endsection