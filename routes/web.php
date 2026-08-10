<?php

use App\Http\Controllers\EstimateController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TrackingController;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Land on the visitor's preferred language, falling back to English.
Route::get('/', function (Request $request) {
    $preferred = $request->getPreferredLanguage(SetLocale::SUPPORTED) ?? config('app.locale');

    return redirect()->route('home', ['locale' => $preferred]);
});

Route::prefix('{locale}')
    ->where(['locale' => implode('|', SetLocale::SUPPORTED)])
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::get('/services', [PageController::class, 'services'])->name('services');
        Route::get('/industries', [PageController::class, 'industries'])->name('industries');
        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/faq', [PageController::class, 'faq'])->name('faq');
        Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
        Route::get('/terms', [PageController::class, 'terms'])->name('terms');

        Route::get('/careers', [PageController::class, 'careers'])->name('careers');
        Route::post('/careers', [LeadController::class, 'career'])
            ->middleware('throttle:10,1')
            ->name('careers.send');

        Route::get('/contact', [PageController::class, 'contact'])->name('contact');
        Route::post('/contact', [LeadController::class, 'contact'])
            ->middleware('throttle:10,1')
            ->name('contact.send');

        Route::get('/tracking', [TrackingController::class, 'show'])->name('tracking.show');

        Route::get('/quote', [PageController::class, 'quote'])->name('quote');
        Route::post('/quote', [LeadController::class, 'quote'])
            ->middleware('throttle:10,1')
            ->name('quote.send');

        Route::get('/estimate', [EstimateController::class, 'show'])->name('estimate');
        Route::post('/estimate', [EstimateController::class, 'calculate'])
            ->middleware('throttle:30,1')
            ->name('estimate.calculate');
    });
