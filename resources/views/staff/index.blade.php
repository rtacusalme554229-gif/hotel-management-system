@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Staff</h2>
    <a href="{{ route('staff.create') }}" class="btn btn-primary">Add Staff</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ ucfirst($member->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $member->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('staff.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('staff.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this staff account?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No staff accounts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection