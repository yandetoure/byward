<?php

namespace App\Http\Controllers;

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
