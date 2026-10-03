@extends('layouts.admin')
@section('title', __('admin.pages.awards'))
@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.awards.create')])
@endsection
@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.year') }}</th><th>{{ __('admin.fields.title') }}</th><th>{{ __('admin.fields.platform') }}</th><th>{{ __('admin.fields.result') }}</th><th>{{ __('admin.fields.active') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->year }}</td>
                <td><strong>{{ $item->translate('title') }}</strong></td>
                <td>{{ $item->translate('platform') ?: __('admin.common.not_available') }}</td>
                <td>{{ $item->translate('result') ?: __('admin.common.not_available') }}</td>
                <td>{{ $item->is_active ? __('admin.common.yes') : __('admin.common.no') }}</td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.awards.edit', $item), 'deleteRoute' => route('admin.awards.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="6" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
