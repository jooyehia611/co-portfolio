@php
    $content = $section->content ?? [];
    $field = fn (string $key) => \App\Support\Translator::splitForForm($content[$key] ?? '');
@endphp

@include('admin.partials.form-section-start', ['title' => __('admin.fields.description'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'description',
    'label' => __('admin.fields.description'),
    'value' => $field('description'),
    'type' => 'textarea',
    'rows' => 3,
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
