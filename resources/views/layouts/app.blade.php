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

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('byward.company.name') }}">
    <meta property="og:title" content="@yield('title', config('byward.company.name'))">
    <meta property="og:description" content="@yield('description', __('site.footer.tagline'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

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

    @include('partials.footer')

    {{-- ============================ LIVE CHAT WIDGET ============================ --}}
    <div class="live-chat-widget position-fixed end-0 m-3 m-md-4" style="z-index: 1050; bottom: 5rem;">
        <div id="live-chat-window" class="card shadow-lg d-none" style="position: absolute; bottom: 70px; right: 0; width: 350px; border-radius: 1rem; overflow: hidden; max-width: calc(100vw - 2rem);">
            <div class="card-header bg-brand text-white d-flex justify-content-between align-items-center p-3">
                <h6 class="mb-0 fw-bold">Live Chat</h6>
                <button type="button" class="btn-close btn-close-white" id="live-chat-close" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 text-center bg-white">
                <p class="mb-3 text-muted">Notre service client est actuellement disponible via notre page de contact ou par téléphone.</p>
                <a href="{{ route('contact') }}" class="btn btn-brand btn-sm">Nous contacter</a>
            </div>
        </div>
        <button type="button" id="live-chat-trigger" class="btn p-0 border-0 bg-transparent text-brand shadow-none" aria-label="Open Live Chat">
            <x-icon name="chat" size="56" />
        </button>
    </div>

    <button type="button" class="to-top" aria-label="{{ __('site.common.back_top') }}">
        <x-icon name="arrow-up" size="18" />
    </button>
</body>
</html>
