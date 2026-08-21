@php
    $services = __('site.services.items');
    $serviceAnchors = [
        'freight' => 'freight',
        'warehousing' => 'warehousing',
        'lastmile' => 'last-mile',
        'supply' => 'supply-chain',
        'whiteglove' => 'white-glove',
    ];

@endphp

<footer class="site-footer">
    <div class="glow glow-blue" style="width:420px;height:420px;top:-180px;right:-80px;opacity:.28"></div>

    <div class="container position-relative">
        <div class="row g-5">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="footer-logo-plate" aria-label="{{ config('byward.company.name') }}">
                    <img src="{{ asset('images/logo1.png') }}" alt="{{ config('byward.company.name') }}">
                </a>
                <p class="fs-5 fw-bold text-brand mt-3 mb-2" style="letter-spacing: 0.5px;">On Time. Every Time.</p>
                <p style="max-width:340px">{{ __('site.footer.tagline') }}</p>

                <ul class="footer-contact mt-4">
                    <li>
                        <x-icon name="phone" />
                        <a href="tel:{{ config('byward.company.phone_href') }}">{{ config('byward.company.phone') }}</a>
                    </li>
                    <li>
                        <x-icon name="mail" />
                        <a href="mailto:{{ config('byward.company.email') }}">{{ config('byward.company.email') }}</a>
                    </li>
                    <li class="d-none">
                        <x-icon name="pin" />
                        <span>{!! nl2br(e(__('site.footer.address'))) !!}</span>
                    </li>
                </ul>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ config('byward.social.facebook') }}" class="social-dot" aria-label="Facebook" target="_blank" rel="noopener"><x-icon name="facebook" /></a>
                    <a href="{{ config('byward.social.instagram') }}" class="social-dot" aria-label="Instagram" target="_blank" rel="noopener"><x-icon name="instagram" /></a>
                    <a href="{{ config('byward.social.linkedin') }}" class="social-dot" aria-label="LinkedIn" target="_blank" rel="noopener"><x-icon name="linkedin" /></a>
                </div>
            </div>

            <div class="col-6 col-lg-3 offset-lg-1">
                <h5>{{ __('site.footer.services') }}</h5>
                <ul class="footer-links">
                    @foreach ($serviceAnchors as $key => $anchor)
                        <li><a href="{{ route('services') }}#{{ $anchor }}">{{ $services[$key]['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h5>{{ __('site.footer.company') }}</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">{{ __('site.nav.about') }}</a></li>
                    <li><a href="{{ route('careers') }}">{{ __('site.nav.careers') }}</a></li>
                    <li><a href="{{ route('industries') }}">{{ __('site.nav.industries') }}</a></li>
                    <li><a href="{{ route('faq') }}">{{ __('site.nav.faq') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('site.nav.contact') }}</a></li>
                    <li><a href="{{ route('quote') }}">{{ __('site.nav.quote') }}</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h5>{{ __('site.footer.legal') }}</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('privacy') }}">{{ __('site.footer.privacy') }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ __('site.footer.terms') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <span>&copy; {{ date('Y') }} {{ config('byward.company.name') }}. {{ __('site.footer.rights') }}</span>
            <span class="d-flex gap-4">
                <a href="{{ route('privacy') }}">{{ __('site.footer.privacy_short') }}</a>
                <a href="{{ route('terms') }}">{{ __('site.footer.terms_short') }}</a>
            </span>
        </div>
    </div>
</footer>
