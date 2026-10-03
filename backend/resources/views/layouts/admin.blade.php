<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('admin.nav.dashboard')) — {{ __('admin.cms_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
</head>
<body class="admin-body">
@auth
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <div class="admin-brand-logo">
                <img src="{{ asset('brand/logo-icon.png') }}" alt="Y-TECH" class="admin-brand-image">
                <div>
                    <h1>{{ __('admin.cms_title') }}</h1>
                    <p>{{ __('admin.cms_subtitle') }}</p>
                </div>
            </div>
        </div>

        <nav class="admin-nav">
            @php
            $navGroups = [
                __('admin.nav.groups.overview') => [
                    ['admin.dashboard', 'admin.nav.dashboard', 'dashboard', 'admin.dashboard'],
                ],
                __('admin.nav.groups.content') => [
                    ['admin.homepage.index', 'admin.nav.homepage', 'homepage', 'admin.homepage.*'],
                    ['admin.services.index', 'admin.nav.services', 'services', 'admin.services.*'],
                    ['admin.projects.index', 'admin.nav.projects', 'projects', 'admin.projects.*'],
                ],
                __('admin.nav.groups.marketing') => [
                    ['admin.clients.index', 'admin.nav.clients', 'clients', 'admin.clients.*'],
                    ['admin.testimonials.index', 'admin.nav.testimonials', 'testimonials', 'admin.testimonials.*'],
                    ['admin.seo.index', 'admin.nav.seo', 'seo', 'admin.seo.*'],
                ],
                __('admin.nav.groups.company') => [
                    ['admin.team.index', 'admin.nav.team', 'team', 'admin.team.*'],
                    ['admin.statistics.index', 'admin.nav.statistics', 'statistics', 'admin.statistics.*'],
                    ['admin.process-steps.index', 'admin.nav.process_steps', 'process', 'admin.process-steps.*'],
                    ['admin.business-values.index', 'admin.nav.business_values', 'values', 'admin.business-values.*'],
                    ['admin.awards.index', 'admin.nav.awards', 'awards', 'admin.awards.*'],
                    ['admin.technologies.index', 'admin.nav.technologies', 'technologies', 'admin.technologies.*'],
                ],
                __('admin.nav.groups.system') => [
                    ['admin.leads.index', 'admin.nav.leads', 'leads', 'admin.leads.*'],
                    ['admin.media.index', 'admin.nav.media', 'media', 'admin.media.*'],
                    ['admin.settings.index', 'admin.nav.settings', 'settings', 'admin.settings.*'],
                    ['admin.users.index', 'admin.nav.users', 'users', 'admin.users.*'],
                ],
            ];
            @endphp

            @foreach($navGroups as $groupLabel => $links)
            <div class="admin-nav-group">
                <div class="admin-nav-label">{{ $groupLabel }}</div>
                @foreach($links as [$route, $label, $icon, $pattern])
                <a href="{{ route($route) }}" class="admin-nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                    @include('admin.partials.icon', ['name' => $icon])
                    <span>{{ __($label) }}</span>
                </a>
                @endforeach
            </div>
            @endforeach
        </nav>

        <div class="admin-sidebar-footer">
            <div class="admin-lang">
                <a href="{{ route('admin.locale.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
                <a href="{{ route('admin.locale.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
            <div class="admin-user">
                <div class="admin-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <p class="admin-user-name">{{ auth()->user()->name }}</p>
                    <p class="admin-user-role">{{ auth()->user()->role?->name ?? 'Admin' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}" style="margin-top:0.75rem;">
                @csrf
                <button type="submit" class="admin-nav-link" style="width:100%;border:none;background:transparent;cursor:pointer;color:#f87171;">
                    @include('admin.partials.icon', ['name' => 'logout', 'class' => 'admin-nav-icon'])
                    <span>{{ __('admin.actions.logout') }}</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <h1 class="admin-topbar-title">@yield('title', __('admin.nav.dashboard'))</h1>
                @hasSection('subtitle')
                <p class="admin-topbar-subtitle">@yield('subtitle')</p>
                @endif
            </div>
            <div class="admin-topbar-actions">
                @yield('topbar_actions')
                @php
                    $frontendUrl = config('app.frontend_url');
                    if (app()->getLocale() === 'en') {
                        $frontendUrl .= '/en';
                    }
                @endphp
                <a href="{{ $frontendUrl }}" target="_blank" rel="noopener noreferrer" class="admin-btn admin-btn-secondary admin-btn-sm">
                    @include('admin.partials.icon', ['name' => 'external', 'class' => 'admin-btn-icon'])
                    {{ __('admin.actions.view_site') }}
                </a>
            </div>
        </header>
        <div class="admin-content">
            @include('admin.partials.flash')
            @yield('content')
        </div>
    </div>
</div>
@else
@yield('content')
@endauth
</body>
</html>
