@extends('layouts.admin')

@section('title', __('admin.pages.homepage'))

@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>{{ __('admin.fields.section_key') }}</th>
                <th>{{ __('admin.fields.title') }}</th>
                <th>{{ __('admin.fields.active') }}</th>
                <th>{{ __('admin.fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sections as $section)
            <tr>
                <td class="admin-mono" dir="ltr">{{ $section->section_key }}</td>
                <td><strong>{{ $section->translate('title') }}</strong></td>
                <td><span class="admin-badge admin-badge-{{ $section->is_active ? 'yes' : 'no' }}">{{ $section->is_active ? __('admin.common.yes') : __('admin.common.no') }}</span></td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.homepage.edit', $section)])</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
