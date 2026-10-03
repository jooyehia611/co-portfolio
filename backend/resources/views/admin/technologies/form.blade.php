@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.technology_edit') : __('admin.pages.technology_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.technologies.update', $item) : route('admin.technologies.store') }}" class="admin-form-shell">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.nav.technologies'), 'icon' => 'technologies'])
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.name') }}<span class="admin-required">*</span></label><input type="text" name="name" value="{{ old('name', $item->name) }}" required class="admin-input"></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.icon') }}</label><input type="text" name="icon" value="{{ old('icon', $item->icon) }}" class="admin-input"></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.description') }}</label><textarea name="description" rows="3" class="admin-textarea">{{ old('description', $item->description) }}</textarea></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.sort_order') }}</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="admin-input"></div>
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['backRoute' => route('admin.technologies.index')])
    </form>
</div>
@endsection
