@extends('layouts.admin')

@section('title', __('admin.pages.leads'))

@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>{{ __('admin.fields.name') }}</th>
                <th>{{ __('admin.fields.email') }}</th>
                <th>{{ __('admin.fields.status') }}</th>
                <th>{{ __('admin.fields.date') }}</th>
                <th>{{ __('admin.fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->name }}</strong></td>
                <td dir="ltr" class="admin-mono">{{ $item->email }}</td>
                <td><span class="admin-badge admin-badge-info">{{ $item->status->label() }}</span></td>
                <td class="admin-text-muted">{{ $item->created_at->format('M d, Y') }}</td>
                <td>@include('admin.partials.crud-actions', ['viewRoute' => route('admin.leads.show', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="5" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
