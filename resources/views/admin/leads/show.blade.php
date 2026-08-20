@extends('admin.layout')

@section('title', 'Lead Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-outline-navy mb-3">
        ← Back to Leads
    </a>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h1 class="h2 mb-0">Submission Details</h1>
            <p class="text-muted">Submitted on {{ $lead->created_at->format('M d, Y \a\t H:i') }} (locale: {{ strtoupper($lead->locale) }})</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.leads.toggle', $lead) }}" method="POST">
                @csrf
                <button type="submit" class="btn {{ $lead->handled ? 'btn-outline-warning' : 'btn-success' }}">
                    {{ $lead->handled ? 'Mark Pending' : 'Mark Handled' }}
                </button>
            </form>
            <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lead?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Main details -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h3 class="h5 border-bottom pb-2 mb-3">Inquiry Content</h3>
                
                @if($lead->message)
                    <div class="p-3 bg-light rounded-3 mb-4" style="white-space: pre-wrap;">{{ $lead->message }}</div>
                @else
                    <p class="text-muted italic">No message provided.</p>
                @endif
                
                @if($lead->type === 'quote')
                    <h3 class="h5 border-bottom pb-2 mb-3 mt-4">Shipment Details</h3>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <strong class="d-block small text-muted">Origin</strong>
                            <span>{{ $lead->origin }}</span>
                        </div>
                        <div class="col-sm-6">
                            <strong class="d-block small text-muted">Destination</strong>
                            <span>{{ $lead->destination }}</span>
                        </div>
                        <div class="col-sm-4">
                            <strong class="d-block small text-muted">Shipment Type</strong>
                            <span class="text-uppercase">{{ $lead->shipment_type }}</span>
                        </div>
                        <div class="col-sm-4">
                            <strong class="d-block small text-muted">Weight</strong>
                            <span>{{ $lead->weight }} kg</span>
                        </div>
                        <div class="col-sm-4">
                            <strong class="d-block small text-muted">Pickup Date</strong>
                            <span>{{ $lead->pickup_date ? $lead->pickup_date->format('M d, Y') : 'Not specified' }}</span>
                        </div>
                        @if($lead->length || $lead->width || $lead->height)
                            <div class="col-12">
                                <strong class="d-block small text-muted">Dimensions (L × W × H)</strong>
                                <span>{{ $lead->length ?? '-' }} × {{ $lead->width ?? '-' }} × {{ $lead->height ?? '-' }} cm</span>
                            </div>
                        @endif
                    </div>
                    
                    @if($lead->photo_paths && is_array($lead->photo_paths))
                        <h3 class="h5 border-bottom pb-2 mb-3 mt-4">Cargo Photos</h3>
                        <div class="row g-2">
                            @foreach($lead->photo_paths as $path)
                                <div class="col-sm-4 col-md-3">
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $path) }}" class="img-fluid rounded-3 border" style="height: 120px; width: 100%; object-fit: cover;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                
                @if($lead->type === 'career')
                    <h3 class="h5 border-bottom pb-2 mb-3 mt-4">Employment Details</h3>
                    <div class="mb-3">
                        <strong class="d-block small text-muted">Position Applied For</strong>
                        <span>{{ ucfirst($lead->position) }}</span>
                    </div>
                    @if($lead->resume_path)
                        <div class="mb-3">
                            <strong class="d-block small text-muted">Resume</strong>
                            <a href="{{ asset('storage/' . $lead->resume_path) }}" class="btn btn-outline-navy mt-2 btn-sm" target="_blank">
                                <x-icon name="file-text" size="14" class="me-1" /> View/Download Resume
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Submitter contact info -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h3 class="h5 border-bottom pb-2 mb-3">Submitter Information</h3>
                
                <div class="mb-3">
                    <strong class="d-block small text-muted">Name</strong>
                    <span class="fw-semibold text-navy">{{ $lead->name }}</span>
                </div>
                
                @if($lead->company)
                    <div class="mb-3">
                        <strong class="d-block small text-muted">Company</strong>
                        <span>{{ $lead->company }}</span>
                    </div>
                @endif
                
                <div class="mb-3">
                    <strong class="d-block small text-muted">Email</strong>
                    <a href="mailto:{{ $lead->email }}" class="text-decoration-none">{{ $lead->email }}</a>
                </div>
                
                @if($lead->phone)
                    <div class="mb-3">
                        <strong class="d-block small text-muted">Phone</strong>
                        <a href="tel:{{ $lead->phone }}" class="text-decoration-none">{{ $lead->phone }}</a>
                    </div>
                @endif
                
                <div class="mb-3 border-top pt-3">
                    <strong class="d-block small text-muted">Lead Category</strong>
                    <span class="badge bg-light text-navy text-uppercase px-2 py-1 mt-1" style="font-size: 0.75rem;">
                        {{ $lead->type }}
                    </span>
                </div>
                
                <div class="mb-0">
                    <strong class="d-block small text-muted">Handling Status</strong>
                    <div class="mt-1">
                        @if($lead->handled)
                            <span class="badge-handled">Handled</span>
                        @else
                            <span class="badge-pending">Pending Attention</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
