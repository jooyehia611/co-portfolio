@extends('layouts.admin')

@section('title', __('admin.auth.login_title'))

@section('content')
<div class="admin-login-page">
    <div class="admin-login-brand">
        <div class="admin-login-brand-content">
            <img src="{{ asset('brand/logo-stacked.png') }}" alt="Y-TECH" class="admin-login-brand-image">
            <p>{{ __('admin.auth.login_tagline') }}</p>
        </div>
    </div>
    <div class="admin-login-form-side">
        <div class="admin-login-lang">
            <a href="{{ route('admin.locale.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
            <a href="{{ route('admin.locale.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        </div>
        <div class="admin-login-card">
            <h3>{{ __('admin.auth.login_title') }}</h3>
            <p class="subtitle">{{ __('admin.auth.login_subtitle') }}</p>
            @include('admin.partials.flash')
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="admin-field">
                    <label class="admin-label">{{ __('admin.fields.email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required dir="ltr" class="admin-input" placeholder="admin@ytech.com">
                </div>
                <div class="admin-field">
                    <label class="admin-label">{{ __('admin.fields.password') }}</label>
                    <input type="password" name="password" required dir="ltr" class="admin-input" placeholder="••••••••">
                </div>
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-lg" style="width:100%;margin-top:0.5rem;">
                    @include('admin.partials.icon', ['name' => 'save', 'class' => 'admin-btn-icon'])
                    {{ __('admin.actions.sign_in') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
