@extends('admin.layout')

@section('title', 'Manage Shipments')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="h2 mb-0">Track Shipments</h1>
        <p class="text-muted mb-0">Create, edit, and monitor shipment tracking information.</p>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form action="{{ route('admin.shipments.index') }}" method="GET" class="d-flex gap-2 align-items-center" style="max-width: 320px; width: 100%;">
            <div class="input-group">
                <input type="text" name="search" class="form-control form-control-sm rounded-start-pill border-end-0 ps-3" placeholder="Search tracking #, route, status..." value="{{ $search ?? '' }}">
                <button class="btn btn-sm btn-outline-secondary rounded-end-pill px-3" type="submit">
                    🔍
                </button>
            </div>
            @if(!empty($search))
                <a href="{{ route('admin.shipments.index') }}" class="btn btn-sm btn-light text-nowrap rounded-pill px-3 border" title="Clear Search">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.shipments.create') }}" class="btn btn-brand btn-sm text-nowrap">
            + Create Shipment
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        @if($shipments->isEmpty())
            <div class="text-center py-5 text-muted">
                No shipments found. Click the button above to create one.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Tracking Number</th>
                            <th>Status</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Current Location</th>
                            <th>Expected Delivery</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shipments as $shipment)
                            <tr>
                                <td class="py-3">
                                    <span class="fw-bold text-navy text-nowrap">{{ $shipment->tracking_number }}</span>
                                </td>
                                <td class="py-3">
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
                                </td>
                                <td class="py-3">{{ $shipment->origin }}</td>
                                <td class="py-3">{{ $shipment->destination }}</td>
                                <td class="py-3">{{ $shipment->current_location ?? '-' }}</td>
                                <td class="py-3 text-nowrap">
                                    {{ $shipment->expected_delivery_date ? \Carbon\Carbon::parse($shipment->expected_delivery_date)->format('M d, Y') : '-' }}
                                </td>
                                <td class="text-end py-3">
                                    <div class="d-inline-flex gap-1 justify-content-end align-items-center">
                                        <a href="{{ route('admin.shipments.show', $shipment) }}" class="btn-icon-action btn-icon-view" title="View Shipment Details">
                                            <x-icon name="eye" size="15" />
                                        </a>
                                        <a href="{{ route('admin.shipments.edit', $shipment) }}" class="btn-icon-action btn-icon-edit" title="Edit Shipment">
                                            <x-icon name="edit" size="15" />
                                        </a>
                                        <form action="{{ route('admin.shipments.destroy', $shipment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipment?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon-action btn-icon-delete" title="Delete Shipment">
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
                {{ $shipments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
