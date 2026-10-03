@extends('layouts.admin')
@section('title', __('admin.pages.homepage_edit'))
@section('subtitle', $section->section_key)
@php
    $descriptionOnly = ['services', 'projects', 'team', 'business_values'];
    // Fields actually consumed by the React home sections.
    $cmsFields = match ($section->section_key) {
        'services', 'team', 'business_values' => ['title', 'subtitle', 'description'],
        'projects' => ['title'],
        default => ['title', 'subtitle'],
    };
    $multipart = in_array($section->section_key, ['about', 'wordmark', 'clients', 'video'], true);
@endphp
@section('content')
<div class="admin-page admin-form-page-wide">
    <form method="POST" action="{{ route('admin.homepage.update', $section) }}" class="admin-form-shell"@if($multipart) enctype="multipart/form-data"@endif>
        @csrf @method('PUT')
        @if($section->section_key !== 'hero' && (in_array('title', $cmsFields, true) || in_array('subtitle', $cmsFields, true)))
        @include('admin.partials.form-section-start', ['title' => __('admin.nav.homepage'), 'icon' => 'homepage', 'description' => null])
        @if(in_array('title', $cmsFields, true))
        @include('admin.partials.bilingual-field', ['name' => 'title', 'label' => __('admin.fields.title'), 'value' => \App\Support\Translator::splitForForm($section->title)])
        @endif
        @if(in_array('subtitle', $cmsFields, true))
        @include('admin.partials.bilingual-field', ['name' => 'subtitle', 'label' => __('admin.fields.subtitle'), 'value' => \App\Support\Translator::splitForForm($section->subtitle)])
        @endif
        @include('admin.partials.form-section-end')
        @endif

        @if($section->section_key === 'hero')
            @include('admin.homepage.partials.hero-fields', ['section' => $section])
        @elseif($section->section_key === 'about')
            @include('admin.homepage.partials.about-fields', ['section' => $section])
        @elseif($section->section_key === 'process')
            @include('admin.homepage.partials.process-fields', ['section' => $section])
        @elseif($section->section_key === 'wordmark')
            @include('admin.homepage.partials.wordmark-fields', ['section' => $section])
        @elseif($section->section_key === 'cta')
            @include('admin.homepage.partials.cta-fields', ['section' => $section])
        @elseif($section->section_key === 'clients')
            @include('admin.homepage.partials.clients-fields', ['section' => $section])
        @elseif($section->section_key === 'marquee')
            @include('admin.homepage.partials.marquee-fields', ['section' => $section])
        @elseif($section->section_key === 'video')
            @include('admin.homepage.partials.video-fields', ['section' => $section])
        @elseif(in_array($section->section_key, $descriptionOnly, true) && in_array('description', $cmsFields, true))
            @include('admin.homepage.partials.description-fields', ['section' => $section])
        @elseif(! in_array($section->section_key, $descriptionOnly, true) && $section->section_key !== 'hero')
        @include('admin.partials.form-section-start', ['title' => __('admin.fields.content_json'), 'icon' => 'settings', 'description' => null])
        <div class="admin-field"><textarea name="content" rows="8" class="admin-textarea admin-mono" dir="ltr">{{ old('content', json_encode($section->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea></div>
        @include('admin.partials.form-section-end')
        @endif

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.status'), 'icon' => 'settings'])
        <div class="admin-form-grid">
            <label class="admin-toggle"><span class="admin-toggle-label">{{ __('admin.fields.active') }}</span><input type="checkbox" name="is_active" value="1" {{ $section->is_active ? 'checked' : '' }}></label>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.sort_order') }}</label><input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" class="admin-input"></div>
        </div>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-actions', ['backRoute' => route('admin.homepage.index')])
    </form>
</div>
@endsection
