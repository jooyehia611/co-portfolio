@extends('layouts.admin')
@section('title', $title ?? __('admin.actions.edit'))

@section('topbar_actions')
@isset($createRoute)
@include('admin.partials.topbar-add', ['route' => $createRoute])
@endisset
@endsection

@section('content')
<div class="admin-page">
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                @foreach($columns as $col)
                <th>{{ $col }}</th>
                @endforeach
                <th>{{ __('admin.fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                {{ $slot($item) }}
                <td>
                    @include('admin.partials.crud-actions', [
                        'editRoute' => isset($editRoute) ? $editRoute($item) : null,
                        'deleteRoute' => isset($deleteRoute) ? $deleteRoute($item) : null,
                    ])
                </td>
            </tr>
            @empty
            <tr><td colspan="{{ count($columns)+1 }}" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
