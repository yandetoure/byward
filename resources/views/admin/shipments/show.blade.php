@extends('admin.layout')

@section('title', 'Shipment Details: ' . $shipment->tracking_number)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.shipments.index') }}" class="btn btn-sm btn-outline-navy rounded-pill px-3 mb-3">
        ← Back to Shipments
    </a>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h1 class="h3 mb-0 fw-bold text-navy font-monospace">{{ $shipment->tracking_number }}</h1>
                @php
                    $statusClass = match(strtolower($shipment->status)) {
                        'delivered' => 'badge-status-delivered',
                        'in transit' => 'badge-status-transit',
                        default => 'badge-status-pending',
                    };
                @endphp
                <span class="{{ $statusClass }}">
                    {{ $shipment->status }}
                </span>
            </div>
            <p class="text-muted small mb-0 mt-1">Created on {{ $shipment->created_at->format('F d, Y \a\t H:i') }}</p>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('admin.shipments.edit', $shipment) }}" class="btn btn-sm btn-outline-navy rounded-pill px-3">
                <x-icon name="edit" size="14" class="me-1" /> Edit Shipment
            </a>
            <form action="{{ route('admin.shipments.destroy', $shipment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipment?');" class="d-inline">
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
    <!-- Shipment Banner & Metrics -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-navy text-white p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-white-50 small fw-semibold uppercase tracking-wider">Live Route Status</span>
                    <span class="badge bg-white-10 text-white px-3 py-1 rounded-pill small">Byward Logistics Express</span>
                </div>
                <div class="row align-items-center g-3 text-center text-md-start">
                    <div class="col-md-5">
                        <span class="text-white-50 small d-block">Origin</span>
                        <strong class="fs-5 text-white">{{ $shipment->origin }}</strong>
                    </div>
                    <div class="col-md-2 text-center my-2 my-md-0">
                        <div class="bg-white-10 rounded-circle p-2 d-inline-flex text-white">
                            <x-icon name="truck" size="22" />
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <span class="text-white-50 small d-block">Destination</span>
                        <strong class="fs-5 text-white">{{ $shipment->destination }}</strong>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted small fw-semibold uppercase tracking-wider d-block mb-1">Current Location</span>
                            <span class="fs-6 fw-bold text-navy">{{ $shipment->current_location ?: 'Location updating...' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted small fw-semibold uppercase tracking-wider d-block mb-1">Expected Delivery Date</span>
                            <span class="fs-6 fw-bold text-navy">
                                {{ $shipment->expected_delivery_date ? \Carbon\Carbon::parse($shipment->expected_delivery_date)->format('F d, Y') : 'Schedule pending' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h4 class="h5 mb-0 text-navy fw-bold">Internal Notes & Package Instructions</h4>
            </div>
            <div class="card-body p-4">
                @if($shipment->notes)
                    <div class="p-3 bg-light rounded-3 border text-dark" style="white-space: pre-wrap; font-size: 0.9rem;">{{ $shipment->notes }}</div>
                @else
                    <p class="text-muted italic mb-0">No internal notes recorded for this shipment.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar / System Info Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h4 class="h5 mb-0 text-navy fw-bold">Shipment Info</h4>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <span class="text-muted small d-block">Database Record ID</span>
                    <strong class="text-dark">#{{ $shipment->id }}</strong>
                </div>
                <div class="mb-3">
                    <span class="text-muted small d-block">Tracking Reference</span>
                    <strong class="text-brand font-monospace fs-6">{{ $shipment->tracking_number }}</strong>
                </div>
                <div class="mb-3">
                    <span class="text-muted small d-block">Created Date</span>
                    <span class="text-dark">{{ $shipment->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
                <div class="mb-3">
                    <span class="text-muted small d-block">Last Updated</span>
                    <span class="text-dark">{{ $shipment->updated_at->format('Y-m-d H:i:s') }}</span>
                </div>

                <hr class="my-3">

                <a href="{{ route('tracking.show', ['tracking_number' => $shipment->tracking_number]) }}" target="_blank" class="btn btn-outline-brand w-100 btn-sm rounded-pill">
                    🔗 View Public Tracking Page
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
