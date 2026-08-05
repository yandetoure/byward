@extends('layouts.app')

@section('title', __('site.quote.meta_title'))
@section('description', __('site.quote.meta_description'))

@php
    $img = config('byward.images');
    $types = __('site.estimate.methods');
@endphp

@section('content')

<x-page-hero
    :eyebrow="__('site.quote.eyebrow')"
    :title="__('site.quote.title')"
    :text="__('site.quote.text')"
    :image="$img['hero_quote']"
    :current="__('site.nav.quote')" />

<section class="section">
    <div class="container">
        <div class="row g-5">
            {{-- Form --}}
            <div class="col-lg-8" id="form" style="scroll-margin-top:calc(var(--by-nav-h) + 24px)" data-reveal="left">
                <div class="form-panel">

                    @if (session('status'))
                        <div class="alert-by alert-ok mb-4" role="status">
                            <x-icon name="check-circle" size="20" />
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

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

                    <form method="POST" action="{{ route('quote.send') }}" data-lock-submit novalidate>
                        @csrf

                        <div class="d-none" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        {{-- Contact --}}
                        <h2 class="h4 mb-3">{{ __('site.quote.sec_contact') }}</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">
                                    {{ __('site.quote.f_name') }} <span class="req">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                       placeholder="{{ __('site.quote.ph_name') }}" required maxlength="120">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">
                                    {{ __('site.quote.f_email') }} <span class="req">*</span>
                                </label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                       placeholder="{{ __('site.quote.ph_email') }}" required maxlength="180">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">
                                    {{ __('site.quote.f_phone') }} <span class="req">*</span>
                                </label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                                       placeholder="{{ __('site.quote.ph_phone') }}" required maxlength="40">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="company">{{ __('site.quote.f_company') }}</label>
                                <input type="text" class="form-control" id="company" name="company"
                                       value="{{ old('company') }}" placeholder="{{ __('site.quote.ph_company') }}"
                                       maxlength="150">
                            </div>
                        </div>

                        {{-- Shipment --}}
                        <h2 class="h4 mb-3 mt-5">{{ __('site.quote.sec_shipment') }}</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="origin">
                                    {{ __('site.quote.f_origin') }} <span class="req">*</span>
                                </label>
                                <select class="form-select" id="origin" name="origin" required>
                                    <option value="" disabled {{ old('origin') ? '' : 'selected' }}>{{ __('site.quote.ph_region') }}</option>
                                    @foreach (__('site.quote.regions') as $code => $region)
                                        <option value="{{ $region }}" @selected(old('origin') === $region)>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="destination">
                                    {{ __('site.quote.f_destination') }} <span class="req">*</span>
                                </label>
                                <select class="form-select" id="destination" name="destination" required>
                                    <option value="" disabled {{ old('destination') ? '' : 'selected' }}>{{ __('site.quote.ph_region') }}</option>
                                    @foreach (__('site.quote.regions') as $code => $region)
                                        <option value="{{ $region }}" @selected(old('destination') === $region)>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label" for="shipment_type">
                                    {{ __('site.quote.f_type') }} <span class="req">*</span>
                                </label>
                                <select class="form-select" id="shipment_type" name="shipment_type" required>
                                    <option value="" disabled {{ old('shipment_type') ? '' : 'selected' }}>
                                        {{ __('site.quote.ph_type') }}
                                    </option>
                                    @foreach ($types as $key => $label)
                                        <option value="{{ $key }}" @selected(old('shipment_type') === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" for="weight">
                                    {{ __('site.quote.f_weight') }} <span class="req">*</span>
                                </label>
                                <div class="position-relative">
                                    <input type="number" step="0.1" min="0.1" class="form-control pe-5" id="weight"
                                           name="weight" value="{{ old('weight') }}"
                                           placeholder="{{ __('site.quote.ph_weight') }}" required>
                                    <span class="input-suffix">kg</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('site.quote.f_dimensions') }}</label>
                                <div class="row g-2">
                                    @foreach (['length' => 120, 'width' => 80, 'height' => 60] as $dim => $ph)
                                        <div class="col-4">
                                            <input type="number" step="0.1" min="0" class="form-control"
                                                   id="{{ $dim }}" name="{{ $dim }}" value="{{ old($dim) }}"
                                                   placeholder="{{ __('site.quote.f_'.$dim) }} — {{ $ph }}"
                                                   aria-label="{{ __('site.quote.f_'.$dim) }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Extras --}}
                        <h2 class="h4 mb-3 mt-5">{{ __('site.quote.sec_extra') }}</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="pickup_date">{{ __('site.quote.f_pickup') }}</label>
                                <input type="date" class="form-control" id="pickup_date" name="pickup_date"
                                       value="{{ old('pickup_date') }}" min="{{ now()->toDateString() }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="message">{{ __('site.quote.f_notes') }}</label>
                                <textarea class="form-control" id="message" name="message" maxlength="4000"
                                          placeholder="{{ __('site.quote.ph_notes') }}">{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-3 mt-2">
                                <span class="form-note">
                                    <span class="req">*</span> {{ __('site.common.required_fields') }}
                                </span>
                                <button type="submit" class="btn btn-brand btn-lg"
                                        data-loading-text="{{ __('site.common.sending') }}">
                                    {{ __('site.quote.f_submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Aside --}}
            <div class="col-lg-4" data-reveal="right">
                <div class="position-sticky" style="top:calc(var(--by-nav-h) + 24px)">
                    <div class="bg-navy rounded-4xl p-4 position-relative overflow-hidden">
                        <div class="grid-overlay"></div>
                        <div class="position-relative">
                            <span class="eyebrow eyebrow-light">{{ __('site.quote.eyebrow') }}</span>
                            <h3 style="font-size:1.25rem">{{ __('site.quote.aside_title') }}</h3>

                            <ul class="check-list check-list-light mt-3">
                                @foreach (__('site.quote.aside_steps') as $step)
                                    <li>
                                        <span class="tick"><x-icon name="check" size="12" /></span>
                                        {{ $step }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card-soft mt-4">
                        <span class="icon-tile icon-tile-sm icon-tile-red mb-3"><x-icon name="calculator" size="19" /></span>
                        <h4>{{ __('site.quote.aside_note') }}</h4>
                        <p class="mt-2 mb-3" style="font-size:.94rem;color:#6b7896">
                            {{ __('site.contact.estimate_text') }}
                        </p>
                        <a href="{{ route('estimate') }}" class="btn btn-outline-navy btn-sm px-3 py-2">
                            {{ __('site.nav.estimate') }}
                        </a>
                    </div>

                    <div class="card-soft mt-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="icon-tile icon-tile-sm"><x-icon name="phone" size="18" /></span>
                            <span>
                                <strong class="d-block" style="font-size:.9rem;color:var(--by-navy-800)">
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
        </div>
    </div>
</section>

@endsection
