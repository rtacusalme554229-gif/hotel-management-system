@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Activity Logs</h2>
    <p class="text-muted mb-0">Track approvals, declines, and payment activity.</p>
</div>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-4">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="text-center">{{ $log->id }}</td>
                        <td>{{ $log->user->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-dark">{{ $log->action }}</span>
                        </td>
                        <td>{{ $log->description }}</td>
                        <td class="text-center">{{ $log->created_at->format('Y-m-d h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No activity logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection