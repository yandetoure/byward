@extends('layouts.app')

@section('title', __('site.services.meta_title'))
@section('description', __('site.services.meta_description'))

@php
    $img = config('byward.images');
    $items = __('site.services.items');

    $blocks = [
        'freight'     => ['anchor' => 'freight',      'icon' => 'truck',     'image' => $img['service_freight']],
        'warehousing' => ['anchor' => 'warehousing',  'icon' => 'warehouse', 'image' => $img['service_warehouse']],
        'lastmile'    => ['anchor' => 'last-mile',    'icon' => 'pin',       'image' => $img['service_lastmile']],
        'supply'      => ['anchor' => 'supply-chain', 'icon' => 'network',   'image' => $img['service_supply']],
        'customs'     => ['anchor' => 'customs',      'icon' => 'shield',    'image' => $img['service_customs']],
        'reverse'     => ['anchor' => 'reverse',      'icon' => 'rotate',    'image' => $img['service_reverse']],
        'whiteglove'  => ['anchor' => 'white-glove',  'icon' => 'box',       'image' => $img['service_whiteglove']],
    ];
@endphp

@section('content')

<x-page-hero
    :eyebrow="__('site.services.eyebrow')"
    :title="__('site.services.title')"
    :text="__('site.services.text')"
    :image="$img['hero_services']"
    :current="__('site.nav.services')">
    <a href="{{ route('quote') }}" class="btn btn-brand">{{ __('site.common.free_quote') }}</a>
    <a href="{{ route('estimate') }}" class="btn btn-ghost">{{ __('site.common.calculate') }}</a>
</x-page-hero>

{{-- Quick jump bar --}}
<section class="section-tight pb-0">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 justify-content-center" data-reveal>
            @foreach ($blocks as $key => $meta)
                <a href="#{{ $meta['anchor'] }}" class="btn btn-outline-navy btn-sm px-3 py-2">
                    {{ $items[$key]['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Detailed service blocks --}}
<div class="container">
    @foreach ($blocks as $key => $meta)
        @php $flip = $loop->index % 2 === 1; @endphp

        <section class="service-block" id="{{ $meta['anchor'] }}">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 {{ $flip ? 'order-lg-2' : '' }}" data-reveal="{{ $flip ? 'right' : 'left' }}">
                    <div class="media-frame media-wide">
                        <img src="{{ $meta['image'] }}" alt="{{ $items[$key]['name'] }}" loading="lazy">
                    </div>
                </div>

                <div class="col-lg-6 {{ $flip ? 'order-lg-1 pe-lg-4' : 'ps-lg-4' }}"
                     data-reveal="{{ $flip ? 'left' : 'right' }}">
                    <div class="service-index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>

                    <span class="icon-tile {{ $loop->index % 2 ? 'icon-tile-red' : '' }}">
                        <x-icon :name="$meta['icon']" />
                    </span>

                    <h2>{{ $items[$key]['name'] }}</h2>
                    <p class="lead mt-3">{{ $items[$key]['long'] }}</p>

                    <ul class="check-list mt-4 row row-cols-1 row-cols-sm-2 g-2">
                        @foreach ($items[$key]['features'] as $feature)
                            <li class="col">
                                <span class="tick"><x-icon name="check" size="12" /></span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('quote') }}" class="btn btn-navy mt-4">
                        {{ __('site.common.free_quote') }}
                    </a>
                </div>
            </div>
        </section>
    @endforeach
</div>

{{-- How it works --}}
<section class="section bg-sand">
    <div class="container">
        <div class="text-center mx-auto mw-720 mb-5" data-reveal>
            <span class="eyebrow eyebrow-center">{{ __('site.services.steps_eyebrow') }}</span>
            <h2 class="text-balance">{{ __('site.services.steps_title') }}</h2>
        </div>

        <div class="row g-4 steps-track">
            @foreach (__('site.services.steps') as $i => $step)
                <div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="{{ $i * 100 }}">
                    <div class="step-card">
                        <span class="step-num">{{ $step['num'] }}</span>
                        <h4>{{ $step['title'] }}</h4>
                        <p>{{ $step['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<x-cta-band :title="__('site.services.cta_title')" :text="__('site.services.cta_text')">
    <a href="{{ route('quote') }}" class="btn btn-brand btn-lg">{{ __('site.common.free_quote') }}</a>
    <a href="{{ route('contact') }}" class="btn btn-ghost btn-lg">{{ __('site.common.talk_expert') }}</a>
</x-cta-band>

@endsection
