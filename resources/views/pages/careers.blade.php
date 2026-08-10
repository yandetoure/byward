@extends('layouts.app')

@section('title', __('site.careers.meta_title'))
@section('description', __('site.careers.meta_description'))

@section('content')
<section class="page-header position-relative overflow-hidden pt-5 pb-5 bg-navy text-white text-center">
    <div class="glow glow-red" style="width:500px;height:500px;top:-200px;right:-100px;opacity:.2"></div>
    <div class="glow glow-blue" style="width:400px;height:400px;bottom:-100px;left:-100px;opacity:.2"></div>
    
    <div class="container position-relative z-1 pt-5">
        <h1 class="display-3 fw-bold text-balance mb-3">{{ __('site.careers.hero_title') }}</h1>
        <p class="lead mb-0 text-white-50 text-balance mx-auto" style="max-width: 600px;">
            {{ __('site.careers.hero_text') }}
        </p>
    </div>
</section>

<section class="section py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 pe-lg-5">
                <h2 class="mb-4">{{ __('site.careers.benefits_title') }}</h2>
                <div class="d-flex flex-column gap-4">
                    @foreach(__('site.careers.benefits') as $benefit)
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 text-brand">
                                <x-icon name="check-circle" size="24" />
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $benefit['title'] }}</h5>
                                <p class="mb-0 text-muted">{{ $benefit['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-7" id="form">
                <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5">
                    @if (session('status'))
                        <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                            <x-icon name="check-circle" class="me-2 flex-shrink-0" size="24" />
                            <div>{{ session('status') }}</div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <x-icon name="alert-circle" class="me-2" size="20" />
                                <strong>{{ __('site.errors.form_title') }}</strong>
                            </div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h3 class="mb-4">{{ __('site.careers.form_title') }}</h3>
                    <form action="{{ route('careers.send') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Honeypot -->
                        <div style="display:none">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">{{ __('site.careers.f_name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('site.careers.ph_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">{{ __('site.careers.f_email') }} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('site.careers.ph_email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">{{ __('site.careers.f_phone') }}</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="{{ __('site.careers.ph_phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="position" class="form-label">{{ __('site.careers.f_position') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="position" name="position" required>
                                    <option value="" disabled {{ old('position') ? '' : 'selected' }}>{{ __('site.careers.f_position') }}</option>
                                    @foreach(__('site.careers.positions') as $val => $label)
                                        <option value="{{ $val }}" {{ old('position') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="resume" class="form-label">{{ __('site.careers.f_resume') }} <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">{{ __('site.careers.f_message') }}</label>
                                <textarea class="form-control" id="message" name="message" rows="4" placeholder="{{ __('site.careers.ph_message') }}">{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-brand btn-lg w-100" data-submit-text="{{ __('site.common.sending') }}">
                                    {{ __('site.careers.f_submit') }}
                                </button>
                                <p class="text-muted small mt-2 mb-0">{{ __('site.common.required_fields') }} (<span class="text-danger">*</span>)</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
