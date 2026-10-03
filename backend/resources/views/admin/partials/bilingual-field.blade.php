@php
    $type = $type ?? 'text';
    $rows = $rows ?? 3;
    $required = $required ?? false;
    $value = $value ?? ['ar' => '', 'en' => ''];
    $arValue = old("{$name}_ar", $value['ar'] ?? '');
    $enValue = old("{$name}_en", $value['en'] ?? '');
@endphp

<div class="admin-bilingual">
    <div class="admin-bilingual-header">
        <span class="admin-bilingual-title">{{ $label }}</span>
        @if($required)<span class="admin-required">*</span>@endif
    </div>
    <div class="admin-bilingual-grid">
        <div class="admin-bilingual-col">
            <div class="admin-bilingual-lang ar">
                <span class="admin-lang-dot"></span>
                {{ __('admin.fields.arabic') }}
            </div>
            @if($type === 'textarea')
            <textarea name="{{ $name }}_ar" rows="{{ $rows }}" {{ $required ? 'required' : '' }} class="admin-textarea" dir="rtl" placeholder="{{ __('admin.fields.arabic') }}...">{{ $arValue }}</textarea>
            @else
            <input type="text" name="{{ $name }}_ar" value="{{ $arValue }}" {{ $required ? 'required' : '' }} class="admin-input" dir="rtl" placeholder="{{ __('admin.fields.arabic') }}...">
            @endif
        </div>
        <div class="admin-bilingual-col">
            <div class="admin-bilingual-lang en">
                <span class="admin-lang-dot en"></span>
                {{ __('admin.fields.english') }}
            </div>
            @if($type === 'textarea')
            <textarea name="{{ $name }}_en" rows="{{ $rows }}" class="admin-textarea" dir="ltr" placeholder="English...">{{ $enValue }}</textarea>
            @else
            <input type="text" name="{{ $name }}_en" value="{{ $enValue }}" class="admin-input" dir="ltr" placeholder="English...">
            @endif
        </div>
    </div>
</div>
