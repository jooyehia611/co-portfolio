{{-- Topbar "Add New" button: pass $route --}}
<a href="{{ $route }}" class="admin-btn admin-btn-primary admin-btn-add">
    @include('admin.partials.icon', ['name' => 'plus', 'class' => 'admin-btn-icon'])
    {{ $label ?? __('admin.actions.add_new') }}
</a>
