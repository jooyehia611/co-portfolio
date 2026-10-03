@php
    $content = $section->content ?? [];
    $videoImage = ! empty($content['image_media_id'])
        ? \App\Models\MediaFile::find($content['image_media_id'])
        : null;
@endphp

@include('admin.partials.form-section-start', ['title' => __('admin.fields.video_url'), 'icon' => 'edit'])
<div class="admin-field">
    <label class="admin-label">{{ __('admin.fields.video_url') }}</label>
    <input type="text" name="video_url" value="{{ old('video_url', $content['video_url'] ?? '') }}" class="admin-input" dir="ltr" placeholder="/media/hero/ytech-showreel.mp4">
</div>
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.fields.video_poster'), 'icon' => 'media'])
@include('admin.partials.image-upload-field', [
    'current' => $videoImage,
    'inputName' => 'video_image',
    'removeName' => 'remove_video_image',
    'altName' => 'video_image_alt',
    'label' => __('admin.fields.video_poster'),
])
@include('admin.partials.form-section-end')
