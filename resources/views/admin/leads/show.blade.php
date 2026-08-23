@extends('admin.layout')

@section('title', 'Lead Details #' . $lead->id)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-outline-navy rounded-pill px-3 mb-3">
        ← Back to Leads
    </a>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <h1 class="h3 mb-0 fw-bold text-navy">Lead #{{ $lead->id }}</h1>
                <span class="badge-type-{{ strtolower($lead->type) }}">{{ $lead->type }}</span>
                @if($lead->handled)
                    <span class="badge-handled">✓ Handled</span>
                @else
                    <span class="badge-pending">● Pending</span>
                @endif
                <span class="badge bg-light text-muted border">Locale: {{ strtoupper($lead->locale) }}</span>
            </div>
            <p class="text-muted small mb-0 mt-1">Submitted on {{ $lead->created_at->format('F d, Y \a\t H:i') }}</p>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('admin.leads.edit', $lead) }}" class="btn btn-sm btn-outline-navy rounded-pill px-3">
                <x-icon name="edit" size="14" class="me-1" /> Edit
            </a>
            <form action="{{ route('admin.leads.toggle', $lead) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm {{ $lead->handled ? 'btn-outline-warning' : 'btn-success' }} rounded-pill px-3">
                    <x-icon name="check-circle" size="14" class="me-1" /> {{ $lead->handled ? 'Mark Pending' : 'Mark Handled' }}
                </button>
            </form>
            <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lead?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <x-icon name="trash" size="14" class="me-1" /> Delete
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        @if($lead->type === 'quote')
            <!-- Shipment Route & Specs -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-navy text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-white-50 small fw-semibold uppercase tracking-wider">Quote Request Specs</span>
                        <span class="badge bg-red-light text-white border border-danger px-3 py-1 rounded-pill uppercase">
                            {{ $lead->shipment_type ?: 'Standard Shipment' }}
                        </span>
                    </div>
                    <div class="row align-items-center mt-3 g-3">
                        <div class="col-md-5">
                            <span class="text-white-50 small d-block">Origin</span>
                            <strong class="fs-5 text-white">{{ $lead->origin ?: 'Not specified' }}</strong>
                            @if($lead->origin_street || $lead->origin_province || $lead->origin_postal_code)
                                <div class="small text-white-50 mt-1">
                                    {{ implode(', ', array_filter([$lead->origin_street, $lead->origin_province, $lead->origin_postal_code])) }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="bg-white-10 rounded-circle p-2 d-inline-flex text-white">
                                <x-icon name="truck" size="22" />
                            </div>
                        </div>
                        <div class="col-md-5 text-md-end">
                            <span class="text-white-50 small d-block">Destination</span>
                            <strong class="fs-5 text-white">{{ $lead->destination ?: 'Not specified' }}</strong>
                            @if($lead->destination_street || $lead->destination_province || $lead->destination_postal_code)
                                <div class="small text-white-50 mt-1">
                                    {{ implode(', ', array_filter([$lead->destination_street, $lead->destination_province, $lead->destination_postal_code])) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 text-center border">
                                <span class="text-muted small d-block">Weight</span>
                                <strong class="fs-6 text-navy">{{ $lead->weight ? number_format($lead->weight, 2) . ' kg' : '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 text-center border">
                                <span class="text-muted small d-block">Pickup Date</span>
                                <strong class="fs-6 text-navy">{{ $lead->pickup_date ? $lead->pickup_date->format('M d, Y') : '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3 text-center border">
                                <span class="text-muted small d-block">Dimensions (L × W × H)</span>
                                <strong class="fs-6 text-navy">
                                    {{ $lead->length || $lead->width || $lead->height ? ($lead->length ?? '-') . ' × ' . ($lead->width ?? '-') . ' × ' . ($lead->height ?? '-') . ' cm' : 'Standard Parcel' }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    @if($lead->photo_paths && is_array($lead->photo_paths) && count($lead->photo_paths) > 0)
                        <h4 class="h6 text-navy fw-bold mt-4 mb-3 border-bottom pb-2">Cargo Photos</h4>
                        <div class="row g-2">
                            @foreach($lead->photo_paths as $path)
                                <div class="col-6 col-sm-4 col-md-3">
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank" class="d-block text-decoration-none">
                                        <img src="{{ asset('storage/' . $path) }}" class="img-fluid rounded-3 border hover-lift" style="height: 120px; width: 100%; object-fit: cover;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($lead->type === 'career')
            <!-- Employment Details -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h4 class="h5 mb-0 text-navy fw-bold">Employment Application</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <span class="text-muted small d-block mb-1">Position Applied For</span>
                        <span class="fs-5 fw-bold text-navy">{{ ucfirst($lead->position ?: 'General Application') }}</span>
                    </div>

                    @if($lead->resume_path)
                        <div>
                            <span class="text-muted small d-block mb-2">Attached Resume Document</span>
                            <a href="{{ asset('storage/' . $lead->resume_path) }}" class="btn btn-outline-navy rounded-pill btn-sm px-4" target="_blank">
                                <x-icon name="file-text" size="15" class="me-1" /> View / Download Candidate Resume
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Message Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h4 class="h5 mb-0 text-navy fw-bold">Inquiry Message / Notes</h4>
            </div>
            <div class="card-body p-4">
                @if($lead->message)
                    <div class="p-3 bg-light rounded-3 border text-dark" style="white-space: pre-wrap; font-size: 0.9rem;">{{ $lead->message }}</div>
                @else
                    <p class="text-muted italic mb-0">No message provided by submitter.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Submitter Info Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h4 class="h5 mb-0 text-navy fw-bold">Contact Details</h4>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-navy-light text-navy rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <x-icon name="users" size="24" />
                    </div>
                    <div>
                        <div class="fw-bold fs-6 text-navy">{{ $lead->name }}</div>
                        @if($lead->company)
                            <div class="small text-muted">{{ $lead->company }}</div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <span class="text-muted small d-block">Email Address</span>
                    <a href="mailto:{{ $lead->email }}" class="fw-semibold text-brand text-decoration-none">{{ $lead->email }}</a>
                </div>

                @if($lead->phone)
                    <div class="mb-3">
                        <span class="text-muted small d-block">Phone Number</span>
                        <a href="tel:{{ $lead->phone }}" class="fw-semibold text-navy text-decoration-none">{{ $lead->phone }}</a>
                    </div>
                @endif

                <hr class="my-3">

                <div class="d-grid gap-2">
                    <a href="mailto:{{ $lead->email }}" class="btn btn-outline-brand btn-sm rounded-pill">
                        ✉️ Reply via Email
                    </a>
                    @if($lead->phone)
                        <a href="tel:{{ $lead->phone }}" class="btn btn-outline-navy btn-sm rounded-pill">
                            📞 Call Submitter
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
