@extends('layouts.app')

@section('title', __('site.home.meta_title'))
@section('description', __('site.home.meta_description'))

@php
    $img = config('byward.images');
    $services = __('site.services.items');
    $industries = __('site.industries.items');

    $serviceCards = [
        'freight' => ['icon' => 'truck', 'anchor' => 'freight'],
        'warehousing' => ['icon' => 'warehouse', 'anchor' => 'warehousing'],
        'lastmile' => ['icon' => 'pin', 'anchor' => 'last-mile'],
        'supply' => ['icon' => 'network', 'anchor' => 'supply-chain'],
        'customs' => ['icon' => 'shield', 'anchor' => 'customs'],
        'reverse' => ['icon' => 'rotate', 'anchor' => 'reverse'],
    ];

    $homeIndustries = ['retail', 'manufacturing', 'automotive', 'food'];
    $whyIcons = ['check-circle', 'eye', 'support', 'tag'];
    $homeFaq = collect(__('site.faq.groups'))->flatMap(fn ($g) => $g['items'])->take(3);
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'LogisticsBusiness',
    'name' => config('byward.company.name'),
    'url' => route('home'),
    'logo' => asset('images/logo.png'),
    'telephone' => config('byward.company.phone'),
    'email' => config('byward.company.email'),
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => '150 Elgin Street, Suite 1000',
        'addressLocality' => 'Ottawa',
        'addressRegion' => 'ON',
        'postalCode' => 'K2P 1L4',
        'addressCountry' => 'CA',
    ],
    'foundingDate' => (string) config('byward.company.founded'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')

{{-- ============================ HERO ============================ --}}
<section class="hero">
    <div class="hero-media">
        <img src="{{ $img['hero'] }}" alt="" data-parallax="0.04" fetchpriority="high">
    </div>
    <div class="grid-overlay"></div>
    <div class="glow glow-red" style="width:380px;height:380px;top:8%;left:-6%;"></div>
    <div class="glow glow-blue" style="width:460px;height:460px;bottom:-12%;right:-8%;"></div>

    <div class="container hero-inner">
        <div class="row">
            <div class="col-lg-9 col-xl-8">
                <span class="hero-badge fade-up-delayed d-1" style="animation-delay:.05s">
                    <span class="pulse-dot"></span>
                    {{ __('site.home.hero_badge') }}
                </span>

                <h1 class="display-hero text-white mt-4 mb-0">
                    <span class="hero-line"><span>{{ __('site.home.hero_l1') }}</span></span>
                    <span class="hero-line"><span>{{ __('site.home.hero_l2') }}</span></span>
                    <span class="hero-line"><span class="text-gradient">{{ __('site.home.hero_l3') }}</span></span>
                </h1>

                <p class="lead mt-4 mw-620 fade-up-delayed d-2" style="color:rgba(255,255,255,.76)">
                    {{ __('site.home.hero_text') }}
                </p>
                <div class="mt-3 fade-up-delayed d-2">
                    <span class="fs-5 fw-medium text-white" style="letter-spacing: 0.5px;">On Time. Every Time.</span>
                </div>

                <div class="mt-5 fade-up-delayed d-3 p-3 bg-white bg-opacity-10 rounded-3 backdrop-blur" style="max-width: 500px; border: 1px solid rgba(255,255,255,0.2);">
                    <form action="{{ route('tracking.show') }}" method="GET" class="d-flex align-items-center gap-2">
                        <div class="flex-grow-1">
                            <label class="visually-hidden" for="heroTrackId">Tracking Number</label>
                            <input type="text" name="id" id="heroTrackId" class="form-control form-control-lg bg-white border-0" placeholder="Enter Tracking Number..." style="box-shadow: none;" required>
                        </div>
                        <button type="submit" class="btn btn-brand btn-lg d-flex align-items-center gap-2">
                            <x-icon name="arrow-right" size="18" /> Track
                        </button>
                    </form>
                </div>

                <div class="d-flex flex-column flex-sm-row flex-wrap gap-3 mt-4 fade-up-delayed d-4">
                    <a href="{{ route('quote') }}" class="btn btn-outline-light btn-lg">
                        {{ __('site.common.free_quote') }}
                    </a>
                    <a href="{{ route('services') }}" class="btn btn-ghost text-white btn-lg">
                        {{ __('site.common.view_services') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <span class="scroll-hint" aria-hidden="true"></span>
</section>

{{-- ============================ STATS ============================ --}}
<section class="stats-strip">
    <div class="container">
        <div class="stats-card" data-reveal>
            <div class="row g-0">
                @foreach (__('site.home.features') as $i => $feature)
                    <div class="col-6 col-lg-3 stat-item">
                        <div class="d-flex flex-column align-items-center text-center px-md-3">
                            <span class="icon-tile icon-tile-sm {{ $i % 2 ? 'icon-tile-red' : '' }} mb-3">
                                <x-icon :name="$feature['icon']" />
                            </span>
                            <span class="fw-semibold" style="font-size: 0.95rem; line-height: 1.45; color: var(--by-navy-800); max-width: 220px;">
                                {{ $feature['text'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============================ PARTNER LOGOS ============================ --}}
        </div>
    </div>
</section>

{{-- ============================ PARTNER LOGOS ============================ --}}
<section class="section-sm bg-light border-bottom border-light-subtle overflow-hidden">
    <div class="container text-center">
        <p class="text-muted fw-semibold mb-4 fs-6 text-uppercase" style="letter-spacing: 1px;" data-reveal>{{ __('site.common.partners') }}</p>
        <div class="marquee mt-4" data-reveal>
            <div class="marquee-track">
                @php
                    $partners = ['IMG_1469.JPG', 'IMG_1470.PNG', 'IMG_1471.JPG', 'IMG_1472.PNG', 'IMG_1473.PNG', 'IMG_1474.JPG', 'IMG_1475.PNG'];
                @endphp
                @foreach(array_merge($partners, $partners) as $partner)
                <div class="partner-logo d-flex align-items-center justify-content-center px-4" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='scale(1)'">
                    <img src="{{ asset('partners/' . $partner) }}" alt="{{ __('site.common.partner') }}" style="max-height: 55px; width: auto; object-fit: contain;">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============================ MARQUEE ============================ --}}
<section class="section-sm">
    <div class="container">
        <div class="bg-navy rounded-4xl py-4 overflow-hidden position-relative" data-reveal>
            <div class="marquee">
                <div class="marquee-track">
                    @foreach (__('site.home.marquee') as $item)
                        <span class="marquee-item"><x-icon name="check" size="17" />{{ $item }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================ SERVICES ============================ --}}
<section class="section bg-sand">
    <div class="container">
        <div class="row align-items-end g-4 mb-5">
            <div class="col-lg-7" data-reveal="left">
                <span class="eyebrow">{{ __('site.home.services_eyebrow') }}</span>
                <h2 class="text-balance">{{ __('site.home.services_title') }}</h2>
            </div>
            <div class="col-lg-5" data-reveal="right">
                <p class="lead mb-0">{{ __('site.home.services_text') }}</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach ($serviceCards as $key => $meta)
                <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="{{ $loop->index * 80 }}">
                    <a href="{{ route('services') }}#{{ $meta['anchor'] }}" class="card-service d-block text-decoration-none">
                        <span class="icon-tile {{ $loop->index % 3 === 1 ? 'icon-tile-red' : '' }}">
                            <x-icon :name="$meta['icon']" />
                        </span>
                        <h3>{{ $services[$key]['name'] }}</h3>
                        <p>{{ $services[$key]['short'] }}</p>
                        <span class="link-arrow mt-auto">
                            {{ __('site.common.learn_more') }}
                            <x-icon name="arrow-right" size="16" />
                        </span>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-reveal>
            <a href="{{ route('services') }}" class="btn btn-navy btn-lg">
                {{ __('site.common.all_services') }}
            </a>
        </div>
    </div>
</section>

{{-- ============================ WHY US ============================ --}}
<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 position-relative" data-reveal="left">
                <span class="dot-pattern" style="left:-28px;top:-28px"></span>
                <div class="media-frame media-wide">
                    <img src="{{ $img['why'] }}" alt="{{ __('site.services.items.warehousing.name') }}" loading="lazy">
                </div>
                <div class="media-badge badge-br">
                    <span class="icon-tile icon-tile-sm icon-tile-red"><x-icon name="truck" size="20" /></span>
                    <span>
                        <strong>{{ __('site.home.why_badge_1_title') }}</strong>
                        <span>{{ __('site.home.why_badge_1_text') }}</span>
                    </span>
                </div>
                <div class="media-badge badge-tl d-none d-md-flex">
                    <span class="icon-tile icon-tile-sm"><x-icon name="globe" size="20" /></span>
                    <span>
                        <strong>{{ __('site.home.why_badge_2_title') }}</strong>
                        <span>{{ __('site.home.why_badge_2_text') }}</span>
                    </span>
                </div>
            </div>

            <div class="col-lg-6 ps-lg-4" data-reveal="right">
                <span class="eyebrow">{{ __('site.home.why_eyebrow') }}</span>
                <h2 class="text-balance">{{ __('site.home.why_title') }}</h2>
                <p class="lead mt-3">{{ __('site.home.why_text') }}</p>

                <div class="mt-4">
                    @foreach (__('site.home.why_items') as $i => $item)
                        <div class="feature-row">
                            <span class="icon-tile icon-tile-sm {{ $i % 2 ? 'icon-tile-red' : '' }}">
                                <x-icon :name="$whyIcons[$i]" size="20" />
                            </span>
                            <span>
                                <h4>{{ $item['title'] }}</h4>
                                <p>{{ $item['text'] }}</p>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================ ESTIMATE TEASER ============================ --}}
