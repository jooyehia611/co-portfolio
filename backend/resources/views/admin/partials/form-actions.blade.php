<div class="admin-form-footer">
    <div class="admin-form-footer-inner">
        @isset($backRoute)
        <a href="{{ $backRoute }}" class="admin-btn admin-btn-secondary admin-btn-lg">
            @include('admin.partials.icon', ['name' => 'back', 'class' => 'admin-btn-icon'])
            {{ __('admin.actions.back') }}
        </a>
        @endisset
        <button type="submit" class="admin-btn admin-btn-primary admin-btn-lg">
            @include('admin.partials.icon', ['name' => 'save', 'class' => 'admin-btn-icon'])
            {{ $label ?? __('admin.actions.save') }}
        </button>
    </div>
</div>
