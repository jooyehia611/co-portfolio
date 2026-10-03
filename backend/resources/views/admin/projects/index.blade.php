@extends('layouts.admin')

@section('title', __('admin.pages.projects'))

@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.projects.create')])
@endsection

@section('content')
<div class="admin-page">
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>{{ __('admin.fields.title') }}</th>
                <th>{{ __('admin.fields.client') }}</th>
                <th>{{ __('admin.fields.status') }}</th>
                <th>{{ __('admin.fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->translate('title') }}</strong></td>
                <td>{{ $item->client_name }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.projects.status', $item) }}" class="admin-inline-status">
                        @csrf
                        @method('PATCH')
                        <select
                            name="status"
                            class="admin-select admin-select--compact admin-badge-select admin-badge-select--{{ $item->status?->value ?? 'draft' }}"
                            onchange="this.form.submit()"
                            aria-label="{{ __('admin.fields.status') }}"
                        >
                            @foreach(\App\Enums\ContentStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ $item->status === $status ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.projects.edit', $item), 'deleteRoute' => route('admin.projects.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="4" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
