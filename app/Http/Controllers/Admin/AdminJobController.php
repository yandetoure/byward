<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class AdminJobController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $query = JobOffer::latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title_fr', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('description_fr', 'like', "%{$search}%")
                  ->orWhere('description_en', 'like', "%{$search}%");
            });
        }

        $jobs = $query->paginate(15)->withQueryString();

        return view('admin.jobs.index', compact('jobs', 'search'));
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
