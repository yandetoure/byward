@extends('admin.layout')

@section('title', 'Manage Shipments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0">Track Shipments</h1>
        <p class="text-muted mb-0">Create, edit, and monitor shipment tracking information.</p>
    </div>
    <a href="{{ route('admin.shipments.create') }}" class="btn btn-brand">
        + Create Shipment
    </a>
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
                                <td>
                                    <span class="fw-bold text-navy">{{ $shipment->tracking_number }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-navy text-white px-2 py-1" style="font-size: 0.75rem;">
                                        {{ $shipment->status }}
                                    </span>
                                </td>
                                <td>{{ $shipment->origin }}</td>
                                <td>{{ $shipment->destination }}</td>
                                <td>{{ $shipment->current_location ?? '-' }}</td>
                                <td>
                                    {{ $shipment->expected_delivery_date ? \Carbon\Carbon::parse($shipment->expected_delivery_date)->format('M d, Y') : '-' }}
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.shipments.edit', $shipment) }}" class="btn btn-sm btn-outline-navy py-1 px-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.shipments.destroy', $shipment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipment?');">
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
                {{ $shipments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
