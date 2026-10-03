{{-- Modern table row actions: editRoute, deleteRoute, viewRoute (optional) --}}
<div class="admin-action-group">
    @isset($viewRoute)
    <a href="{{ $viewRoute }}" class="admin-action-btn admin-action-btn-view" title="{{ __('admin.actions.view') }}">
        @include('admin.partials.icon', ['name' => 'eye', 'class' => 'admin-btn-icon'])
        <span>{{ __('admin.actions.view') }}</span>
    </a>
    @endisset
    @isset($editRoute)
    <a href="{{ $editRoute }}" class="admin-action-btn admin-action-btn-edit" title="{{ __('admin.actions.edit') }}">
        @include('admin.partials.icon', ['name' => 'edit', 'class' => 'admin-btn-icon'])
        <span>{{ __('admin.actions.edit') }}</span>
    </a>
    @endisset
    @isset($deleteRoute)
    <form method="POST" action="{{ $deleteRoute }}" class="admin-action-form" onsubmit="return confirm(@json(__('admin.common.confirm_delete_item')))">
        @csrf @method('DELETE')
        <button type="submit" class="admin-action-btn admin-action-btn-delete" title="{{ __('admin.actions.delete') }}">
            @include('admin.partials.icon', ['name' => 'trash', 'class' => 'admin-btn-icon'])
            <span>{{ __('admin.actions.delete') }}</span>
        </button>
    </form>
    @endisset
</div>
