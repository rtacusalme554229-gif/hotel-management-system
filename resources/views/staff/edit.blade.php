@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning">
        <h4 class="mb-0">Edit Staff</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $staff->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $staff->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password (optional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="staff" {{ $staff->role === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="manager" {{ $staff->role === 'manager' ? 'selected' : '' }}>Manager</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ $staff->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $staff->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Staff</button>
            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection