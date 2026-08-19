@php
    $current = request()->route()?->getName() ?: 'home';
    $links = [
        'services' => __('site.nav.services'),
        'industries' => __('site.nav.industries'),
        'about' => __('site.nav.about'),
        'faq' => __('site.nav.faq'),
        'contact' => __('site.nav.contact'),
    ];
@endphp

<header class="site-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg p-0" aria-label="{{ __('site.nav.menu') }}">
            <a class="navbar-brand p-0 me-4 position-relative" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-light.png') }}" alt="{{ config('byward.company.name') }}"
                     class="brand-logo brand-logo-light">
                <img src="{{ asset('images/logo.png') }}" alt="" aria-hidden="true"
                     class="brand-logo brand-logo-dark">
            </a>

            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false"
                    aria-label="{{ __('site.nav.menu') }}">
                <span></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-lg-auto mb-3 mb-lg-0">
                    @foreach ($links as $route => $label)
                        <li class="nav-item">
                            <a class="nav-link nav-link-main {{ $current === $route ? 'active' : '' }}"
                               href="{{ route($route) }}"
                               @if ($current === $route) aria-current="page" @endif>{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-2 gap-lg-3">
                    <div class="lang-switch align-self-start align-self-lg-center order-lg-1">
                        @foreach (\App\Http\Middleware\SetLocale::SUPPORTED as $lang)
                            <a href="{{ route($current, ['locale' => $lang]) }}"
                               class="{{ app()->getLocale() === $lang ? 'active' : '' }}"
                               lang="{{ $lang }}">{{ strtoupper($lang) }}</a>
                        @endforeach
                    </div>

                    <div class="nav-search-wrap d-none d-lg-block position-relative me-1" id="navSearchWrap">
                        <div class="nav-search-bar">
                            <x-icon name="search" size="14" class="nav-search-icon" />
                            <input type="search" id="navSearchInput"
                                   class="nav-search-input"
                                   placeholder="Search…"
                                   autocomplete="off"
                                   spellcheck="false"
                                   aria-label="Search site content"
                                   aria-expanded="false"
                                   aria-autocomplete="list"
                                   aria-controls="navSearchDropdown">
                        </div>
                        <div id="navSearchDropdown" class="nav-search-dropdown" role="listbox" hidden></div>
                    </div>
                    <a href="{{ route('estimate') }}" class="btn btn-header-ghost btn-sm px-3 py-2 order-lg-3">
                        {{ __('site.nav.estimate') }}
                    </a>
                    <a href="{{ route('quote') }}" class="btn btn-brand btn-sm px-3 py-2 order-lg-4">
                        {{ __('site.nav.quote') }}
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>
