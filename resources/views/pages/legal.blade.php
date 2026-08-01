@extends('layouts.app')

@section('title', __("site.legal.{$doc}.meta_title"))
@section('description', __("site.legal.{$doc}.intro"))

@php $content = __("site.legal.{$doc}"); @endphp

@section('content')

<x-page-hero
    :title="$content['title']"
    :text="$content['intro']"
    :current="$content['title']" />

<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="position-sticky" style="top:calc(var(--by-nav-h) + 24px)" data-reveal="left">
                    <p class="form-note mb-3">
                        {{ __('site.legal.updated') }}
                        {{ \Carbon\Carbon::create(2026, 1, 1)->locale(app()->getLocale())->isoFormat('LL') }}
                    </p>

                    <ul class="footer-links" style="gap:.55rem">
                        @foreach ($content['sections'] as $i => $section)
                            <li>
                                <a href="#s{{ $i }}" class="link-arrow">
                                    <x-icon name="chevron-right" size="15" />
                                    {{ $section['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="alert-by alert-err mt-4">
                        <x-icon name="info" size="20" />
                        <span>{{ __('site.legal.placeholder_note') }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                @foreach ($content['sections'] as $i => $section)
                    <div class="mb-5" id="s{{ $i }}"
                         style="scroll-margin-top:calc(var(--by-nav-h) + 24px)"
                         data-reveal data-reveal-delay="{{ min($i * 50, 250) }}">
                        <h2 class="h3 mb-3">{{ $section['title'] }}</h2>
                        <p class="mb-0">{{ $section['text'] }}</p>
                    </div>
                @endforeach

                <div class="divider-line my-5"></div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-navy">{{ __('site.common.get_in_touch') }}</a>
                    <a href="{{ route($doc === 'privacy' ? 'terms' : 'privacy') }}" class="btn btn-outline-navy">
                        {{ $doc === 'privacy' ? __('site.footer.terms') : __('site.footer.privacy') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
