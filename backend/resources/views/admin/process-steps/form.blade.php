@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.process_step_edit') : __('admin.pages.process_step_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.process-steps.update', $item) : route('admin.process-steps.store') }}" class="admin-form-shell" enctype="multipart/form-data">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.nav.process_steps'), 'icon' => 'process'])
        @include('admin.partials.bilingual-field', ['name' => 'title', 'label' => __('admin.fields.title'), 'value' => \App\Support\Translator::splitForForm($item->title), 'required' => true])
        @include('admin.partials.bilingual-field', ['name' => 'description', 'label' => __('admin.fields.description'), 'value' => \App\Support\Translator::splitForForm($item->description), 'type' => 'textarea', 'rows' => 3])
        <div class="admin-form-grid">
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.step_number') }}</label><input type="number" name="step_number" value="{{ old('step_number', $item->step_number ?? 1) }}" class="admin-input"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.icon') }}</label><input type="text" name="icon" value="{{ old('icon', $item->icon) }}" class="admin-input" placeholder="search, map, code..."></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.sort_order') }}</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="admin-input"></div>
        </div>
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-section-start', ['title' => __('admin.fields.step_image'), 'icon' => 'media'])
        @include('admin.partials.image-upload-field', [
            'current' => $item->image,
            'inputName' => 'image',
            'removeName' => 'remove_image',
            'altName' => 'image_alt',
            'label' => __('admin.fields.step_image'),
        ])
        @include('admin.partials.form-section-end')

        @include('admin.partials.form-actions', ['backRoute' => route('admin.process-steps.index')])
    </form>
</div>
@endsection
