@extends('layouts.admin')
@section('title', __('admin.pages.users'))
@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.users.create')])
@endsection
@section('content')
<div class="admin-page">
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.name') }}</th><th>{{ __('admin.fields.email') }}</th><th>{{ __('admin.fields.role') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->name }}</strong></td>
                <td dir="ltr" class="admin-mono">{{ $item->email }}</td>
                <td><span class="admin-badge admin-badge-neutral">{{ $item->role?->name ?? __('admin.common.none') }}</span></td>
                <td>
                    <div class="admin-action-group">
                        <a href="{{ route('admin.users.edit', $item) }}" class="admin-action-btn admin-action-btn-edit">
                            @include('admin.partials.icon', ['name' => 'edit', 'class' => 'admin-btn-icon'])
                            <span>{{ __('admin.actions.edit') }}</span>
                        </a>
                        @if($item->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $item) }}" class="admin-action-form" onsubmit="return confirm(@json(__('admin.common.confirm_delete_item')))">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-action-btn admin-action-btn-delete">
                                @include('admin.partials.icon', ['name' => 'trash', 'class' => 'admin-btn-icon'])
                                <span>{{ __('admin.actions.delete') }}</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