<section class="section-sm">
    <div class="container">
        <div class="bg-navy rounded-4xl overflow-hidden position-relative" data-reveal>
            <div class="grid-overlay"></div>
            <div class="row g-0 align-items-center">
                <div class="col-lg-7 p-4 p-lg-5 position-relative">
                    <span class="eyebrow eyebrow-light">{{ __('site.home.estimate_eyebrow') }}</span>
                    <h2 class="text-balance">{{ __('site.home.estimate_title') }}</h2>
                    <p class="lead mt-3 mw-560">{{ __('site.home.estimate_text') }}</p>
                    <div class="d-flex flex-column flex-sm-row flex-wrap gap-3 mt-4">
                        <a href="{{ route('estimate') }}" class="btn btn-brand">
                            {{ __('site.common.calculate') }}
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-ghost">
                            {{ __('site.common.talk_expert') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="{{ $img['estimate_teaser'] }}" alt="" loading="lazy"
                         style="width:100%;height:420px;object-fit:cover;">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================ INDUSTRIES ============================ --}}
<section class="section bg-sand">
    <div class="container">
        <div class="text-center mx-auto mw-720 mb-5" data-reveal>
            <span class="eyebrow eyebrow-center">{{ __('site.home.industries_eyebrow') }}</span>
            <h2 class="text-balance">{{ __('site.home.industries_title') }}</h2>
            <p class="lead mt-3">{{ __('site.home.industries_text') }}</p>
        </div>

        <div class="row g-4">
            @foreach ($homeIndustries as $i => $key)
                <div class="col-sm-6 col-lg-4" data-reveal="zoom" data-reveal-delay="{{ $i * 70 }}">
                    <a href="{{ route('industries') }}#{{ $key }}" class="industry-tile">
                        <img src="{{ $img['industry_'.$key] }}" alt="{{ $industries[$key]['name'] }}" loading="lazy">
                        <span class="tile-body">
                            <h3>{{ $industries[$key]['name'] }}</h3>
                            <p>{{ $industries[$key]['short'] }}</p>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-reveal>
            <a href="{{ route('industries') }}" class="btn btn-outline-navy btn-lg">
                {{ __('site.common.all_industries') }}
            </a>
        </div>
    </div>
