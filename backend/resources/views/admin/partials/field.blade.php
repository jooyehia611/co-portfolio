@php
    $type = $type ?? 'text';
    $required = $required ?? false;
    $placeholder = $placeholder ?? '';
    $dir = $dir ?? null;
    $class = trim('admin-input ' . ($class ?? ''));
    if ($type === 'textarea') $class = trim('admin-textarea ' . ($class ?? ''));
    if ($type === 'select') $class = trim('admin-select ' . ($class ?? ''));
@endphp
<div class="admin-field">
    <label class="admin-label" for="{{ $name }}">
        {{ $label }}@if($required)<span class="admin-required">*</span>@endif
    </label>
    @if($type === 'textarea')
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows ?? 3 }}" class="{{ $class }}" @if($required) required @endif @if($dir) dir="{{ $dir }}" @endif placeholder="{{ $placeholder }}">{{ $value ?? '' }}</textarea>
    @elseif($type === 'select')
    <select id="{{ $name }}" name="{{ $name }}" class="{{ $class }}" @if($required) required @endif>{!! $options ?? '' !!}</select>
    @else
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value ?? '' }}" class="{{ $class }}" @if($required) required @endif @if($dir) dir="{{ $dir }}" @endif placeholder="{{ $placeholder }}">
    @endif
    @if(!empty($hint))<p class="admin-field-hint">{{ $hint }}</p>@endif
</div>
