<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class AdminShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::latest()->paginate(15);
        return view('admin.shipments.index', compact('shipments'));
    }

    public function create()
    {
        return view('admin.shipments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tracking_number' => ['required', 'string', 'max:50', 'unique:shipments,tracking_number'],
            'status' => ['required', 'string', 'max:50'],
            'origin' => ['required', 'string', 'max:150'],
            'destination' => ['required', 'string', 'max:150'],
            'current_location' => ['nullable', 'string', 'max:150'],
            'expected_delivery_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Shipment::create($data);

        return redirect()->route('admin.shipments.index')->with('status', 'Shipment created successfully!');
    }

    public function edit($locale, Shipment $shipment)
    {
        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, $locale, Shipment $shipment)
    {
        $data = $request->validate([
            'tracking_number' => ['required', 'string', 'max:50', 'unique:shipments,tracking_number,' . $shipment->id],
            'status' => ['required', 'string', 'max:50'],
            'origin' => ['required', 'string', 'max:150'],
            'destination' => ['required', 'string', 'max:150'],
            'current_location' => ['nullable', 'string', 'max:150'],
            'expected_delivery_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $shipment->update($data);

        return redirect()->route('admin.shipments.index')->with('status', 'Shipment updated successfully!');
    }

    public function destroy($locale, Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('admin.shipments.index')->with('status', 'Shipment deleted successfully!');
    }
}
