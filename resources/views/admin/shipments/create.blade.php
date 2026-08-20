@extends('admin.layout')

@section('title', 'Create Shipment')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.shipments.index') }}" class="btn btn-sm btn-outline-navy mb-3">
        ← Back to Shipments
    </a>
    <h1 class="h2 mb-0">Create Shipment</h1>
    <p class="text-muted">Register a new tracking shipment to the database.</p>
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

        <form action="{{ route('admin.shipments.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="tracking_number" class="form-label">Tracking Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tracking_number" name="tracking_number" value="{{ old('tracking_number', 'BW-' . rand(1000, 9999)) }}" required>
                    <div class="form-text">Unique identifier used by visitors to track their package.</div>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Pending" @selected(old('status') === 'Pending')>Pending</option>
                        <option value="In Transit" @selected(old('status') === 'In Transit')>In Transit</option>
                        <option value="Out for Delivery" @selected(old('status') === 'Out for Delivery')>Out for Delivery</option>
                        <option value="Delivered" @selected(old('status') === 'Delivered')>Delivered</option>
                        <option value="Exception" @selected(old('status') === 'Exception')>Exception</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="origin" class="form-label">Origin Location <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="origin" name="origin" value="{{ old('origin') }}" placeholder="e.g. Montreal, QC" required>
                </div>

                <div class="col-md-6">
                    <label for="destination" class="form-label">Destination Location <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="destination" name="destination" value="{{ old('destination') }}" placeholder="e.g. Toronto, ON" required>
                </div>

                <div class="col-md-6">
                    <label for="current_location" class="form-label">Current Location</label>
                    <input type="text" class="form-control" id="current_location" name="current_location" value="{{ old('current_location') }}" placeholder="e.g. Montreal, QC">
                </div>

                <div class="col-md-6">
                    <label for="expected_delivery_date" class="form-label">Expected Delivery Date</label>
                    <input type="date" class="form-control" id="expected_delivery_date" name="expected_delivery_date" value="{{ old('expected_delivery_date') }}">
                </div>

                <div class="col-12">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional shipping updates or package handling details...">{{ old('notes') }}</textarea>
                </div>

                <div class="col-12 mt-4 text-end">
                    <button type="submit" class="btn btn-brand btn-lg">
                        Create Shipment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
