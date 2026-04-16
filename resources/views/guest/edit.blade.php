@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning">
        <h4 class="mb-0">Edit Guest</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('guests.update', $guest->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $guest->user->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $guest->user->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $guest->phone_number) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control">{{ old('address', $guest->address) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ $guest->user->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $guest->user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Guest</button>
            <a href="{{ route('guests.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection