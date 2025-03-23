@extends('layouts.layout')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 700px;height: 500px;">
        <h3 class="text-center mb-3">Edit Profile</h3>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.update') }}" method="POST" class="d-flex flex-column h-100">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
            </div>

            <div class="mt-auto">
                <button type="submit" class="btn btn-primary w-100">Update</button>
            </div>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection
