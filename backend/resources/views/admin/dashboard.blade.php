@extends('layouts.admin')

@section('title', __('admin.dashboard.title'))
@section('subtitle', __('admin.dashboard.subtitle'))

@section('content')
@php
$statConfig = [
    'projects' => ['icon' => 'indigo', 'path' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
    'services' => ['icon' => 'violet', 'path' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
    'leads' => ['icon' => 'emerald', 'path' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
    'new_leads' => ['icon' => 'amber', 'path' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
    'users' => ['icon' => 'rose', 'path' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
];
@endphp

<div class="admin-stats">
    @foreach($statConfig as $key => $config)
    <div class="admin-stat">
        <div class="admin-stat-icon {{ $config['icon'] }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $config['path'] }}"></path></svg>
        </div>
        <p class="admin-stat-label">{{ __('admin.dashboard.stats.' . $key) }}</p>
        <p class="admin-stat-value">{{ $stats[$key] }}</p>
    </div>
    @endforeach
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">{{ __('admin.dashboard.recent_leads') }}</h3>
        <a href="{{ route('admin.leads.index') }}" class="admin-link-chip">
            {{ __('admin.actions.view') }}
            @include('admin.partials.icon', ['name' => 'eye', 'class' => 'admin-btn-icon'])
        </a>
    </div>
    <div class="admin-table-wrap" style="border:none;box-shadow:none;border-radius:0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>{{ __('admin.fields.name') }}</th>
                    <th>{{ __('admin.fields.email') }}</th>
                    <th>{{ __('admin.fields.status') }}</th>
                    <th>{{ __('admin.fields.date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_leads as $lead)
                <tr>
                    <td><strong>{{ $lead->name }}</strong></td>
                    <td dir="ltr" class="admin-mono">{{ $lead->email }}</td>
                    <td><span class="admin-badge admin-badge-info">{{ $lead->status->label() }}</span></td>
                    <td class="admin-text-muted">{{ $lead->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="admin-table-empty">{{ __('admin.dashboard.no_leads') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
