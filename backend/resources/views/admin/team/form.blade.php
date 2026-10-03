@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.team_edit') : __('admin.pages.team_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.team.update', $item) : route('admin.team.store') }}" class="admin-form-shell" enctype="multipart/form-data">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.fields.name'), 'icon' => 'team'])
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.name') }}<span class="admin-required">*</span></label><input type="text" name="name" value="{{ old('name', $item->name) }}" required class="admin-input"></div>
        @include('admin.partials.bilingual-field', ['name' => 'role', 'label' => __('admin.fields.role'), 'value' => \App\Support\Translator::splitForForm($item->role), 'required' => true])
        @include('admin.partials.bilingual-field', ['name' => 'bio', 'label' => __('admin.fields.bio'), 'value' => \App\Support\Translator::splitForForm($item->bio), 'type' => 'textarea', 'rows' => 4])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.photo'), 'icon' => 'media'])
        @include('admin.partials.image-upload-field', [
            'current' => $item->photo,
            'inputName' => 'photo',
            'removeName' => 'remove_photo',
            'altName' => 'photo_alt',
            'label' => __('admin.fields.photo'),
        ])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.email'), 'icon' => 'settings'])
        <div class="admin-form-grid">
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.email') }}</label><input type="email" name="email" value="{{ old('email', $item->email) }}" class="admin-input" dir="ltr"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.linkedin_url') }}</label><input type="url" name="linkedin_url" value="{{ old('linkedin_url', $item->linkedin_url) }}" class="admin-input" dir="ltr"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.github_url') }}</label><input type="url" name="github_url" value="{{ old('github_url', $item->github_url) }}" class="admin-input" dir="ltr"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.sort_order') }}</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="admin-input"></div>
        </div>
        <div class="admin-form-grid">
            <label class="admin-toggle"><span class="admin-toggle-label">{{ __('admin.fields.featured') }}</span><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }}></label>
            <label class="admin-toggle"><span class="admin-toggle-label">{{ __('admin.fields.active') }}</span><input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->exists ? $item->is_active : true) ? 'checked' : '' }}></label>
        </div>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-actions', ['backRoute' => route('admin.team.index')])
    </form>
</div>
@endsection
