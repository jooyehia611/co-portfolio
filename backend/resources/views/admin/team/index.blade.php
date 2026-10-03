@extends('layouts.admin')
@section('title', __('admin.pages.team'))
@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.team.create')])
@endsection
@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.name') }}</th><th>{{ __('admin.fields.role') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->name }}</strong></td>
                <td>{{ $item->translate('role') }}</td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.team.edit', $item), 'deleteRoute' => route('admin.team.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="3" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
