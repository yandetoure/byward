@extends('layouts.app')

@section('title', 'Track Shipment')
@section('description', 'Track your ByWard Logistics shipment in real time.')

@php
    $img = config('byward.images');
@endphp

@section('content')

<x-page-hero
    eyebrow="Logistics"
    title="Track Your Shipment"
    text="Enter your tracking number below to see the real-time status of your cargo."
    :image="$img['hero_services']"
    current="Tracking">
</x-page-hero>

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('tracking.show') }}" method="GET" class="d-flex flex-column flex-md-row gap-3 mb-5">
                            <input type="text" name="id" class="form-control form-control-lg bg-light" placeholder="Enter Tracking Number..." value="{{ request('id') }}" required>
                            <button type="submit" class="btn btn-brand btn-lg d-flex align-items-center gap-2">
                                <x-icon name="arrow-right" size="18" /> Track
                            </button>
                        </form>

                        @if(request()->has('id'))
                            @if($shipment)
                                <div class="tracking-result bg-light p-4 rounded-4">
                                    <h3 class="mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <span>Status: <span class="text-brand">{{ $shipment->status }}</span></span>
                                        <span class="badge bg-secondary fs-6">{{ $shipment->tracking_number }}</span>
                                    </h3>
                                    
                                    <div class="row g-4 mb-4">
                                        <div class="col-sm-6">
                                            <p class="text-muted mb-1 text-uppercase fs-7 fw-semibold">Origin</p>
                                            <p class="mb-0 fw-bold fs-5">{{ $shipment->origin ?: 'N/A' }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="text-muted mb-1 text-uppercase fs-7 fw-semibold">Destination</p>
                                            <p class="mb-0 fw-bold fs-5">{{ $shipment->destination ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-4">
                                    
                                    <div class="row g-4">
                                        <div class="col-sm-6">
                                            <p class="text-muted mb-1 text-uppercase fs-7 fw-semibold">Current Location</p>
                                            <p class="mb-0 fw-bold">{{ $shipment->current_location ?: 'N/A' }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="text-muted mb-1 text-uppercase fs-7 fw-semibold">Expected Delivery</p>
                                            <p class="mb-0 fw-bold">{{ $shipment->expected_delivery_date ? \Carbon\Carbon::parse($shipment->expected_delivery_date)->format('F j, Y') : 'TBD' }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($shipment->notes)
                                        <div class="mt-4 p-3 bg-white rounded border border-light-subtle">
                                            <p class="text-muted mb-1 text-uppercase fs-7 fw-semibold">Latest Update</p>
                                            <p class="mb-0">{{ $shipment->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-danger d-flex align-items-center gap-3 p-4 rounded-4" role="alert">
                                    <x-icon name="alert" size="24" />
                                    <div>
                                        <h5 class="mb-1">Shipment Not Found</h5>
                                        <p class="mb-0">We couldn't find a shipment with tracking number <strong>{{ request('id') }}</strong>. Please check the number and try again.</p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
