<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b1f3f">

    <title>@yield('title', config('byward.company.name'))</title>
    <meta name="description" content="@yield('description', __('site.footer.tagline'))">

    <link rel="canonical" href="{{ url()->current() }}">
    @php $currentRoute = request()->route()?->getName() ?: 'home'; @endphp
    @foreach (\App\Http\Middleware\SetLocale::SUPPORTED as $alt)
        <link rel="alternate" hreflang="{{ $alt }}"
              href="{{ route($currentRoute, ['locale' => $alt]) }}">
    @endforeach

    <link rel="icon" href="{{ asset('images/logo1.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo1.png') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('byward.company.name') }}">
    <meta property="og:title" content="@yield('title', config('byward.company.name'))">
    <meta property="og:description" content="@yield('description', __('site.footer.tagline'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo1.png') }}">

    <link rel="preconnect" href="https://images.unsplash.com" crossorigin>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <div class="progress-bar-top" role="presentation"></div>

    <a href="#main" class="visually-hidden-focusable btn btn-navy position-absolute top-0 start-0 m-3" style="z-index:2000">
        {{ __('site.nav.home') }}
    </a>

    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @if(!in_array(request()->route()?->getName(), ['about', 'careers', 'contact', 'quote', 'estimate', 'faq']))
        @include('partials.careers-cta')
    @endif

    @include('partials.footer')

    {{-- ============================ SEARCH OVERLAY ============================ --}}
    <div id="searchOverlay" class="search-overlay" role="dialog" aria-modal="true" aria-label="Site Search" hidden>
        <div class="search-overlay-inner">
            <div class="search-overlay-bar">
                <x-icon name="search" size="22" class="search-overlay-icon" />
                <input type="search" id="searchInput" class="search-overlay-input"
                       placeholder="Search pages, services, industries…"
                       autocomplete="off" spellcheck="false" aria-label="Search">
                <button type="button" id="searchClose" class="search-overlay-close" aria-label="Close search">
                    <x-icon name="x" size="20" />
                </button>
            </div>
            <div id="searchResults" class="search-results" aria-live="polite"></div>
        </div>
    </div>

    {{-- ============================ LIVE CHAT WIDGET ============================ --}}
    <div class="live-chat-widget position-fixed end-0 m-3 m-md-4" style="z-index: 1050; bottom: 3rem;">
        <div id="live-chat-window" class="card shadow-lg d-none" style="position: absolute; bottom: 70px; right: 0; width: 350px; border-radius: 1rem; overflow: hidden; max-width: calc(100vw - 2rem);">
            <div class="card-header bg-navy text-white d-flex justify-content-between align-items-center p-3">
                <h6 class="mb-0 fw-bold">Live Chat</h6>
                <button type="button" class="btn-close btn-close-white" id="live-chat-close" aria-label="Close"></button>
            </div>
            <div class="card-body p-3 bg-light" id="live-chat-messages" style="height: 350px; overflow-y: auto;">
                <div class="d-flex mb-3">
                    <div class="bg-white border rounded-3 p-2 shadow-sm" style="max-width: 85%;">
                        <p class="mb-0 text-dark" style="font-size: 0.9rem;">{{ __('site.chat.welcome') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white p-2 border-top">
                <div class="d-flex flex-column gap-2 mb-2" id="live-chat-options">
                    <button class="btn btn-outline-brand btn-sm text-start live-chat-option" data-answer="{{ __('site.chat.questions.a1') }}">{{ __('site.chat.questions.q1') }}</button>
                    <button class="btn btn-outline-brand btn-sm text-start live-chat-option" data-answer="{{ __('site.chat.questions.a2') }}">{{ __('site.chat.questions.q2') }}</button>
                    <button class="btn btn-outline-brand btn-sm text-start live-chat-option" data-answer="{{ __('site.chat.questions.a3') }}">{{ __('site.chat.questions.q3') }}</button>
                    <button class="btn btn-outline-brand btn-sm text-start live-chat-option" data-answer="{{ __('site.chat.questions.a4') }}">{{ __('site.chat.questions.q4') }}</button>
                </div>
                <form id="live-chat-form" class="d-flex gap-2 align-items-center border-top pt-2" data-contact-url="{{ route('contact') }}" data-bot-response="{{ __('site.chat.fallback_response', ['url' => route('contact')]) }}">
                    <input type="text" id="live-chat-input" class="form-control form-control-sm" placeholder="{{ __('site.chat.placeholder') }}" aria-label="{{ __('site.chat.placeholder') }}" required autocomplete="off" style="border-radius: 20px;">
                    <button type="submit" id="live-chat-submit" class="btn btn-brand btn-sm p-0 d-flex align-items-center justify-content-center" style="border-radius: 50%; width: 32px; height: 32px; flex-shrink: 0;" aria-label="{{ __('site.chat.send') }}">
                        <x-icon name="arrow-right" size="14" />
                    </button>
                </form>
            </div>
        </div>
        <button type="button" id="live-chat-trigger" class="btn p-0 border-0 bg-transparent text-danger shadow-none" aria-label="Open Live Chat">
            <x-icon name="chat" size="40" />
        </button>
    </div>

    <button type="button" class="to-top" aria-label="{{ __('site.common.back_top') }}">
        <x-icon name="arrow-up" size="18" />
    </button>
</body>
</html>
