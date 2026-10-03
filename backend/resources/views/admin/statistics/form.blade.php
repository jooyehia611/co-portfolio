@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.statistic_edit') : __('admin.pages.statistic_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.statistics.update', $item) : route('admin.statistics.store') }}" class="admin-form-shell">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.nav.statistics'), 'icon' => 'statistics'])
        @include('admin.partials.bilingual-field', ['name' => 'label', 'label' => __('admin.fields.label'), 'value' => \App\Support\Translator::splitForForm($item->label), 'required' => true])
        <div class="admin-form-grid">
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.value') }}<span class="admin-required">*</span></label><input type="text" name="value" value="{{ old('value', $item->value) }}" required class="admin-input"></div>
            <div class="admin-field"><label class="admin-label">{{ __('admin.fields.suffix') }}</label><input type="text" name="suffix" value="{{ old('suffix', $item->suffix) }}" class="admin-input"></div>
        </div>
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['backRoute' => route('admin.statistics.index')])
    </form>
</div>
@endsection
