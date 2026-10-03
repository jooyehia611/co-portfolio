@extends('layouts.admin')

@section('title', __('admin.pages.services'))

@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.services.create')])
@endsection

@section('content')
<div class="admin-page">
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>{{ __('admin.fields.title') }}</th>
                <th>{{ __('admin.fields.status') }}</th>
                <th>{{ __('admin.fields.featured') }}</th>
                <th>{{ __('admin.fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->translate('title') }}</strong></td>
                <td><span class="admin-badge admin-badge-{{ $item->status?->value === 'published' ? 'success' : 'neutral' }}">{{ $item->status?->label() }}</span></td>
                <td><span class="admin-badge admin-badge-{{ $item->is_featured ? 'yes' : 'no' }}">{{ $item->is_featured ? __('admin.common.yes') : __('admin.common.no') }}</span></td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.services.edit', $item), 'deleteRoute' => route('admin.services.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="4" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
