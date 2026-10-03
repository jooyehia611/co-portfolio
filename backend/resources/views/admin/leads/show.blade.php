@extends('layouts.admin')

@section('title', __('admin.pages.lead_show'))
@section('subtitle', $lead->name)

@section('content')
<div class="admin-page admin-form-page">
    <div class="admin-form-shell" style="margin-bottom:1rem;">
        @include('admin.partials.form-section-start', ['title' => __('admin.pages.lead_show'), 'icon' => 'leads'])
        <div class="admin-detail-list">
            <p><strong>{{ __('admin.fields.email') }}</strong> <span dir="ltr" class="admin-mono">{{ $lead->email }}</span></p>
            <p><strong>{{ __('admin.fields.phone') }}</strong> {{ $lead->phone ?? __('admin.common.not_available') }}</p>
            <p><strong>{{ __('admin.fields.company') }}</strong> {{ $lead->company ?? __('admin.common.not_available') }}</p>
            <p><strong>{{ __('admin.nav.services') }}</strong> {{ $lead->service?->translate('title') ?? __('admin.common.not_available') }}</p>
            <p style="margin-top:1rem;"><strong>{{ __('admin.fields.message') }}</strong></p>
            <p style="white-space:pre-wrap;margin-top:0.5rem;padding:1rem;background:#fafbfc;border-radius:10px;border:1.5px solid var(--admin-border-light);">{{ $lead->message }}</p>
        </div>
        @include('admin.partials.form-section-end')
    </div>

    <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="admin-form-shell">
        @csrf @method('PUT')
        @include('admin.partials.form-section-start', ['title' => __('admin.fields.status'), 'icon' => 'settings'])
        <div class="admin-field">
            <label class="admin-label">{{ __('admin.fields.status') }}</label>
            <select name="status" class="admin-select">
                @foreach(\App\Enums\LeadStatus::cases() as $s)
                <option value="{{ $s->value }}" {{ $lead->status == $s ? 'selected' : '' }}>{{ $s->label() }}</option>
                @endforeach
            </select>
        </div>
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['label' => __('admin.actions.update_status'), 'backRoute' => route('admin.leads.index')])
    </form>
</div>
@endsection
