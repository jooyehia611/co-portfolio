@extends('layouts.admin')
@section('title', __('admin.pages.testimonials'))
@section('topbar_actions')
@include('admin.partials.topbar-add', ['route' => route('admin.testimonials.create')])
@endsection
@section('content')
<div class="admin-form-shell" style="margin-bottom:1.25rem;padding:1.5rem;">
    <h2 style="margin:0 0 .5rem;">{{ app()->getLocale() === 'ar' ? 'اطلب رأيًا صوتيًا' : 'Request a voice review' }}</h2>
    <p style="margin:0 0 1rem;color:#64748b;">{{ app()->getLocale() === 'ar' ? 'أنشئ رابطًا خاصًا، وأرسله للعميل. صالح لمدة 30 يومًا ولمرة واحدة.' : 'Create a private link to send to your client. It expires in 30 days and can be used once.' }}</p>
    <form method="POST" action="{{ route('admin.testimonials.invites.store') }}" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:end;">
        @csrf
        <div class="admin-field" style="flex:1;min-width:220px;"><label class="admin-label" for="invite-client">{{ app()->getLocale() === 'ar' ? 'اسم العميل (اختياري)' : 'Client name (optional)' }}</label><input id="invite-client" name="client_name" class="admin-input" maxlength="120"></div>
        <button class="admin-btn admin-btn-primary" type="submit">{{ app()->getLocale() === 'ar' ? 'إنشاء الرابط' : 'Create link' }}</button>
    </form>
    @if(session('invite_url'))
    <div style="margin-top:1rem;padding:1rem;border-radius:10px;background:#eff6ff;overflow-wrap:anywhere;">
        <strong>{{ app()->getLocale() === 'ar' ? 'انسخ الرابط الآن؛ لن يظهر مرة أخرى:' : 'Copy this link now; it will not be shown again:' }}</strong><br>
        <a href="{{ session('invite_url') }}" target="_blank" rel="noopener">{{ session('invite_url') }}</a>
        <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" style="margin-inline-start:.5rem;" onclick="navigator.clipboard.writeText(@js(session('invite_url')))" >{{ app()->getLocale() === 'ar' ? 'نسخ' : 'Copy' }}</button>
    </div>
    @endif
</div>
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.client') }}</th><th>{{ __('admin.fields.company') }}</th><th>{{ app()->getLocale() === 'ar' ? 'التسجيل' : 'Recording' }}</th><th>{{ __('admin.fields.status') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->client_name }}</strong></td>
                <td>{{ $item->client_company }}</td>
                <td>@if($item->audio_path)<audio controls preload="none" style="max-width:220px;width:100%" src="{{ asset(\Illuminate\Support\Facades\Storage::disk('public')->url($item->audio_path)) }}"></audio>@else — @endif</td>
                <td>{{ $item->status?->label() }}</td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.testimonials.edit', $item), 'deleteRoute' => route('admin.testimonials.destroy', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="5" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
