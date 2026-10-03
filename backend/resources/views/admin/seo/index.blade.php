@extends('layouts.admin')
@section('title', __('admin.pages.seo'))
@section('content')
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>{{ __('admin.fields.page_key') }}</th><th>{{ __('admin.fields.meta_title') }}</th><th>{{ __('admin.fields.actions') }}</th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td class="admin-mono" dir="ltr">{{ $item->page_key }}</td>
                <td>{{ \Illuminate\Support\Str::limit($item->translate('meta_title'), 50) }}</td>
                <td>@include('admin.partials.crud-actions', ['editRoute' => route('admin.seo.edit', $item)])</td>
            </tr>
            @empty
            <tr><td colspan="3" class="admin-table-empty">{{ __('admin.common.no_items') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
