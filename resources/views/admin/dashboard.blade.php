@extends('admin.layout')

@section('title', 'Dashboard Overview')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0">Dashboard</h1>
        <p class="text-muted mb-0">Overview of Byward Logistics operational data.</p>
    </div>
</div>

<!-- Stats row -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold uppercase tracking-wider">Leads & Requests</span>
                    <h3 class="display-6 fw-bold mt-1 mb-0">{{ $stats['leads_total'] }}</h3>
                    <span class="small text-danger fw-semibold">
                        {{ $stats['leads_pending'] }} pending
                    </span>
                </div>
                <div class="stat-icon bg-navy-light">
                    <x-icon name="mail" size="24" />
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold uppercase tracking-wider">Active Shipments</span>
                    <h3 class="display-6 fw-bold mt-1 mb-0">{{ $stats['shipments_active'] }}</h3>
                    <span class="small text-muted">
                        Out of {{ $stats['shipments_total'] }} total
                    </span>
                </div>
                <div class="stat-icon bg-red-light">
                    <x-icon name="truck" size="24" />
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold uppercase tracking-wider">Active Job Offers</span>
                    <h3 class="display-6 fw-bold mt-1 mb-0">{{ $stats['jobs_active'] }}</h3>
                    <span class="small text-muted">
                        Out of {{ $stats['jobs_total'] }} total
                    </span>
                </div>
                <div class="stat-icon bg-green-light">
                    <x-icon name="users" size="24" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Leads -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h4 class="h5 mb-0">Recent Leads & Requests</h4>
                <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-outline-navy">View All</a>
            </div>
            <div class="card-body px-4 pb-4">
                @if($recentLeads->isEmpty())
                    <div class="text-center py-4 text-muted">No leads found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentLeads as $lead)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-navy">{{ $lead->name }}</div>
                                            <div class="small text-muted">{{ $lead->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-navy text-uppercase px-2 py-1" style="font-size: 0.7rem;">
                                                {{ $lead->type }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($lead->handled)
                                                <span class="badge-handled">Handled</span>
                                            @else
                                                <span class="badge-pending">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-link text-brand p-0">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Shipments -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h4 class="h5 mb-0">Recent Shipments</h4>
                <a href="{{ route('admin.shipments.index') }}" class="btn btn-sm btn-outline-navy">View All</a>
            </div>
            <div class="card-body px-4 pb-4">
                @if($recentShipments->isEmpty())
                    <div class="text-center py-4 text-muted">No shipments found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Tracking Number</th>
                                    <th>Route</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentShipments as $shipment)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-navy">{{ $shipment->tracking_number }}</div>
                                            <div class="small text-muted">{{ $shipment->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td>
                                            <div class="small fw-medium">{{ $shipment->origin }} → {{ $shipment->destination }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-navy text-white px-2 py-1" style="font-size: 0.75rem;">
                                                {{ $shipment->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.shipments.edit', $shipment) }}" class="btn btn-sm btn-link text-brand p-0">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
