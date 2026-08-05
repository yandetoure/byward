@extends('layouts.app')

@section('title', __('site.contact.meta_title'))
@section('description', __('site.contact.meta_description'))

@php $img = config('byward.images'); @endphp

@section('content')

<x-page-hero
    :eyebrow="__('site.contact.eyebrow')"
    :title="__('site.contact.title')"
    :text="__('site.contact.text')"
    :image="$img['hero_contact']"
    :current="__('site.nav.contact')" />

<section class="section">
    <div class="container">
        <div class="row g-5">
            {{-- Contact details --}}
            <div class="col-lg-5" data-reveal="left">
                <h2 class="h3 mb-4">{{ __('site.contact.details_title') }}</h2>

                <div class="mb-2">
                    <div class="feature-row">
                        <span class="icon-tile icon-tile-sm"><x-icon name="phone" size="19" /></span>
                        <span>
                            <h4>{{ __('site.contact.label_phone') }}</h4>
                            <a href="tel:{{ config('byward.company.phone_href') }}" class="link-arrow">
                                {{ config('byward.company.phone') }}
                            </a>
                        </span>
                    </div>

                    <div class="feature-row">
                        <span class="icon-tile icon-tile-sm icon-tile-red"><x-icon name="mail" size="19" /></span>
                        <span>
                            <h4>{{ __('site.contact.label_email') }}</h4>
                            <a href="mailto:{{ config('byward.company.email') }}" class="link-arrow">
                                {{ config('byward.company.email') }}
                            </a>
                        </span>
                    </div>

                    <div class="feature-row d-none">
                        <span class="icon-tile icon-tile-sm"><x-icon name="pin" size="19" /></span>
                        <span>
                            <h4>{{ __('site.contact.label_address') }}</h4>
                            <p>{!! nl2br(e(__('site.footer.address'))) !!}</p>
                        </span>
                    </div>

                    <div class="feature-row">
                        <span class="icon-tile icon-tile-sm icon-tile-red"><x-icon name="clock" size="19" /></span>
                        <span>
                            <h4>{{ __('site.contact.label_hours') }}</h4>
                            <p>{{ __('site.contact.hours_value') }}</p>
                        </span>
                    </div>
                </div>

                {{-- Call callout --}}
                <div class="bg-navy rounded-4xl p-4 mt-4 position-relative overflow-hidden">
                    <div class="grid-overlay"></div>
                    <div class="position-relative">
                        <span class="icon-tile icon-tile-light icon-tile-sm mb-3"><x-icon name="support" size="19" /></span>
                        <h3 style="font-size:1.2rem">{{ __('site.contact.call_title') }}</h3>
                        <p class="mb-0 mt-2" style="color:rgba(255,255,255,.7);font-size:.96rem">
                            {!! __('site.contact.call_text', [
                                'appel' => '<a href="tel:'.config('byward.company.phone_href').'" class="text-white fw-semibold">'.config('byward.company.phone').'</a>',
                            ]) !!}
                        </p>
                    </div>
                </div>

                {{-- Estimate callout --}}
                <div class="card-soft mt-4">
                    <span class="icon-tile icon-tile-sm icon-tile-red mb-3"><x-icon name="calculator" size="19" /></span>
                    <h3 style="font-size:1.2rem">{{ __('site.contact.estimate_title') }}</h3>
                    <p class="mt-2" style="font-size:.96rem;color:#6b7896">{{ __('site.contact.estimate_text') }}</p>
                    <a href="{{ route('estimate') }}" class="btn btn-outline-navy btn-sm px-3 py-2">
                        {{ __('site.nav.estimate') }}
                    </a>
                </div>
            </div>

            {{-- Form --}}
            <div class="col-lg-7" id="form" style="scroll-margin-top:calc(var(--by-nav-h) + 24px)" data-reveal="right">
                <div class="form-panel">
                    <h2 class="h3 mb-4">{{ __('site.contact.form_title') }}</h2>

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

                    <form method="POST" action="{{ route('contact.send') }}" data-lock-submit novalidate>
                        @csrf

                        {{-- Honeypot --}}
                        <div class="d-none" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">
                                    {{ __('site.contact.f_name') }} <span class="req">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}"
                                       placeholder="{{ __('site.contact.ph_name') }}" required maxlength="120">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="email">
                                    {{ __('site.contact.f_email') }} <span class="req">*</span>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="{{ __('site.contact.ph_email') }}" required maxlength="180">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="phone">{{ __('site.contact.f_phone') }}</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       value="{{ old('phone') }}" placeholder="{{ __('site.contact.ph_phone') }}"
                                       maxlength="40">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="company">{{ __('site.contact.f_company') }}</label>
                                <input type="text" class="form-control" id="company" name="company"
                                       value="{{ old('company') }}" placeholder="{{ __('site.contact.ph_company') }}"
                                       maxlength="150">
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="message">
                                    {{ __('site.contact.f_message') }} <span class="req">*</span>
                                </label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                          id="message" name="message" required maxlength="4000"
                                          placeholder="{{ __('site.contact.ph_message') }}">{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-3 mt-2">
                                <span class="form-note">
                                    <span class="req">*</span> {{ __('site.common.required_fields') }}
                                </span>
                                <button type="submit" class="btn btn-brand btn-lg"
                                        data-loading-text="{{ __('site.common.sending') }}">
                                    {{ __('site.contact.f_submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
