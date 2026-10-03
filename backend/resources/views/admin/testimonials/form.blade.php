@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.testimonial_edit') : __('admin.pages.testimonial_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.testimonials.update', $item) : route('admin.testimonials.store') }}" class="admin-form-shell">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.fields.client'), 'icon' => 'testimonials'])
        <div class="admin-form-grid">
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.client_name') }}<span class="admin-required">*</span></label><input type="text" name="client_name" value="{{ old('client_name', $item->client_name) }}" required class="admin-input"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.position') }}</label><input type="text" name="client_title" value="{{ old('client_title', $item->client_title) }}" class="admin-input"></div>
        </div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.company') }}</label><input type="text" name="client_company" value="{{ old('client_company', $item->client_company) }}" class="admin-input"></div>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.review'), 'icon' => 'blog'])
        @if($item->audio_path)<div class="admin-field"><label class="admin-label">{{ app()->getLocale() === 'ar' ? 'التسجيل الصوتي' : 'Voice recording' }}</label><audio controls preload="none" src="{{ asset(\Illuminate\Support\Facades\Storage::disk('public')->url($item->audio_path)) }}"></audio></div>@endif
        @include('admin.partials.bilingual-field', ['name' => 'content', 'label' => __('admin.fields.review'), 'value' => \App\Support\Translator::splitForForm($item->content), 'type' => 'textarea', 'rows' => 4, 'required' => ! $item->audio_path])
        <div class="admin-form-grid">
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.rating') }}</label><input type="number" name="rating" min="1" max="5" value="{{ old('rating', $item->rating ?? 5) }}" class="admin-input"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.status') }}</label><select name="status" class="admin-select">@foreach($statuses as $s)<option value="{{ $s->value }}" {{ old('status', $item->status?->value) == $s->value ? 'selected' : '' }}>{{ $s->label() }}</option>@endforeach</select></div>
        </div>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-actions', ['backRoute' => route('admin.testimonials.index')])
    </form>
</div>
@endsection
