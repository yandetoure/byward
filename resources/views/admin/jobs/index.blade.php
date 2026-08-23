@extends('admin.layout')

@section('title', 'Manage Job Offers')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="h2 mb-0">Job Openings</h1>
        <p class="text-muted mb-0">Manage dynamic job offers displayed on the Careers page.</p>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form action="{{ route('admin.jobs.index') }}" method="GET" class="d-flex gap-2 align-items-center" style="max-width: 320px; width: 100%;">
            <input type="text" name="search" class="form-control form-control-sm rounded-pill px-3" placeholder="Search job title or description..." value="{{ $search ?? '' }}">
            @if(!empty($search))
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-light text-nowrap rounded-pill px-3 border" title="Clear Search">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-brand btn-sm text-nowrap">
            + Add Job Opening
        </a>
    </div>
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
                                <td class="py-3 text-nowrap">
                                    <span>{{ $job->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="fw-bold text-navy">{{ $job->title_en }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="fw-bold text-navy">{{ $job->title_fr }}</span>
                                </td>
                                <td class="py-3">
                                    @if($job->is_active)
                                        <span class="badge-status-delivered">Active</span>
                                    @else
                                        <span class="badge-status-pending">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end py-3">
                                    <div class="d-inline-flex gap-1 justify-content-end align-items-center">
                                        <a href="{{ route('admin.jobs.show', $job) }}" class="btn-icon-action btn-icon-view" title="View Job Details">
                                            <x-icon name="eye" size="15" />
                                        </a>
                                        <a href="{{ route('admin.jobs.edit', $job) }}" class="btn-icon-action btn-icon-edit" title="Edit Job Opening">
                                            <x-icon name="edit" size="15" />
                                        </a>
                                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job opening?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon-action btn-icon-delete" title="Delete Job Opening">
                                                <x-icon name="trash" size="15" />
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
