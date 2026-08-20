<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class AdminJobController extends Controller
{
    public function index()
    {
        $jobs = JobOffer::latest()->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => ['required', 'string', 'max:150'],
            'title_fr' => ['required', 'string', 'max:150'],
            'description_en' => ['nullable', 'string'],
            'description_fr' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->has('is_active');

        JobOffer::create($data);

        return redirect()->route('admin.jobs.index')->with('status', 'Job opening created successfully!');
    }

    public function edit($locale, JobOffer $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, $locale, JobOffer $job)
    {
        $data = $request->validate([
            'title_en' => ['required', 'string', 'max:150'],
            'title_fr' => ['required', 'string', 'max:150'],
            'description_en' => ['nullable', 'string'],
            'description_fr' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->has('is_active');

        $job->update($data);

        return redirect()->route('admin.jobs.index')->with('status', 'Job opening updated successfully!');
    }

    public function destroy($locale, JobOffer $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('status', 'Job opening deleted successfully!');
    }
}
