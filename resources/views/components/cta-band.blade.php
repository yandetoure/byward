@props(['title', 'text' => null])

<section class="section">
    <div class="container">
        <div class="cta-band text-center text-lg-start" data-reveal="zoom">
            <div class="grid-overlay"></div>
            <div class="glow glow-red" style="width:300px;height:300px;bottom:-120px;left:20%;opacity:.4"></div>

            <svg class="cta-truck" viewBox="0 0 640 320" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect x="20" y="90" width="330" height="150" rx="14" fill="#fff"/>
                <path d="M360 130h110l70 70v40H360z" fill="#fff"/>
                <circle cx="130" cy="262" r="36" fill="#fff"/>
                <circle cx="470" cy="262" r="36" fill="#fff"/>
                <circle cx="130" cy="262" r="16" fill="#0b1f3f"/>
                <circle cx="470" cy="262" r="16" fill="#0b1f3f"/>
            </svg>

            <div class="row align-items-center g-4 position-relative">
                <div class="col-lg-7">
                    <h2 class="text-balance">{{ $title }}</h2>
                    @if ($text)
                        <p class="lead mt-3 mb-0">{{ $text }}</p>
                    @endif
                </div>
                <div class="col-lg-5">
                    <div class="d-flex flex-column flex-sm-row flex-lg-column flex-xl-row gap-3 justify-content-lg-end flex-wrap">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
