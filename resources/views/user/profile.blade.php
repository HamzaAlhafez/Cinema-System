@extends('layouts.layout')

@section('content')
<style>
    .custom-card-border {
        border: 3px solid #b0b0b0; 
        border-radius: 15px;       
        background-color: #f9f9f9; 
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- بطاقة موحدة --}}
            <div class="card shadow-lg custom-card-border p-4">

                {{-- صورة واسم المستخدم --}}
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-0">{{ auth()->user()->name }}</h3>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                </div>

                <hr>

                {{-- معلومات شخصية --}}
                <form action="{{ route('user.edit') }}" method="GET" class="mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-person-lines-fill"></i> Personal Information</h5>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" value="{{ auth()->user()->email }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" value="{{ auth()->user()->phone ?? '-' }}" class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </button>
                </form>

                <hr>

                {{-- زر إظهار تغيير كلمة المرور --}}
                <button class="btn btn-info text-white w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#passwordForm">
                    <i class="bi bi-shield-lock"></i> Change Password
                </button>

                {{-- فورم تغيير كلمة المرور (مخفي حتى الضغط) --}}
                <div class="collapse" id="passwordForm">
                    <form action="{{ route('user.ChangePassword') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" id="currentPassword" name="currentPassword" class="form-control" placeholder="Enter Current Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="Enter New Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm New Password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Update Password
                        </button>
                    </form>
                </div>

                {{-- رسائل النجاح أو الفشل --}}
                @if (session('Passwordchangedsuccessfully'))
                    <div class="alert alert-success mt-3">
                        {{ session('Passwordchangedsuccessfully') }}
                    </div>
                @endif
                @if (session('CurrentpasswordFaild'))
                    <div class="alert alert-danger mt-3">
                        {{ session('CurrentpasswordFaild') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- استدعاء أيقونات Bootstrap --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
{{-- استدعاء سكربت Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@extends('layouts.layout')

@section('content')
<style>
    .custom-card-border {
        border: 3px solid #b0b0b0; 
        border-radius: 15px;       
        background-color: #f9f9f9; 
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- بطاقة موحدة --}}
            <div class="card shadow-lg custom-card-border p-4">

                {{-- صورة واسم المستخدم --}}
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-0">{{ auth()->user()->name }}</h3>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                </div>

                <hr>

                {{-- معلومات شخصية --}}
                <form action="{{ route('user.edit') }}" method="GET" class="mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-person-lines-fill"></i> Personal Information</h5>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" value="{{ auth()->user()->email }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" value="{{ auth()->user()->phone ?? '-' }}" class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </button>
                </form>

                <hr>

                {{-- زر إظهار تغيير كلمة المرور --}}
                <button class="btn btn-info text-white w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#passwordForm">
                    <i class="bi bi-shield-lock"></i> Change Password
                </button>

                {{-- فورم تغيير كلمة المرور (مخفي حتى الضغط) --}}
                <div class="collapse" id="passwordForm">
                    <form action="{{ route('user.ChangePassword') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" id="currentPassword" name="currentPassword" class="form-control" placeholder="Enter Current Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="Enter New Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm New Password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Update Password
                        </button>
                    </form>
                </div>

                {{-- رسائل النجاح أو الفشل --}}
                @if (session('Passwordchangedsuccessfully'))
                    <div class="alert alert-success mt-3">
                        {{ session('Passwordchangedsuccessfully') }}
                    </div>
                @endif
                @if (session('CurrentpasswordFaild'))
                    <div class="alert alert-danger mt-3">
                        {{ session('CurrentpasswordFaild') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- استدعاء أيقونات Bootstrap --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
{{-- استدعاء سكربت Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
