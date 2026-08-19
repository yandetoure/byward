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
            'origin_street' => ['required', 'string', 'max:150'],
            'origin_city' => ['required', 'string', 'max:100'],
            'origin_province' => ['required', 'string', 'max:100'],
            'origin_postal_code' => ['required', 'string', 'max:20'],
            'destination_street' => ['required', 'string', 'max:150'],
            'destination_city' => ['required', 'string', 'max:100'],
            'destination_province' => ['required', 'string', 'max:100'],
            'destination_postal_code' => ['required', 'string', 'max:20'],
            'shipment_type' => ['required', 'string', 'in:'.implode(',', array_keys(config('byward.estimate.methods')))],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:200000'],
            'length' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'width' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'height' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'pickup_date' => ['nullable', 'date', 'after_or_equal:today'],
            'message' => ['nullable', 'string', 'max:4000'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['file', 'image', 'mimes:jpeg,png,webp,jpg', 'max:10240'],
        ]);

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $photoPaths[] = $photo->store('quotes');
                }
            }
        }

        $leadData = collect($data)->except(['photos'])->toArray();
        $leadData['origin'] = "{$data['origin_street']}, {$data['origin_city']}, {$data['origin_province']}, {$data['origin_postal_code']}";
        $leadData['destination'] = "{$data['destination_street']}, {$data['destination_city']}, {$data['destination_province']}, {$data['destination_postal_code']}";
        if (!empty($photoPaths)) {
            $leadData['photo_paths'] = $photoPaths;
        }

        $lead = Lead::create($leadData + ['type' => 'quote', 'locale' => App::getLocale()]);

        Log::info('New quote request received', ['id' => $lead->id, 'email' => $lead->email]);

        return redirect()
            ->route('quote')
            ->with('status', __('site.quote.success'))
            ->withFragment('form');
    }

    public function career(Request $request)
    {
        if (filled($request->input('website'))) {
            return back()->with('status', __('site.careers.success'));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'position' => ['required', 'string', 'max:150'],
            'message' => ['nullable', 'string', 'max:4000'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        // Handle file upload
        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes');
        }

        $leadData = collect($data)->except(['resume'])->toArray();
        $leadData['resume_path'] = $resumePath;

        $lead = Lead::create($leadData + ['type' => 'career', 'locale' => App::getLocale()]);

        Log::info('New career application received', ['id' => $lead->id, 'email' => $lead->email]);

        return redirect()
            ->route('careers')
            ->with('status', __('site.careers.success'))
            ->withFragment('form');
    }
}
