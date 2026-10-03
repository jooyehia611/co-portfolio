@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.business_value_edit') : __('admin.pages.business_value_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.business-values.update', $item) : route('admin.business-values.store') }}" class="admin-form-shell">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.nav.business_values'), 'icon' => 'values'])
        @include('admin.partials.bilingual-field', ['name' => 'title', 'label' => __('admin.fields.title'), 'value' => \App\Support\Translator::splitForForm($item->title), 'required' => true])
        @include('admin.partials.bilingual-field', ['name' => 'description', 'label' => __('admin.fields.description'), 'value' => \App\Support\Translator::splitForForm($item->description), 'type' => 'textarea', 'rows' => 3])
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['backRoute' => route('admin.business-values.index')])
    </form>
</div>
@endsection
