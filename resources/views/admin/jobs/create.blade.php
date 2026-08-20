@extends('admin.layout')

@section('title', 'Add Job Opening')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-outline-navy mb-3">
        ← Back to Job Openings
    </a>
    <h1 class="h2 mb-0">Add Job Opening</h1>
    <p class="text-muted">Create a new job opening to display on the Careers page.</p>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title_en" class="form-label">Job Title (English) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title_en" name="title_en" value="{{ old('title_en') }}" placeholder="e.g. Logistics Dispatcher" required>
                </div>

                <div class="col-md-6">
                    <label for="title_fr" class="form-label">Job Title (French) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title_fr" name="title_fr" value="{{ old('title_fr') }}" placeholder="e.g. Répartiteur Logistique" required>
                </div>

                <div class="col-md-6">
                    <label for="description_en" class="form-label">Job Description (English)</label>
                    <textarea class="form-control" id="description_en" name="description_en" rows="5" placeholder="Responsibilities, qualifications, etc.">{{ old('description_en') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="description_fr" class="form-label">Job Description (French)</label>
                    <textarea class="form-control" id="description_fr" name="description_fr" rows="5" placeholder="Responsabilités, qualifications, etc.">{{ old('description_fr') }}</textarea>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">
                            Publish this job opening immediately (active status)
                        </label>
                    </div>
                </div>

                <div class="col-12 mt-4 text-end">
                    <button type="submit" class="btn btn-brand btn-lg">
                        Save Job Opening
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
