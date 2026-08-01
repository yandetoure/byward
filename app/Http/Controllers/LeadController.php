<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function contact(Request $request)
    {
        // Honeypot: bots fill every field, humans never see this one.
        if (filled($request->input('website'))) {
            return back()->with('status', __('site.contact.success'));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:4000'],
        ]);

        $lead = Lead::create($data + ['type' => 'contact', 'locale' => App::getLocale()]);

        Log::info('New contact lead received', ['id' => $lead->id, 'email' => $lead->email]);

        return redirect()
            ->route('contact')
            ->with('status', __('site.contact.success'))
            ->withFragment('form');
    }

    public function quote(Request $request)
    {
        if (filled($request->input('website'))) {
            return back()->with('status', __('site.quote.success'));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['required', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:150'],
            'origin' => ['required', 'string', 'max:180'],
            'destination' => ['required', 'string', 'max:180'],
            'shipment_type' => ['required', 'string', 'in:'.implode(',', array_keys(config('byward.estimate.methods')))],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:200000'],
            'length' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'width' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'height' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'pickup_date' => ['nullable', 'date', 'after_or_equal:today'],
            'message' => ['nullable', 'string', 'max:4000'],
        ]);

        $lead = Lead::create($data + ['type' => 'quote', 'locale' => App::getLocale()]);

        Log::info('New quote request received', ['id' => $lead->id, 'email' => $lead->email]);

        return redirect()
            ->route('quote')
            ->with('status', __('site.quote.success'))
            ->withFragment('form');
    }
}
