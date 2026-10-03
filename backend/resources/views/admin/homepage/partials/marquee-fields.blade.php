@php
    $content = $section->content ?? [];
    $items = $content['items'] ?? [];
    $itemCount = max(8, count($items));
@endphp

@include('admin.partials.form-section-start', ['title' => __('admin.fields.marquee_items'), 'icon' => 'edit'])
<p class="admin-help" style="margin-bottom: 1rem;">{{ __('admin.fields.marquee_help') }}</p>
@for ($i = 0; $i < $itemCount; $i++)
    @include('admin.partials.bilingual-field', [
        'name' => 'marquee_item_'.$i,
        'label' => __('admin.fields.marquee_item').' '.($i + 1),
        'value' => \App\Support\Translator::splitForForm($items[$i] ?? ''),
    ])
@endfor
<input type="hidden" name="items_count" value="{{ $itemCount }}">
@include('admin.partials.form-section-end')
