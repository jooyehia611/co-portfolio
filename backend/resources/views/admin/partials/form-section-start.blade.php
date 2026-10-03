{{-- Modern form section opener: @include with title, optional description & icon --}}
@php
    $icon = $icon ?? null;
    $description = is_string($description ?? null) ? $description : null;
@endphp
<div class="admin-form-section">
    <div class="admin-form-section-head">
        @if($icon)
        <div class="admin-form-section-icon">@include('admin.partials.icon', ['name' => $icon, 'class' => 'admin-nav-icon'])</div>
        @endif
        <div>
            <h3 class="admin-form-section-title">{{ $title }}</h3>
            @if($description)<p class="admin-form-section-desc">{{ $description }}</p>@endif
        </div>
    </div>
    <div class="admin-form-section-body">
