@extends('layouts.admin')
@section('title', __('admin.pages.seo_edit'))
@section('subtitle', $item->page_key)
@section('content')
<div class="admin-page admin-form-page-wide">
    <form method="POST" action="{{ route('admin.seo.update', $item) }}" class="admin-form-shell">
        @csrf @method('PUT')
        @include('admin.partials.form-section-start', ['title' => __('admin.seo.page_content'), 'icon' => 'edit'])
        @include('admin.partials.bilingual-field', ['name' => 'page_title', 'label' => __('admin.fields.page_title'), 'value' => \App\Support\Translator::splitForForm($item->page_title)])
        @include('admin.partials.bilingual-field', ['name' => 'page_description', 'label' => __('admin.fields.page_description'), 'value' => \App\Support\Translator::splitForForm($item->page_description), 'type' => 'textarea', 'rows' => 3])
        <p class="admin-help" style="margin:0 1.5rem 1.25rem;">{{ __('admin.seo.page_content_help') }}</p>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.nav.seo'), 'icon' => 'seo'])
        @include('admin.partials.bilingual-field', ['name' => 'meta_title', 'label' => __('admin.fields.meta_title'), 'value' => \App\Support\Translator::splitForForm($item->meta_title)])
        @include('admin.partials.bilingual-field', ['name' => 'meta_description', 'label' => __('admin.fields.meta_description'), 'value' => \App\Support\Translator::splitForForm($item->meta_description), 'type' => 'textarea', 'rows' => 3])
        @include('admin.partials.bilingual-field', ['name' => 'og_title', 'label' => __('admin.fields.og_title'), 'value' => \App\Support\Translator::splitForForm($item->og_title)])
        @include('admin.partials.bilingual-field', ['name' => 'og_description', 'label' => __('admin.fields.og_description'), 'value' => \App\Support\Translator::splitForForm($item->og_description), 'type' => 'textarea', 'rows' => 3])
        <label class="admin-toggle"><span class="admin-toggle-label">{{ __('admin.fields.indexable') }}</span><input type="checkbox" name="is_indexable" value="1" {{ $item->is_indexable ? 'checked' : '' }}></label>
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['backRoute' => route('admin.seo.index')])
    </form>
</div>
@endsection