</section>

{{-- ============================ TESTIMONIALS ============================ --}}
<section class="section">
    <div class="container">
        <div class="text-center mx-auto mw-720 mb-5" data-reveal>
            <span class="eyebrow eyebrow-center">{{ __('site.home.testimonials_eyebrow') }}</span>
            <h2 class="text-balance">{{ __('site.home.testimonials_title') }}</h2>
        </div>

        <div class="row g-4">
            @foreach (__('site.home.testimonials') as $i => $t)
                <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="{{ $i * 90 }}">
                    <figure class="quote-card mb-0">
                        <span class="stars" aria-label="5/5">
                            @for ($s = 0; $s < 5; $s++)<x-icon name="star" size="16" />@endfor
                        </span>
                        <blockquote>{{ $t['quote'] }}</blockquote>
                        <figcaption class="d-flex align-items-center gap-3">
                            <span class="avatar-initials">{{ $t['initials'] }}</span>
                            <span>
                                <strong class="d-block" style="color:var(--by-navy-800);font-size:.98rem">{{ $t['name'] }}</strong>
                                <span class="text-muted-2" style="font-size:.85rem">{{ $t['role'] }}</span>
                            </span>
                        </figcaption>
                    </figure>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================ FAQ ============================ --}}
<section class="section bg-sand">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4" data-reveal="left">
                <span class="eyebrow">{{ __('site.home.faq_eyebrow') }}</span>
                <h2 class="text-balance">{{ __('site.home.faq_title') }}</h2>
                <a href="{{ route('faq') }}" class="btn btn-outline-navy mt-4">
                    {{ __('site.common.all_faq') }}
                </a>
            </div>

            <div class="col-lg-8" data-reveal="right">
                <div class="accordion accordion-by" id="homeFaq">
                    @foreach ($homeFaq as $i => $item)
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button {{ $i === 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#hf{{ $i }}"
                                        aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" aria-controls="hf{{ $i }}">
                                    {{ $item['q'] }}
                                </button>
                            </h3>
                            <div id="hf{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                                 data-bs-parent="#homeFaq">
                                <div class="accordion-body">{{ $item['a'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================ CTA ============================ --}}
<x-cta-band :title="__('site.home.cta_title')" :text="__('site.home.cta_text')">
    <a href="{{ route('quote') }}" class="btn btn-brand btn-lg">{{ __('site.common.free_quote') }}</a>
    <a href="{{ route('contact') }}" class="btn btn-ghost btn-lg">{{ __('site.common.contact_sales') }}</a>
</x-cta-band>

@endsection
