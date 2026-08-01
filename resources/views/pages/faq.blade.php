@extends('layouts.app')

@section('title', __('site.faq.meta_title'))
@section('description', __('site.faq.meta_description'))

@php
    $img = config('byward.images');
    $groups = __('site.faq.groups');

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($groups)->flatMap(fn ($g) => $g['items'])->map(fn ($i) => [
            '@type' => 'Question',
            'name' => $i['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['a']],
        ])->values()->all(),
    ];
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')

<x-page-hero
    :eyebrow="__('site.faq.eyebrow')"
    :title="__('site.faq.title')"
    :text="__('site.faq.text')"
    :image="$img['hero_faq']"
    :current="__('site.nav.faq')">
    <a href="{{ route('contact') }}" class="btn btn-brand">{{ __('site.common.get_in_touch') }}</a>
</x-page-hero>

<section class="section">
    <div class="container">
        <div class="row g-5">
            {{-- Sticky group nav --}}
            <div class="col-lg-4">
                <div class="position-sticky" style="top:calc(var(--by-nav-h) + 24px)" data-reveal="left">
                    <span class="eyebrow">{{ __('site.faq.eyebrow') }}</span>
                    <h2 class="h3 mb-4">{{ __('site.faq.title') }}</h2>

                    <ul class="footer-links" style="gap:.55rem">
                        @foreach ($groups as $g => $group)
                            <li>
                                <a href="#group-{{ $g }}" class="link-arrow">
                                    <x-icon name="chevron-right" size="15" />
                                    {{ $group['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="card-soft mt-4 p-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="icon-tile icon-tile-sm icon-tile-red"><x-icon name="phone" size="18" /></span>
                            <span>
                                <strong class="d-block" style="font-size:.92rem;color:var(--by-navy-800)">
                                    {{ __('site.contact.label_phone') }}
                                </strong>
                                <a href="tel:{{ config('byward.company.phone_href') }}" class="link-arrow">
                                    {{ config('byward.company.phone') }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Accordions --}}
            <div class="col-lg-8">
                @foreach ($groups as $g => $group)
                    <div class="mb-5" id="group-{{ $g }}" style="scroll-margin-top:calc(var(--by-nav-h) + 24px)">
                        <h3 class="mb-3" data-reveal>{{ $group['title'] }}</h3>

                        <div class="accordion accordion-by" id="faqGroup{{ $g }}" data-reveal>
                            @foreach ($group['items'] as $i => $item)
                                @php $id = "q{$g}-{$i}"; @endphp
                                <div class="accordion-item">
                                    <h4 class="accordion-header">
                                        <button class="accordion-button {{ $g === 0 && $i === 0 ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#{{ $id }}"
                                                aria-expanded="{{ $g === 0 && $i === 0 ? 'true' : 'false' }}"
                                                aria-controls="{{ $id }}">
                                            {{ $item['q'] }}
                                        </button>
                                    </h4>
                                    <div id="{{ $id }}"
                                         class="accordion-collapse collapse {{ $g === 0 && $i === 0 ? 'show' : '' }}"
                                         data-bs-parent="#faqGroup{{ $g }}">
                                        <div class="accordion-body">{{ $item['a'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<x-cta-band :title="__('site.faq.cta_title')" :text="__('site.faq.cta_text')">
    <a href="{{ route('contact') }}" class="btn btn-brand btn-lg">{{ __('site.nav.contact') }}</a>
    <a href="tel:{{ config('byward.company.phone_href') }}" class="btn btn-ghost btn-lg">
        {{ config('byward.company.phone') }}
    </a>
</x-cta-band>

@endsection
