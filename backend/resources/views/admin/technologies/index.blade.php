@extends('layouts.admin')
@section('title', __('admin.pages.technologies'))
@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.technologies.create')])
@endsection
@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.name') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->name }}</strong></td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.technologies.edit', $item), 'deleteRoute' => route('admin.technologies.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="2" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
