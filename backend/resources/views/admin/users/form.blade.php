@extends('layouts.admin')
@section('title', $item->exists ? __('admin.pages.user_edit') : __('admin.pages.user_create'))
@section('content')
<div class="admin-page admin-form-page">
    <form method="POST" action="{{ $item->exists ? route('admin.users.update', $item) : route('admin.users.store') }}" class="admin-form-shell">
        @csrf @if($item->exists) @method('PUT') @endif
        @include('admin.partials.form-section-start', ['title' => __('admin.nav.users'), 'icon' => 'users'])
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.name') }}<span class="admin-required">*</span></label><input type="text" name="name" value="{{ old('name', $item->name) }}" required class="admin-input"></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.email') }}<span class="admin-required">*</span></label><input type="email" name="email" value="{{ old('email', $item->email) }}" required class="admin-input" dir="ltr"></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.password') }}{{ $item->exists ? '' : ' *' }}</label><input type="password" name="password" {{ $item->exists ? '' : 'required' }} class="admin-input" dir="ltr" placeholder="••••••••"></div>
        <div class="admin-field"><label class="admin-label">{{ __('admin.fields.role') }}</label><select name="role_id" class="admin-select"><option value="">{{ __('admin.common.none') }}</option>@foreach($roles as $r)<option value="{{ $r->id }}" {{ old('role_id', $item->role_id) == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>@endforeach</select></div>
        <label class="admin-toggle"><span class="admin-toggle-label">{{ __('admin.fields.active') }}</span><input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}></label>
        @include('admin.partials.form-section-end')
        @include('admin.partials.form-actions', ['backRoute' => route('admin.users.index')])
    </form>
</div>
@endsection
