@extends('admin.layout')

@section('title', 'Manage Job Offers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0">Job Openings</h1>
        <p class="text-muted mb-0">Manage dynamic job offers displayed on the Careers page.</p>
    </div>
    <a href="{{ route('admin.jobs.create') }}" class="btn btn-brand">
        + Add Job Opening
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        @if($jobs->isEmpty())
            <div class="text-center py-5 text-muted">
                No job openings found. Click the button above to add one.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Date Created</th>
                            <th>Title (EN)</th>
                            <th>Title (FR)</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <td>
                                    <span>{{ $job->created_at->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-navy">{{ $job->title_en }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-navy">{{ $job->title_fr }}</span>
                                </td>
                                <td>
                                    @if($job->is_active)
                                        <span class="badge bg-success text-white px-2 py-1" style="font-size: 0.75rem;">Active</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-2 py-1" style="font-size: 0.75rem;">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-sm btn-outline-navy py-1 px-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job opening?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
