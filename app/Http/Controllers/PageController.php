<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function industries()
    {
        return view('pages.industries');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function careers()
    {
        $jobs = JobOffer::where('is_active', true)->latest()->get();
        return view('pages.careers', compact('jobs'));
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function quote()
    {
        return view('pages.quote');
    }

    public function privacy()
    {
        return view('pages.legal', ['doc' => 'privacy']);
    }

    public function terms()
    {
        return view('pages.legal', ['doc' => 'terms']);
    }
}
