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
        $query = Lead::latest();

        if ($type) {
            $query->where('type', $type);
        }

        $leads = $query->paginate(15)->withQueryString();

        return view('admin.leads.index', compact('leads', 'type'));
    }

    public function show($locale, Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
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
