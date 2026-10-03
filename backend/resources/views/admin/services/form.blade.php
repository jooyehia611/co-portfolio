@extends('layouts.admin')

@section('title', $item->exists ? __('admin.pages.service_edit') : __('admin.pages.service_create'))

@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.services.update', $item) : route('admin.services.store') }}" class="admin-form-shell" enctype="multipart/form-data">
        @csrf @if($item->exists) @method('PUT') @endif

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.title'), 'description' => __('admin.fields.short_description'), 'icon' => 'services'])
        @include('admin.partials.bilingual-field', ['name' => 'title', 'label' => __('admin.fields.title'), 'value' => \App\Support\Translator::splitForForm($item->title), 'required' => true])
        @include('admin.partials.bilingual-field', ['name' => 'short_description', 'label' => __('admin.fields.short_description'), 'value' => \App\Support\Translator::splitForForm($item->short_description), 'type' => 'textarea', 'rows' => 2])
        @include('admin.partials.bilingual-field', ['name' => 'description', 'label' => __('admin.fields.description'), 'value' => \App\Support\Translator::splitForForm($item->description), 'type' => 'textarea', 'rows' => 5])
        @include('admin.partials.form-section-end')

        @php
            $listLines = function (?array $value, string $locale): string {
                $items = is_array($value[$locale] ?? null) ? $value[$locale] : [];
                return implode("\n", array_map('strval', $items));
            };
        @endphp
        @include('admin.partials.form-section-start', ['title' => __('admin.fields.service_lists'), 'icon' => 'services'])
        <p class="admin-help" style="margin-bottom: 1rem;">{{ __('admin.fields.service_lists_help') }}</p>
        @include('admin.partials.bilingual-field', [
            'name' => 'capabilities',
            'label' => __('admin.fields.service_capabilities'),
            'value' => [
                'ar' => $listLines($item->capabilities, 'ar'),
                'en' => $listLines($item->capabilities, 'en'),
            ],
            'type' => 'textarea',
            'rows' => 5,
        ])
        @include('admin.partials.bilingual-field', [
            'name' => 'business_problems',
            'label' => __('admin.fields.service_problems'),
            'value' => [
                'ar' => $listLines($item->business_problems, 'ar'),
                'en' => $listLines($item->business_problems, 'en'),
            ],
            'type' => 'textarea',
            'rows' => 4,
        ])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.featured_image'), 'icon' => 'media'])
        @include('admin.partials.image-upload-field', [
            'current' => $item->featuredImage,
            'inputName' => 'featured_image',
            'removeName' => 'remove_featured_image',
            'altName' => 'featured_image_alt',
            'label' => __('admin.fields.featured_image'),
        ])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.status'), 'icon' => 'settings'])
        <div class="admin-form-grid">
            <div class="admin-field">
                <label class="admin-label">{{ __('admin.fields.icon') }}</label>
                <input type="text" name="icon" value="{{ old('icon', $item->icon) }}" class="admin-input" placeholder="code, globe, smartphone...">
            </div>
            <div class="admin-field">
                <label class="admin-label">{{ __('admin.fields.status') }}</label>
                <select name="status" class="admin-select">
                    @foreach($statuses as $s)
                    <option value="{{ $s->value }}" {{ old('status', $item->status?->value) == $s->value ? 'selected' : '' }}>{{ $s->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="admin-form-grid">
            <label class="admin-toggle">
                <span class="admin-toggle-label">{{ __('admin.fields.featured') }}</span>
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }}>
            </label>
            <div class="admin-field">
                <label class="admin-label">{{ __('admin.fields.sort_order') }}</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="admin-input">
            </div>
        </div>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.nav.seo'), 'icon' => 'seo'])
        @include('admin.partials.bilingual-field', ['name' => 'meta_title', 'label' => __('admin.fields.meta_title'), 'value' => \App\Support\Translator::splitForForm($item->meta_title)])
        @include('admin.partials.bilingual-field', ['name' => 'meta_description', 'label' => __('admin.fields.meta_description'), 'value' => \App\Support\Translator::splitForForm($item->meta_description), 'type' => 'textarea', 'rows' => 2])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-actions', ['backRoute' => route('admin.services.index')])
    </form>
</div>
@endsection
