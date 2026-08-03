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
    <div class="live-chat-widget position-fixed bottom-0 end-0 m-3 m-md-4" style="z-index: 1050;">
        <button type="button" id="live-chat-trigger" class="btn btn-brand rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;" aria-label="Open Live Chat">
            <x-icon name="chat" size="24" />
        </button>
    </div>

    <button type="button" class="to-top" aria-label="{{ __('site.common.back_top') }}">
        <x-icon name="arrow-up" size="18" />
    </button>
</body>
</html>
