<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class AdminLeadController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $search = trim((string) $request->query('search'));
        $query = Lead::latest();

        if ($type) {
            $query->where('type', $type);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('origin', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        $leads = $query->paginate(15)->withQueryString();

        return view('admin.leads.index', compact('leads', 'type', 'search'));
    }

    public function show($locale, Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function edit($locale, Lead $lead)
    {
        return view('admin.leads.edit', compact('lead'));
    }

    public function update(Request $request, $locale, Lead $lead)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:150'],
            'message' => ['nullable', 'string', 'max:4000'],
            'handled' => ['nullable', 'boolean'],
            'origin' => ['nullable', 'string', 'max:255'],
            'origin_street' => ['nullable', 'string', 'max:255'],
            'origin_province' => ['nullable', 'string', 'max:100'],
            'origin_postal_code' => ['nullable', 'string', 'max:30'],
            'destination' => ['nullable', 'string', 'max:255'],
            'destination_street' => ['nullable', 'string', 'max:255'],
            'destination_province' => ['nullable', 'string', 'max:100'],
            'destination_postal_code' => ['nullable', 'string', 'max:30'],
            'shipment_type' => ['nullable', 'string', 'max:50'],
            'weight' => ['nullable', 'numeric'],
            'length' => ['nullable', 'numeric'],
            'width' => ['nullable', 'numeric'],
            'height' => ['nullable', 'numeric'],
            'pickup_date' => ['nullable', 'date'],
            'position' => ['nullable', 'string', 'max:150'],
        ]);

        $data['handled'] = $request->has('handled');

        $lead->update($data);

        return redirect()->route('admin.leads.show', $lead)->with('status', 'Lead updated successfully!');
    }

    public function toggleHandled($locale, Lead $lead)
    {
        $lead->update([
            'handled' => !$lead->handled
        ]);

        return back()->with('status', 'Lead status updated successfully!');
    }

    public function destroy($locale, Lead $lead)
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('status', 'Lead deleted successfully!');
    }
}
