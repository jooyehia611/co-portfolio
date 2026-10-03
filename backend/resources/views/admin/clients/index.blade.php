@extends('layouts.admin')
@section('title', __('admin.pages.clients'))
@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.clients.create')])
@endsection
@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.name') }}</th><th>{{ __('admin.fields.featured') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->name }}</strong></td>
                <td><span class="admin-badge admin-badge-{{ $item->is_featured ? 'yes' : 'no' }}">{{ $item->is_featured ? __('admin.common.yes') : __('admin.common.no') }}</span></td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.clients.edit', $item), 'deleteRoute' => route('admin.clients.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="3" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
