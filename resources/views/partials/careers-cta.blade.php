<section class="section pt-0">
    <div class="container">
        <div class="careers-band text-center text-lg-start" data-reveal="zoom">
            <div class="grid-overlay"></div>
            <div class="glow glow-blue" style="width:300px;height:300px;top:-120px;right:10%;opacity:.4"></div>
            <div class="glow glow-red" style="width:250px;height:250px;bottom:-100px;left:10%;opacity:.3"></div>

            <div class="position-relative text-center mb-5">
                <span class="eyebrow eyebrow-light mb-2">{{ __('site.careers.cta_eyebrow') }}</span>
                <h2 class="text-balance text-white mb-0">{{ __('site.careers.cta_title') }}</h2>
            </div>

            <div class="row g-4 position-relative z-1 justify-content-center">
                @foreach(__('site.careers.positions') as $val => $label)
                    @if($val !== 'other')
                    <div class="col-md-6 col-lg-3">
                        <a href="{{ route('careers') }}?position={{ $val }}#form" class="careers-card text-decoration-none h-100 d-flex flex-column p-4">
                            <h5 class="mb-3">{{ $label }}</h5>
                            <p class="mb-4 text-white-50 text-balance" style="font-size: 0.9rem; line-height: 1.5;">{{ __('site.careers.position_desc.' . $val) }}</p>
                            <div class="mt-auto">
                                <span class="apply-link">{{ __('site.careers.apply_now') }} <x-icon name="arrow-right" size="16" /></span>
                            </div>
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
