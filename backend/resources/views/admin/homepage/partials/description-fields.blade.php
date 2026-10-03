@php
    $content = $section->content ?? [];
    $descriptionValue = \App\Support\Translator::splitForForm($content['description'] ?? '');
@endphp

@include('admin.partials.form-section-start', [
    'title' => __('admin.fields.description'),
    'icon' => 'edit',
    'description' => null,
])
@include('admin.partials.bilingual-field', [
    'name' => 'description',
    'label' => __('admin.fields.description'),
    'value' => $descriptionValue,
    'type' => 'textarea',
    'rows' => 3,
])
@include('admin.partials.form-section-end')
