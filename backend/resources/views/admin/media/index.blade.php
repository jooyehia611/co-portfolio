@extends('layouts.admin')
@section('title', __('admin.pages.media'))
@section('content')
<div class="admin-page">
    <div class="admin-form-shell" style="max-width:480px;margin-bottom:1.25rem;">
        @include('admin.partials.form-section-start', ['title' => __('admin.actions.upload'), 'icon' => 'media'])
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="admin-field">
                <label class="admin-label">{{ __('admin.fields.file') }}</label>
                <input type="file" name="file" required class="admin-input">
            </div>
            <div class="admin-field">
                <label class="admin-label">{{ __('admin.fields.alt_text') }}</label>
                <input type="text" name="alt_text" class="admin-input">
            </div>
            <button type="submit" class="admin-btn admin-btn-primary admin-btn-add">{{ __('admin.actions.upload') }}</button>
        </form>
        @include('admin.partials.form-section-end')
    </div>

    <div class="admin-media-grid">
        @forelse($items as $item)
        <div class="admin-media-card">
            <p class="admin-text-muted" style="margin:0 0 0.5rem;font-size:0.8125rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item->original_name }}</p>
            <p class="admin-mono" style="margin:0 0 0.75rem;">{{ number_format($item->size / 1024, 1) }} KB</p>
            <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="admin-action-form" onsubmit="return confirm(@json(__('admin.common.confirm_delete_item')))">
                @csrf @method('DELETE')
                <button type="submit" class="admin-action-btn admin-action-btn-delete">
                    @include('admin.partials.icon', ['name' => 'trash', 'class' => 'admin-btn-icon'])
                    <span>{{ __('admin.actions.delete') }}</span>
                </button>
            </form>
        </div>
        @empty
        <p class="admin-text-muted">{{ __('admin.common.no_items') }}</p>
        @endforelse
    </div>
    @if($items->hasPages())
    <div style="margin-top:1.25rem;">{{ $items->links() }}</div>
    @endif
</div>
@endsection
