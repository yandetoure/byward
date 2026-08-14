@extends('layouts.app')

@section('title', __('site.about.meta_title'))
@section('description', __('site.about.meta_description'))

@php
    $img = config('byward.images');
    $valueIcons = ['check-circle', 'target', 'users', 'globe'];
@endphp

@section('content')

<x-page-hero
    :eyebrow="__('site.about.eyebrow')"
    :title="__('site.about.title')"
    :text="__('site.about.text')"
    :image="$img['hero_about']"
    :current="__('site.nav.about')">
    <a href="{{ route('contact') }}" class="btn btn-brand">{{ __('site.common.get_in_touch') }}</a>
    <a href="{{ route('services') }}" class="btn btn-ghost">{{ __('site.common.view_services') }}</a>
</x-page-hero>

{{-- Stats --}}
<section class="stats-strip">
    <div class="container">
        <div class="stats-card" data-reveal>
            <div class="row g-0">
                @foreach (__('site.about.stats') as $stat)
                    <div class="col-6 col-lg-3 stat-item">
                        <div class="stat-value">
                            <span data-count-to="{{ $stat['value'] }}"
                                  data-count-suffix="{{ $stat['suffix'] }}">0{{ $stat['suffix'] }}</span>
                        </div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Mission --}}
<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 position-relative" data-reveal="left">
                <span class="dot-pattern" style="right:-28px;bottom:-28px"></span>
                <div class="row g-3">
                    <div class="col-7">
                        <div class="media-frame media-tall">
                            <img src="{{ $img['about_team'] }}" alt="" loading="lazy">
                        </div>
                    </div>
                    <div class="col-5 d-flex flex-column gap-3">
                        <div class="media-frame media-square flex-grow-1">
                            <img src="{{ $img['about_ops'] }}" alt="" loading="lazy">
                        </div>
                        <div class="bg-navy rounded-4 p-3 text-center">
                            <div class="stat-value" style="background:linear-gradient(135deg,#fff,#a9c9ff);-webkit-background-clip:text;background-clip:text;color:transparent;font-size:1.9rem">
                                <span>{{ config('byward.company.founded') }}</span>
                            </div>
                            <div class="stat-label mt-1" style="color:rgba(255,255,255,.6)">
                                {{ __('site.about.story_eyebrow') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 ps-lg-5" data-reveal="right">
                <span class="eyebrow">{{ __('site.about.mission_eyebrow') }}</span>
                <h2 class="text-balance">{{ __('site.about.mission_title') }}</h2>
                <p class="lead mt-3">{{ __('site.about.mission_text') }}</p>

                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('quote') }}" class="btn btn-brand">{{ __('site.common.free_quote') }}</a>
                    <a href="{{ route('industries') }}" class="btn btn-outline-navy">{{ __('site.common.all_industries') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="section bg-sand">
    <div class="container">
        <div class="text-center mx-auto mw-720 mb-5" data-reveal>
            <span class="eyebrow eyebrow-center">{{ __('site.about.values_eyebrow') }}</span>
            <h2 class="text-balance">{{ __('site.about.values_title') }}</h2>
        </div>

        <div class="row g-4">
            @foreach (__('site.about.values') as $i => $value)
                <div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="{{ $i * 90 }}">
                    <div class="card-soft">
                        <span class="icon-tile {{ $i % 2 ? 'icon-tile-red' : '' }}">
                            <x-icon :name="$valueIcons[$i]" />
                        </span>
                        <h3 style="font-size:1.15rem">{{ $value['title'] }}</h3>
                        <p class="mb-0 mt-2" style="font-size:.95rem;color:#6b7896">{{ $value['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Timeline --}}
<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4" data-reveal="left">
                <span class="eyebrow">{{ __('site.about.story_eyebrow') }}</span>
                <h2 class="text-balance">{{ __('site.about.story_title') }}</h2>
                <p class="lead mt-3">{{ __('site.about.mission_text') }}</p>
            </div>

            <div class="col-lg-7 offset-lg-1">
                <ul class="timeline">
                    @foreach (__('site.about.timeline') as $i => $entry)
                        <li class="timeline-item" data-reveal="right" data-reveal-delay="{{ $i * 80 }}">
                            <span class="timeline-year" aria-hidden="true">{{ $entry['short'] }}</span>
                            <h4>{{ $entry['year'] }}</h4>
                            <p>{{ $entry['text'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<x-cta-band :title="__('site.about.cta_title')" :text="__('site.about.cta_text')">
    <a href="{{ route('contact') }}" class="btn btn-brand btn-lg">{{ __('site.common.get_in_touch') }}</a>
    <a href="{{ route('services') }}" class="btn btn-ghost btn-lg">{{ __('site.common.view_services') }}</a>
</x-cta-band>

@endsection
