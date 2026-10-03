@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.award_edit') : __('admin.pages.award_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.awards.update', $item) : route('admin.awards.store') }}" class="admin-form-shell">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.nav.awards'), 'icon' => 'awards'])
        @include('admin.partials.bilingual-field', ['name' => 'title', 'label' => __('admin.fields.title'), 'value' => \App\Support\Translator::splitForForm($item->title), 'required' => true])
        @include('admin.partials.bilingual-field', ['name' => 'platform', 'label' => __('admin.fields.platform'), 'value' => \App\Support\Translator::splitForForm($item->platform)])
        @include('admin.partials.bilingual-field', ['name' => 'result', 'label' => __('admin.fields.result'), 'value' => \App\Support\Translator::splitForForm($item->result)])
        <div class="admin-form-grid">
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.year') }}<span class="admin-required">*</span></label><input type="text" name="year" value="{{ old('year', $item->year) }}" required class="admin-input" dir="ltr"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.sort_order') }}</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0" class="admin-input" dir="ltr"></div>
        </div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.award_link') }}</label><input type="url" name="link_url" value="{{ old('link_url', $item->link_url) }}" class="admin-input" dir="ltr"></div>
        <label class="admin-toggle"><span class="admin-toggle-label">{{ __('admin.fields.active') }}</span><input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->exists ? $item->is_active : true) ? 'checked' : '' }}></label>
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['backRoute' => route('admin.awards.index')])
    </form>
</div>
@endsection
