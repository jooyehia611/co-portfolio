@php
    $content = $section->content ?? [];
    $field = fn (string $key) => \App\Support\Translator::splitForForm($content[$key] ?? '');
    $imageOne = ! empty($content['image_media_id'])
        ? \App\Models\MediaFile::find($content['image_media_id'])
        : null;
    $imageTwo = ! empty($content['image_two_media_id'])
        ? \App\Models\MediaFile::find($content['image_two_media_id'])
        : null;
@endphp

@include('admin.partials.form-section-start', ['title' => __('admin.fields.description'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'description',
    'label' => __('admin.fields.description'),
    'value' => $field('description'),
    'type' => 'textarea',
    'rows' => 4,
])
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.fields.about_facts'), 'icon' => 'statistics'])
<div class="admin-form-grid">
    <div class="admin-field">
        <label class="admin-label">{{ __('admin.fields.years_count') }}</label>
        <input type="text" name="years_count" value="{{ old('years_count', $content['years_count'] ?? '') }}" class="admin-input" dir="ltr">
    </div>
    <div class="admin-field">
        <label class="admin-label">{{ __('admin.fields.since_year') }}</label>
        <input type="text" name="since_year" value="{{ old('since_year', $content['since_year'] ?? '') }}" class="admin-input" dir="ltr">
    </div>
    <div class="admin-field">
        <label class="admin-label">{{ __('admin.fields.progress_value') }}</label>
        <input type="number" name="progress_value" value="{{ old('progress_value', $content['progress_value'] ?? '') }}" class="admin-input" min="0" max="100">
    </div>
</div>
@include('admin.partials.bilingual-field', [
    'name' => 'progress_text',
    'label' => __('admin.fields.progress_text'),
    'value' => $field('progress_text'),
    'type' => 'textarea',
    'rows' => 2,
])
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.fields.cta_section'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'cta_label',
    'label' => __('admin.fields.cta_label'),
    'value' => $field('cta_label'),
])
<div class="admin-field">
    <label class="admin-label">{{ __('admin.fields.cta_url') }}</label>
    <input type="text" name="cta_url" value="{{ old('cta_url', $content['cta_url'] ?? '/about') }}" class="admin-input" dir="ltr">
</div>
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.fields.about_images'), 'icon' => 'media'])
@include('admin.partials.image-upload-field', [
    'current' => $imageOne,
    'inputName' => 'about_image',
    'removeName' => 'remove_about_image',
    'altName' => 'about_image_alt',
    'label' => __('admin.fields.about_image_one'),
])
@include('admin.partials.image-upload-field', [
    'current' => $imageTwo,
    'inputName' => 'about_image_two',
    'removeName' => 'remove_about_image_two',
    'altName' => 'about_image_two_alt',
    'label' => __('admin.fields.about_image_two'),
])
@include('admin.partials.form-section-end')
