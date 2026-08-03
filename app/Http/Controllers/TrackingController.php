<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;

class TrackingController extends Controller
{
    public function show(Request $request)
    {
        $trackingNumber = $request->query('id') ?? $request->query('tracking_number');
        $shipment = null;

        if ($trackingNumber) {
            $shipment = Shipment::where('tracking_number', $trackingNumber)->first();
        }

        return view('pages.tracking', compact('trackingNumber', 'shipment'));
    }
}
