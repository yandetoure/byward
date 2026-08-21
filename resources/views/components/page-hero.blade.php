@props([
    'eyebrow' => null,
    'title',
    'text' => null,
    'image' => null,
    'current' => null,
])

<section class="page-hero">
    @if ($image)
        <div class="page-hero-media">
            <img src="{{ $image }}" alt="" loading="eager" fetchpriority="high">
        </div>
    @endif
    <div class="grid-overlay"></div>
    <div class="glow glow-red" style="width:340px;height:340px;top:-120px;left:-60px;opacity:.32"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-xl-8">
                <nav class="breadcrumb-by fade-up-delayed d-1" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">{{ __('site.nav.home') }}</a>
                    <span class="sep">/</span>
                    <span>{{ $current ?? $title }}</span>
                </nav>

                @if ($eyebrow)
                    <span class="eyebrow eyebrow-light fade-up-delayed d-1">{{ $eyebrow }}</span>
                @endif

                <h1 class="text-balance fade-up-delayed d-2">{!! $title !!}</h1>

                @if ($text)
                    <p class="lead mt-3 mw-720 fade-up-delayed d-3">{{ $text }}</p>
                @endif

                @if (! $slot->isEmpty())
                    <div class="d-flex flex-wrap gap-3 mt-4 fade-up-delayed d-4">{{ $slot }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
