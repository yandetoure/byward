@extends('layouts.app')

@section('title', __('site.industries.meta_title'))
@section('description', __('site.industries.meta_description'))

@php
    $img = config('byward.images');
    $items = __('site.industries.items');

    $icons = [
        'retail' => 'tag',
        'healthcare' => 'thermometer',
        'manufacturing' => 'layers',
        'automotive' => 'truck',
        'food' => 'box',
        'technology' => 'zap',
        'construction' => 'warehouse',
        'energy' => 'globe',
    ];
@endphp

@section('content')

<x-page-hero
    :eyebrow="__('site.industries.eyebrow')"
    :title="__('site.industries.title')"
    :text="__('site.industries.text')"
    :image="$img['hero_industries']"
    :current="__('site.nav.industries')">
    <a href="{{ route('quote') }}" class="btn btn-brand">{{ __('site.common.free_quote') }}</a>
    <a href="{{ route('services') }}" class="btn btn-ghost">{{ __('site.common.view_services') }}</a>
</x-page-hero>

{{-- Intro --}}
<section class="section pb-0">
    <div class="container">
        <div class="row g-4 align-items-end">
            <div class="col-lg-7" data-reveal="left">
                <span class="eyebrow">{{ __('site.industries.intro_eyebrow') }}</span>
                <h2 class="text-balance">{{ __('site.industries.intro_title') }}</h2>
            </div>
            <div class="col-lg-5" data-reveal="right">
                <p class="lead mb-0">{{ __('site.industries.intro_text') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Industry blocks --}}
<div class="container">
    @foreach ($icons as $key => $icon)
        @php $flip = $loop->index % 2 === 1; @endphp

        <section class="service-block" id="{{ $key }}">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 {{ $flip ? 'order-lg-2' : '' }}" data-reveal="{{ $flip ? 'right' : 'left' }}">
                    <div class="media-frame media-square">
                        <img src="{{ $img['industry_'.$key] }}" alt="{{ $items[$key]['name'] }}" loading="lazy">
                    </div>
                </div>

                <div class="col-lg-7 {{ $flip ? 'order-lg-1 pe-lg-4' : 'ps-lg-4' }}"
                     data-reveal="{{ $flip ? 'left' : 'right' }}">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="icon-tile icon-tile-sm {{ $loop->index % 2 ? 'icon-tile-red' : '' }}">
                            <x-icon :name="$icon" size="20" />
                        </span>
                        <span class="service-index mb-0">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <h2>{{ $items[$key]['name'] }}</h2>
                    <p class="lead mt-3">{{ $items[$key]['long'] }}</p>

                    <ul class="check-list check-list-red mt-4 row row-cols-1 row-cols-sm-2 g-2">
                        @foreach ($items[$key]['features'] as $feature)
                            <li class="col">
                                <span class="tick"><x-icon name="check" size="12" /></span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endforeach
</div>

{{-- Approach --}}
<section class="section bg-navy position-relative overflow-hidden">
    <div class="grid-overlay"></div>
    <div class="glow glow-red" style="width:360px;height:360px;top:-100px;right:5%;opacity:.35"></div>

    <div class="container position-relative">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-reveal="left">
                <span class="eyebrow eyebrow-light">{{ __('site.industries.approach_eyebrow') }}</span>
                <h2 class="text-balance">{{ __('site.industries.approach_title') }}</h2>
                <p class="lead mt-3">{{ __('site.industries.approach_text') }}</p>

                <ul class="check-list check-list-light mt-4">
                    @foreach (__('site.industries.approach_points') as $point)
                        <li>
                            <span class="tick"><x-icon name="check" size="12" /></span>
                            {{ $point }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-6 ps-lg-5" data-reveal="right">
                <div class="media-frame media-wide">
                    <img src="{{ $img['approach'] }}" alt="" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<x-cta-band :title="__('site.industries.cta_title')" :text="__('site.industries.cta_text')">
    <a href="{{ route('contact') }}" class="btn btn-brand btn-lg">{{ __('site.common.free_quote') }}</a>
    <a href="{{ route('services') }}" class="btn btn-ghost btn-lg">{{ __('site.common.view_services') }}</a>
</x-cta-band>

@endsection
