@extends('layouts.admin')

@section('title', __('admin.pages.settings'))

@section('content')
<div class="admin-page admin-form-page-wide">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="admin-form-shell">
        @csrf @method('PUT')
        @php $currentGroup = null; @endphp
        @foreach($settings as $setting)
            @if($currentGroup !== $setting->group)
                @php $currentGroup = $setting->group; @endphp
                @if(!$loop->first) @include('admin.partials.form-section-end') @endif
                @include('admin.partials.form-section-start', ['title' => __('admin.settings_groups.' . $currentGroup), 'icon' => 'settings'])
            @endif
            @if($setting->type === 'media')
                @php
                    $mediaId = $setting->value ? (int) $setting->value : null;
                    $currentMedia = $mediaId ? ($mediaFiles[$mediaId] ?? null) : null;
                    $labelKey = 'admin.fields.' . $setting->key;
                    $label = __($labelKey) !== $labelKey ? __($labelKey) : str_replace('_', ' ', $setting->key);
                @endphp
                @include('admin.partials.image-upload-field', [
                    'current' => $currentMedia,
                    'inputName' => 'media_' . $setting->key,
                    'removeName' => 'remove_media_' . $setting->key,
                    'altName' => 'media_alt_' . $setting->key,
                    'label' => $label,
                ])
            @elseif($setting->isBilingual())
            <div class="admin-bilingual">
                <div class="admin-bilingual-header"><span class="admin-bilingual-title">{{ __("admin.fields.{$setting->key}") !== "admin.fields.{$setting->key}" ? __("admin.fields.{$setting->key}") : str_replace('_', ' ', $setting->key) }}</span></div>
                <div class="admin-bilingual-grid">
                    <div class="admin-bilingual-col">
                        <div class="admin-bilingual-lang ar"><span class="admin-lang-dot"></span>{{ __('admin.fields.arabic') }}</div>
                        @if($setting->type === 'textarea')
                        <textarea name="settings_bilingual[{{ $setting->id }}][ar]" rows="3" class="admin-textarea" dir="rtl">{{ old("settings_bilingual.{$setting->id}.ar", $setting->bilingualValue()['ar']) }}</textarea>
                        @else
                        <input type="text" name="settings_bilingual[{{ $setting->id }}][ar]" value="{{ old("settings_bilingual.{$setting->id}.ar", $setting->bilingualValue()['ar']) }}" class="admin-input" dir="rtl">
                        @endif
                    </div>
                    <div class="admin-bilingual-col">
                        <div class="admin-bilingual-lang en"><span class="admin-lang-dot en"></span>{{ __('admin.fields.english') }}</div>
                        @if($setting->type === 'textarea')
                        <textarea name="settings_bilingual[{{ $setting->id }}][en]" rows="3" class="admin-textarea" dir="ltr">{{ old("settings_bilingual.{$setting->id}.en", $setting->bilingualValue()['en']) }}</textarea>
                        @else
                        <input type="text" name="settings_bilingual[{{ $setting->id }}][en]" value="{{ old("settings_bilingual.{$setting->id}.en", $setting->bilingualValue()['en']) }}" class="admin-input" dir="ltr">
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="admin-field">
                <label class="admin-label">{{ str_replace('_', ' ', $setting->key) }}</label>
                @if($setting->type === 'textarea')
                <textarea name="settings[{{ $setting->id }}]" rows="3" class="admin-textarea">{{ old("settings.{$setting->id}", $setting->value) }}</textarea>
                @else
                <input type="text" name="settings[{{ $setting->id }}]" value="{{ old("settings.{$setting->id}", $setting->value) }}" class="admin-input" @if(in_array($setting->type, ['email', 'url'])) dir="ltr" @endif>
                @endif
            </div>
            @endif
        @endforeach
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['label' => __('admin.actions.save_settings')])
    </form>
</div>
@endsection
