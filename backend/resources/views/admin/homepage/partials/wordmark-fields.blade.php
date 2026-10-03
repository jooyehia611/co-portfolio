@php
    $content = $section->content ?? [];
    $word = \App\Support\Translator::splitForForm($content['word'] ?? $section->title);
    $wordmarkImage = ! empty($content['image_media_id'])
        ? \App\Models\MediaFile::find($content['image_media_id'])
        : null;
@endphp

@include('admin.partials.form-section-start', ['title' => __('admin.fields.wordmark_word'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'word',
    'label' => __('admin.fields.wordmark_word'),
    'value' => $word,
])
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.fields.wordmark_image'), 'icon' => 'media'])
@include('admin.partials.image-upload-field', [
    'current' => $wordmarkImage,
    'inputName' => 'wordmark_image',
    'removeName' => 'remove_wordmark_image',
    'altName' => 'wordmark_image_alt',
    'label' => __('admin.fields.wordmark_image'),
])
@include('admin.partials.form-section-end')
