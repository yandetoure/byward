<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Shipment;
use App\Models\JobOffer;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'leads_total' => Lead::count(),
            'leads_pending' => Lead::where('handled', false)->count(),
            'leads_handled' => Lead::where('handled', true)->count(),
            'shipments_total' => Shipment::count(),
            'shipments_active' => Shipment::whereIn('status', ['In Transit', 'Out for Delivery', 'Pending'])->count(),
            'jobs_total' => JobOffer::count(),
            'jobs_active' => JobOffer::where('is_active', true)->count(),
        ];

        $recentLeads = Lead::latest()->take(5)->get();
        $recentShipments = Shipment::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentLeads', 'recentShipments'));
    }
}
