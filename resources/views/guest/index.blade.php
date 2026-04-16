@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Guests</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                    <tr>
                        <td>{{ $guest->id }}</td>
                        <td>{{ $guest->user->name ?? 'N/A' }}</td>
                        <td>{{ $guest->user->email ?? 'N/A' }}</td>
                        <td>{{ $guest->phone_number ?? 'N/A' }}</td>
                        <td>{{ $guest->address ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ ($guest->user && $guest->user->status === 'active') ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($guest->user->status ?? 'unknown') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('guests.edit', $guest->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this guest?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No guests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection