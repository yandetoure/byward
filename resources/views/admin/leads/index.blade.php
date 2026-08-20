@extends('admin.layout')

@section('title', 'Manage Leads & Requests')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0">Leads & Requests</h1>
        <p class="text-muted mb-0">Manage customer inquiries, quote requests, and job applications.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4 px-4">
        <!-- Tabs -->
        <ul class="nav nav-tabs border-bottom">
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ is_null($type) ? 'active text-brand' : 'text-muted' }}" href="{{ route('admin.leads.index') }}">
                    All Leads
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ $type === 'contact' ? 'active text-brand' : 'text-muted' }}" href="{{ route('admin.leads.index', ['type' => 'contact']) }}">
                    Contact Inquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ $type === 'quote' ? 'active text-brand' : 'text-muted' }}" href="{{ route('admin.leads.index', ['type' => 'quote']) }}">
                    Quote Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ $type === 'career' ? 'active text-brand' : 'text-muted' }}" href="{{ route('admin.leads.index', ['type' => 'career']) }}">
                    Job Applications
                </a>
            </li>
        </ul>
    </div>
    
    <div class="card-body px-4 pb-4">
        @if($leads->isEmpty())
            <div class="text-center py-5 text-muted">No submissions found matching this category.</div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email & Phone</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $lead)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $lead->created_at->format('M d, Y') }}</div>
                                    <div class="small text-muted">{{ $lead->created_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-navy">{{ $lead->name }}</div>
                                    @if($lead->company)
                                        <div class="small text-muted">{{ $lead->company }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div><a href="mailto:{{ $lead->email }}" class="text-decoration-none">{{ $lead->email }}</a></div>
                                    @if($lead->phone)
                                        <div class="small text-muted">{{ $lead->phone }}</div>
                                    @endif
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
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-outline-navy py-1 px-2">
                                            View
                                        </a>
                                        <form action="{{ route('admin.leads.toggle', $lead) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary py-1 px-2">
                                                {{ $lead->handled ? 'Mark Pending' : 'Mark Handled' }}
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
                {{ $leads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
