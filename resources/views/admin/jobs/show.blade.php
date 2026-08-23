@extends('admin.layout')

@section('title', 'Job Offer Details: ' . $job->title_en)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-outline-navy rounded-pill px-3 mb-3">
        ← Back to Job Openings
    </a>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h1 class="h2 mb-0 fw-bold text-navy">{{ $job->title_fr }} / {{ $job->title_en }}</h1>
                @if($job->is_active)
                    <span class="badge-status-delivered">Active</span>
                @else
                    <span class="badge-status-pending">Inactive</span>
                @endif
            </div>
            <p class="text-muted mb-0 mt-1">Created on {{ $job->created_at->format('F d, Y \a\t H:i') }}</p>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-outline-navy btn-admin-action px-3">
                ✏️ Edit Job
            </a>
            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job opening?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-admin-action px-3">
                    🗑️ Delete
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- French Content -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <h4 class="h5 mb-0 text-navy fw-bold">🇫🇷 French Content (Français)</h4>
                <span class="badge bg-light text-muted border">FR</span>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="mb-3">
                    <strong class="text-muted small d-block mb-1">Titre de l'offre (FR)</strong>
                    <div class="fs-5 fw-bold text-navy">{{ $job->title_fr }}</div>
                </div>
                <div>
                    <strong class="text-muted small d-block mb-1">Description (FR)</strong>
                    <div class="p-3 bg-light rounded-3 border text-dark" style="white-space: pre-wrap; font-size: 0.95rem;">{{ $job->description_fr ?: 'Aucune description en français.' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- English Content -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <h4 class="h5 mb-0 text-navy fw-bold">🇬🇧 English Content</h4>
                <span class="badge bg-light text-muted border">EN</span>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="mb-3">
                    <strong class="text-muted small d-block mb-1">Job Title (EN)</strong>
                    <div class="fs-5 fw-bold text-navy">{{ $job->title_en }}</div>
                </div>
                <div>
                    <strong class="text-muted small d-block mb-1">Description (EN)</strong>
                    <div class="p-3 bg-light rounded-3 border text-dark" style="white-space: pre-wrap; font-size: 0.95rem;">{{ $job->description_en ?: 'No English description provided.' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
