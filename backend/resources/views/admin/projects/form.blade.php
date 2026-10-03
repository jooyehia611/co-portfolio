@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.project_edit') : __('admin.pages.project_create'))
@section('content')
<div class="admin-page admin-form-page-wide">
    <form method="POST" action="{{ $item->exists ? route('admin.projects.update', $item) : route('admin.projects.store') }}" class="admin-form-shell" enctype="multipart/form-data">
        @csrf @if($item->exists) @method('PUT') @endif

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.title'), 'icon' => 'projects'])
        @include('admin.partials.bilingual-field', ['name' => 'title', 'label' => __('admin.fields.title'), 'value' => \App\Support\Translator::splitForForm($item->title), 'required' => true])
        <div class="admin-form-grid">
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.client_name') }}</label><input type="text" name="client_name" value="{{ old('client_name', $item->client_name) }}" class="admin-input"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.status') }}</label><select name="status" class="admin-select">@foreach($statuses as $s)<option value="{{ $s->value }}" {{ old('status', $item->status?->value) == $s->value ? 'selected' : '' }}>{{ $s->label() }}</option>@endforeach</select></div>
        </div>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.description'), 'icon' => 'blog'])
        @include('admin.partials.bilingual-field', ['name' => 'short_description', 'label' => __('admin.fields.short_description'), 'value' => \App\Support\Translator::splitForForm($item->short_description), 'type' => 'textarea', 'rows' => 2])
        @include('admin.partials.bilingual-field', ['name' => 'description', 'label' => __('admin.fields.description'), 'value' => \App\Support\Translator::splitForForm($item->description), 'type' => 'textarea', 'rows' => 5])
        @include('admin.partials.bilingual-field', ['name' => 'challenge', 'label' => __('admin.fields.challenge'), 'value' => \App\Support\Translator::splitForForm($item->challenge), 'type' => 'textarea', 'rows' => 3])
        @include('admin.partials.bilingual-field', ['name' => 'solution', 'label' => __('admin.fields.solution'), 'value' => \App\Support\Translator::splitForForm($item->solution), 'type' => 'textarea', 'rows' => 3])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.key_features'), 'icon' => 'services'])
        @include('admin.partials.features-list-field', [
            'featureGroups' => \App\Support\FeatureGroups::forForm($item->key_features),
        ])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.project_images.section'), 'icon' => 'media'])
        @include('admin.partials.image-upload-field', [
            'current' => $item->coverImage,
            'inputName' => 'cover_image',
            'removeName' => 'remove_cover_image',
            'altName' => 'cover_image_alt',
            'label' => __('admin.project_images.cover'),
            'help' => __('admin.project_images.cover_help'),
        ])
        @include('admin.partials.image-upload-field', [
            'current' => $item->featuredImage,
            'inputName' => 'featured_image',
            'removeName' => 'remove_featured_image',
            'altName' => 'featured_image_alt',
            'label' => __('admin.project_images.thumbnail'),
            'help' => __('admin.project_images.thumbnail_help'),
        ])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.actions'), 'icon' => 'settings'])
        <div class="admin-form-grid">
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.live_url') }}</label><input type="url" name="live_url" value="{{ old('live_url', $item->live_url) }}" class="admin-input" dir="ltr"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.completion_date') }}</label><input type="date" name="completion_date" value="{{ old('completion_date', $item->completion_date?->format('Y-m-d')) }}" class="admin-input" dir="ltr"></div>
        </div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.nav.services') }}</label><div class="admin-checkbox-grid">@foreach($services as $s)<label class="admin-checkbox-label"><input type="checkbox" name="services[]" value="{{ $s->id }}" {{ in_array($s->id, old('services', $item->exists ? $item->services->pluck('id')->toArray() : [])) ? 'checked' : '' }}> {{ $s->translate('title') }}</label>@endforeach</div></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.nav.technologies') }}</label><div class="admin-checkbox-grid admin-checkbox-grid-3">@foreach($technologies as $t)<label class="admin-checkbox-label"><input type="checkbox" name="technologies[]" value="{{ $t->id }}" {{ in_array($t->id, old('technologies', $item->exists ? $item->technologies->pluck('id')->toArray() : [])) ? 'checked' : '' }}> {{ $t->name }}</label>@endforeach</div></div>
        <label class="admin-toggle"><span class="admin-toggle-label">{{ __('admin.fields.featured') }}</span><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }}></label>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.nav.seo'), 'icon' => 'seo'])
        @include('admin.partials.bilingual-field', ['name' => 'meta_title', 'label' => __('admin.fields.meta_title'), 'value' => \App\Support\Translator::splitForForm($item->meta_title)])
        @include('admin.partials.bilingual-field', ['name' => 'meta_description', 'label' => __('admin.fields.meta_description'), 'value' => \App\Support\Translator::splitForForm($item->meta_description), 'type' => 'textarea', 'rows' => 2])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-actions', ['backRoute' => route('admin.projects.index')])
    </form>
</div>
@endsection
