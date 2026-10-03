@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.client_edit') : __('admin.pages.client_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.clients.update', $item) : route('admin.clients.store') }}" class="admin-form-shell">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.nav.clients'), 'icon' => 'clients'])
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.name') }}<span class="admin-required">*</span></label><input type="text" name="name" value="{{ old('name', $item->name) }}" required class="admin-input"></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.website') }}</label><input type="url" name="website_url" value="{{ old('website_url', $item->website_url) }}" class="admin-input" dir="ltr"></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.description') }}</label><textarea name="description" rows="3" class="admin-textarea">{{ old('description', $item->description) }}</textarea></div>
        <label class="admin-toggle"><span class="admin-toggle-label">{{ __('admin.fields.featured') }}</span><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }}></label>
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['backRoute' => route('admin.clients.index')])
    </form>
</div>
@endsection
