@extends('layouts.admin')
@section('title', __('admin.pages.process_steps'))
@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.process-steps.create')])
@endsection
@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.step') }}</th><th>{{ __('admin.fields.title') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><span class="admin-badge admin-badge-info">{{ $item->step_number }}</span></td>
                <td><strong>{{ $item->translate('title') }}</strong></td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.process-steps.edit', $item), 'deleteRoute' => route('admin.process-steps.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="3" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
