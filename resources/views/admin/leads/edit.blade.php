@extends('admin.layout')

@section('title', 'Edit Lead #' . $lead->id)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-outline-navy mb-3">
        ← Back to Lead Details
    </a>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h2 mb-0">Edit Submission #{{ $lead->id }}</h1>
            <p class="text-muted mb-0">Type: <span class="badge-type-{{ strtolower($lead->type) }}">{{ $lead->type }}</span> — Created on {{ $lead->created_at->format('M d, Y \a\t H:i') }}</p>
        </div>
    </div>
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

        <form action="{{ route('admin.leads.update', $lead) }}" method="POST">
            @csrf
            @method('PUT')

            <h3 class="h5 border-bottom pb-2 mb-3">Submitter Information</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $lead->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $lead->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $lead->phone) }}">
                </div>

                <div class="col-md-6">
                    <label for="company" class="form-label fw-semibold">Company</label>
                    <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $lead->company) }}">
                </div>

                <div class="col-md-12">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="handled" name="handled" value="1" @checked(old('handled', $lead->handled))>
                        <label class="form-check-input-label fw-semibold text-navy ms-2" for="handled">
                            Mark as Handled / Processed
                        </label>
                    </div>
                </div>
            </div>

            @if($lead->type === 'quote')
                <h3 class="h5 border-bottom pb-2 mb-3">Quote / Shipment Details</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="origin" class="form-label fw-semibold">Origin Location</label>
                        <input type="text" class="form-control" id="origin" name="origin" value="{{ old('origin', $lead->origin) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="destination" class="form-label fw-semibold">Destination Location</label>
                        <input type="text" class="form-control" id="destination" name="destination" value="{{ old('destination', $lead->destination) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="shipment_type" class="form-label fw-semibold">Shipment Type</label>
                        <select class="form-select text-uppercase" id="shipment_type" name="shipment_type">
                            <option value="">-- Select --</option>
                            @foreach(array_keys(config('byward.estimate.methods')) as $method)
                                <option value="{{ $method }}" @selected(old('shipment_type', $lead->shipment_type) === $method)>{{ strtoupper($method) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="weight" class="form-label fw-semibold">Weight (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ old('weight', $lead->weight) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="pickup_date" class="form-label fw-semibold">Pickup Date</label>
                        <input type="date" class="form-control" id="pickup_date" name="pickup_date" value="{{ old('pickup_date', $lead->pickup_date ? $lead->pickup_date->format('Y-m-d') : '') }}">
                    </div>
                </div>
            @endif

            @if($lead->type === 'career')
                <h3 class="h5 border-bottom pb-2 mb-3">Employment Details</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="position" class="form-label fw-semibold">Position Applied For</label>
                        <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $lead->position) }}">
                    </div>
                </div>
            @endif

            <h3 class="h5 border-bottom pb-2 mb-3">Message / Notes</h3>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label for="message" class="form-label fw-semibold">Message Content</label>
                    <textarea class="form-control" id="message" name="message" rows="4">{{ old('message', $lead->message) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-outline-secondary btn-admin-action">
                    Cancel
                </a>
                <button type="submit" class="btn btn-brand btn-admin-action px-4">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
