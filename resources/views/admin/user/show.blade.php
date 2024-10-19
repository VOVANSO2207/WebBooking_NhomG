@extends('admin.layouts.master')

@section('admin-container')

<div class="container mt-4">
    <div class="card text-center" style="max-width: 400px; margin: auto;">
        <div class="card-header">
            <h4>User Details</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center mb-3">
                <img src="{{ asset('images/' . $user->avatar) }}" alt="Avatar" class="img-thumbnail rounded-circle"
                    style="width: 100%; height: auto; max-width: 120px;"
                    onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
            </div>

            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
            <p><strong>Role:</strong> {{ $user->role_id == 2 ? 'User' : ($user->role_id == 3 ? 'Admin' : 'Unknown') }}
            </p>
            <p><strong>Status:</strong>
                <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }}">
                    {{ $user->status ? 'Active' : 'Inactive' }}
                </span>
            </p>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.viewuser') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>

@endsection