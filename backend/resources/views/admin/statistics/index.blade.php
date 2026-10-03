@extends('layouts.admin')
@section('title', __('admin.pages.statistics'))
@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.statistics.create')])
@endsection
@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.label') }}</th><th>{{ __('admin.fields.value') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->translate('label') }}</strong></td>
                <td>{{ $item->value }}{{ $item->suffix }}</td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.statistics.edit', $item), 'deleteRoute' => route('admin.statistics.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="3" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
