@extends('admin.layout')

@section('title', 'Manage Leads & Requests')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="h2 mb-0">Leads & Requests</h1>
        <p class="text-muted mb-0">Manage customer inquiries, quote requests, and job applications.</p>
    </div>
    <form action="{{ route('admin.leads.index') }}" method="GET" class="d-flex gap-2 align-items-center" style="max-width: 380px; width: 100%;">
        @if($type)
            <input type="hidden" name="type" value="{{ $type }}">
        @endif
        <div class="input-group">
            <input type="text" name="search" class="form-control form-control-sm rounded-start-pill border-end-0 ps-3" placeholder="Search name, email, phone..." value="{{ $search ?? '' }}">
            <button class="btn btn-sm btn-outline-secondary rounded-end-pill px-3" type="submit">
                🔍
            </button>
        </div>
        @if(!empty($search))
            <a href="{{ route('admin.leads.index', array_filter(['type' => $type])) }}" class="btn btn-sm btn-light text-nowrap rounded-pill px-3 border" title="Clear Search">Reset</a>
        @endif
    </form>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4 px-4">
        <!-- Tabs -->
        <ul class="nav nav-tabs border-bottom">
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ is_null($type) ? 'active text-brand' : 'text-muted' }}" href="{{ route('admin.leads.index', array_filter(['search' => $search])) }}">
                    All Leads
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ $type === 'contact' ? 'active text-brand' : 'text-muted' }}" href="{{ route('admin.leads.index', array_filter(['type' => 'contact', 'search' => $search])) }}">
                    Contact Inquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ $type === 'quote' ? 'active text-brand' : 'text-muted' }}" href="{{ route('admin.leads.index', array_filter(['type' => 'quote', 'search' => $search])) }}">
                    Quote Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ $type === 'career' ? 'active text-brand' : 'text-muted' }}" href="{{ route('admin.leads.index', array_filter(['type' => 'career', 'search' => $search])) }}">
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
                                <td class="py-3">
                                    <div class="fw-semibold text-nowrap">{{ $lead->created_at->format('M d, Y') }}</div>
                                    <div class="small text-muted">{{ $lead->created_at->format('H:i') }}</div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold text-navy">{{ $lead->name }}</div>
                                    @if($lead->company)
                                        <div class="small text-muted">{{ $lead->company }}</div>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div><a href="mailto:{{ $lead->email }}" class="text-decoration-none fw-medium">{{ $lead->email }}</a></div>
                                    @if($lead->phone)
                                        <div class="small text-muted">{{ $lead->phone }}</div>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <span class="badge-type-{{ strtolower($lead->type) }}">
                                        {{ $lead->type }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if($lead->handled)
                                        <span class="badge-handled">Handled</span>
                                    @else
                                        <span class="badge-pending">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end py-3">
                                    <div class="d-inline-flex gap-1 justify-content-end align-items-center">
                                        <a href="{{ route('admin.leads.show', $lead) }}" class="btn-icon-action btn-icon-view" title="View Details">
                                            <x-icon name="eye" size="15" />
                                        </a>
                                        <a href="{{ route('admin.leads.edit', $lead) }}" class="btn-icon-action btn-icon-edit" title="Edit Lead">
                                            <x-icon name="edit" size="15" />
                                        </a>
                                        <form action="{{ route('admin.leads.toggle', $lead) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-icon-action btn-icon-toggle" title="{{ $lead->handled ? 'Mark as Pending' : 'Mark as Handled' }}">
                                                <x-icon name="check-circle" size="15" />
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lead?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon-action btn-icon-delete" title="Delete Lead">
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
                {{ $leads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
