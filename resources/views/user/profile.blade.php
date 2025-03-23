@extends('layouts.layout')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <!-- إضافة "Personal Information" كعنوان رئيسي للجدول مع تنسيق مميز -->
                        <h3 class="fw-bold mb-4 p-3" style="background-color: #e9eff5; border: 1px solid #c4dbf1; border-radius: .25rem;">
                           <center>Personal Information</center>
                        </h3>
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th class="fw-bold">Name</th>
                                    <td class="text-muted">{{ auth()->user()->name }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Email</th>
                                    <td class="text-muted">{{ auth()->user()->email }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">Phone</th>
                                    <td class="text-muted">{{ auth()->user()->phone }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4 text-center">
                            <a href="{{ route('user.edit') }}" class="btn btn-primary btn-lg">Edit Profile</a>
                        </div>

                        <div class="mt-4">
                            <h5>Change Your Password</h5>
                            <form action="{{ route('user.ChangePassword') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" id="currentPassword" name="currentPassword" class="form-control" placeholder="Enter Current Password" required>
                                </div>

                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="Enter New Password" required>
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm New Password" required>
                                </div>

                                <button type="submit" class="btn btn-success btn-block mt-3">Update Password</button>
                            </form>
                        </div>

                        <!-- إضافة زر تعديل الملف الشخصي -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('Passwordchangedsuccessfully'))
        <div class="alert alert-success">
            {{ session('Passwordchangedsuccessfully') }}
        </div>
    @endif

    @if (session('CurrentpasswordFaild'))
        <div class="alert alert-danger">
            {{ session('CurrentpasswordFaild') }}
        </div>
    @endif
@endsection
