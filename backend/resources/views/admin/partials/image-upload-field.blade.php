@php
    $current = $current ?? null;
    $inputName = $inputName ?? 'image';
    $removeName = $removeName ?? 'remove_image';
    $altName = $altName ?? null;
    $altValue = $altValue ?? ($current->alt_text ?? '');
@endphp

@if($current)
    <div class="admin-field admin-image-preview">
        <label class="admin-label">{{ $currentLabel ?? __('admin.hero.current_image') }}</label>
        <div class="admin-image-preview__frame">
            <img src="{{ $current->url }}" alt="{{ $current->alt_text }}">
        </div>
    </div>
    <label class="admin-toggle admin-image-preview__remove">
        <span class="admin-toggle-label">{{ $removeLabel ?? __('admin.hero.remove_image') }}</span>
        <input type="checkbox" name="{{ $removeName }}" value="1" {{ old($removeName) ? 'checked' : '' }}>
    </label>
@endif

<div class="admin-field">
    <label class="admin-label">{{ $label }}</label>
    <input type="file" name="{{ $inputName }}" accept="image/jpeg,image/png,image/webp,image/svg+xml" class="admin-input">
    @if(!empty($help))
        <p class="admin-help">{{ $help }}</p>
    @endif
</div>

@if($altName)
    <div class="admin-field">
        <label class="admin-label">{{ __('admin.hero.image_alt') }}</label>
        <input type="text" name="{{ $altName }}" value="{{ old($altName, $altValue) }}" class="admin-input" placeholder="{{ __('admin.hero.image_alt_placeholder') }}">
    </div>
@endif
