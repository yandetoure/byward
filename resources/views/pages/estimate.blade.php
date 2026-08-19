@extends('layouts.app')

@section('title', __('site.estimate.meta_title'))
@section('description', __('site.estimate.meta_description'))

@php
    $img = config('byward.images');
    $methods = __('site.estimate.methods');
    $result = session('estimate');
@endphp

@section('content')

<x-page-hero
    :eyebrow="__('site.estimate.eyebrow')"
    :title="__('site.estimate.title')"
    :text="__('site.estimate.text')"
    :image="$img['estimate_teaser']"
    :current="__('site.nav.estimate')" />

<section class="section">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-7">
                <div class="form-panel" data-reveal>
                    @if ($errors->any())
                        <div class="alert-by alert-err mb-4" role="alert">
                            <x-icon name="alert" size="20" />
                            <span>
                                <strong class="d-block mb-1">{{ __('site.errors.form_title') }}</strong>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('estimate.calculate') }}" data-lock-submit novalidate>
                        @csrf

                        <div class="row g-3">
                            <!-- Origin (Pickup Location) -->
                            <div class="col-lg-6">
                                <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                            <x-icon name="pin" size="14" />
                                        </div>
                                        <h3 class="mb-0 h6 fw-bold text-navy">{{ __('site.estimate.sec_origin') }}</h3>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label" for="origin_street">
                                                {{ __('site.estimate.f_street') }} <span class="req">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="origin_street" name="origin_street"
                                                   value="{{ old('origin_street') }}"
                                                   placeholder="{{ __('site.estimate.ph_street') }}" required maxlength="150">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="origin_city">
                                                {{ __('site.estimate.f_city') }} <span class="req">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="origin_city" name="origin_city"
                                                   value="{{ old('origin_city') }}"
                                                   placeholder="{{ __('site.estimate.ph_city') }}" required maxlength="100">
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-label" for="origin_province">
                                                {{ __('site.estimate.f_province') }} <span class="req">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="origin_province" name="origin_province"
                                                   value="{{ old('origin_province') }}"
                                                   placeholder="{{ __('site.estimate.ph_province') }}" required maxlength="100">
                                        </div>
                                        <div class="col-sm-5">
                                            <label class="form-label" for="origin_postal_code">
                                                {{ __('site.estimate.f_postal_code') }} <span class="req">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="origin_postal_code" name="origin_postal_code"
                                                   value="{{ old('origin_postal_code') }}"
                                                   placeholder="{{ __('site.estimate.ph_postal_code') }}" required maxlength="20">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Destination (Delivery Location) -->
                            <div class="col-lg-6">
                                <div class="p-3 bg-light rounded-4 border border-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary text-white rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                            <x-icon name="pin" size="14" />
                                        </div>
                                        <h3 class="mb-0 h6 fw-bold text-navy">{{ __('site.estimate.sec_destination') }}</h3>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label" for="destination_street">
                                                {{ __('site.estimate.f_street') }} <span class="req">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="destination_street" name="destination_street"
                                                   value="{{ old('destination_street') }}"
                                                   placeholder="{{ __('site.estimate.ph_street') }}" required maxlength="150">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="destination_city">
                                                {{ __('site.estimate.f_city') }} <span class="req">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="destination_city" name="destination_city"
                                                   value="{{ old('destination_city') }}"
                                                   placeholder="{{ __('site.estimate.ph_city') }}" required maxlength="100">
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="form-label" for="destination_province">
                                                {{ __('site.estimate.f_province') }} <span class="req">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="destination_province" name="destination_province"
                                                   value="{{ old('destination_province') }}"
                                                   placeholder="{{ __('site.estimate.ph_province') }}" required maxlength="100">
                                        </div>
                                        <div class="col-sm-5">
                                            <label class="form-label" for="destination_postal_code">
                                                {{ __('site.estimate.f_postal_code') }} <span class="req">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="destination_postal_code" name="destination_postal_code"
                                                   value="{{ old('destination_postal_code') }}"
                                                   placeholder="{{ __('site.estimate.ph_postal_code') }}" required maxlength="20">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <label class="form-label" for="method">
                                    {{ __('site.estimate.f_method') }} <span class="req">*</span>
                                </label>
                                <select class="form-select" id="method" name="method" required>
                                    <option value="" disabled {{ old('method') ? '' : 'selected' }}>
                                        {{ __('site.estimate.ph_method') }}
                                    </option>
                                    @foreach ($methods as $key => $label)
                                        <option value="{{ $key }}" @selected(old('method') === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label" for="weight">
                                    {{ __('site.estimate.f_weight') }} <span class="req">*</span>
                                </label>
                                <div class="position-relative">
                                    <input type="number" step="0.1" min="0.1" class="form-control pe-5"
                                           id="weight" name="weight" value="{{ old('weight') }}"
                                           placeholder="{{ __('site.estimate.ph_weight') }}" required>
                                    <span class="input-suffix">kg</span>
                                </div>
                            </div>

                            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-3 mt-2">
                                <span class="form-note">
                                    <span class="req">*</span> {{ __('site.common.required_fields') }}
                                </span>
                                <button type="submit" class="btn btn-brand btn-lg"
                                        data-loading-text="{{ __('site.common.sending') }}">
                                    {{ __('site.common.calculate') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Result --}}
                    @if ($result)
                        <div class="estimate-result mt-4" id="result" style="scroll-margin-top:calc(var(--by-nav-h) + 24px)">
                            <span class="eyebrow eyebrow-light">{{ __('site.estimate.result_title') }}</span>

                            <div class="row g-4 align-items-end">
                                <div class="col-sm-6">
                                    <div class="stat-label mb-1" style="color:rgba(255,255,255,.55);margin-top:0">
                                        {{ __('site.estimate.result_price') }}
                                    </div>
                                    <div class="estimate-figure">{{ $result['price'] }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="stat-label mb-1" style="color:rgba(255,255,255,.55);margin-top:0">
                                        {{ __('site.estimate.result_transit') }}
                                    </div>
                                    <div class="h4 mb-0 text-white">
                                        {{ __('site.estimate.result_days', ['min' => $result['days_min'], 'max' => $result['days_max']]) }}
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color:rgba(255,255,255,.15);margin:1.4rem 0">

                            <div class="estimate-meta">
                                <span><strong class="text-white">{{ __('site.estimate.result_route') }} :</strong>
                                    {{ $result['origin'] }} → {{ $result['destination'] }}</span>
                                @php
                                    $fr = app()->getLocale() === 'fr';
                                @endphp
                                @if (isset($result['distance']))
                                    <span><strong class="text-white">{{ __('site.estimate.result_distance') }} :</strong>
                                        {{ number_format($result['distance'], 0, $fr ? ',' : '.', $fr ? ' ' : ',') }} km</span>
                                @endif
                                @php
                                    $weight = rtrim(rtrim(
                                        number_format($result['weight'], 1, $fr ? ',' : '.', $fr ? ' ' : ','),
                                        '0'
                                    ), $fr ? ',' : '.');
                                @endphp
                                <span><strong class="text-white">{{ __('site.estimate.result_weight') }} :</strong>
                                    {{ $weight }} kg</span>
                                <span><strong class="text-white">{{ __('site.estimate.result_method') }} :</strong>
                                    {{ $methods[$result['method']] }}</span>
                            </div>

                            <p class="mt-3 mb-0" style="font-size:.83rem;color:rgba(255,255,255,.5)">
                                {{ __('site.estimate.result_disclaimer') }}
                            </p>

                            <a href="{{ route('quote') }}" class="btn btn-brand mt-4">
                                {{ __('site.estimate.ask_full') }}
                            </a>
                        </div>
                    @endif

                    @unless ($result)
                        <div class="d-flex flex-wrap align-items-center gap-2 mt-4 pt-4"
                             style="border-top:1px solid var(--by-line)">
                            <span class="text-muted-2" style="font-size:.94rem">{{ __('site.estimate.ready') }}</span>
                            <a href="{{ route('quote') }}" class="link-arrow">
                                {{ __('site.estimate.ask_full') }}
                                <x-icon name="arrow-right" size="16" />
                            </a>
                        </div>
                    @endunless
                </div>
            </div>

            {{-- Aside --}}
            <div class="col-lg-5" data-reveal="right">
                <div class="media-frame media-wide mb-4">
                    <img src="{{ $img['why_alt'] }}" alt="" loading="lazy">
                </div>

                <div class="card-soft">
                    <span class="icon-tile icon-tile-sm icon-tile-red mb-3"><x-icon name="info" size="19" /></span>
                    <h3 style="font-size:1.15rem">{{ __('site.quote.aside_title') }}</h3>
                    <ul class="check-list mt-3">
                        @foreach (__('site.quote.aside_steps') as $step)
                            <li>
                                <span class="tick"><x-icon name="check" size="12" /></span>
                                {{ $step }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<x-cta-band :title="__('site.services.cta_title')" :text="__('site.services.cta_text')">
    <a href="{{ route('quote') }}" class="btn btn-brand btn-lg">{{ __('site.common.free_quote') }}</a>
    <a href="{{ route('contact') }}" class="btn btn-ghost btn-lg">{{ __('site.common.talk_expert') }}</a>
</x-cta-band>

@endsection
