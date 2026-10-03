@php
    $content = $section->content ?? [];
    $field = fn (string $key) => \App\Support\Translator::splitForForm($content[$key] ?? '');
    $items = $content['items'] ?? [];
    if ($items === []) {
        $items = [['title' => ['ar' => '', 'en' => ''], 'description' => ['ar' => '', 'en' => '']]];
    }
    $clientsImage = ! empty($content['image_media_id'])
        ? \App\Models\MediaFile::find($content['image_media_id'])
        : null;
@endphp

@include('admin.partials.form-section-start', ['title' => __('admin.fields.description'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'badge_text',
    'label' => __('admin.fields.badge_text'),
    'value' => $field('badge_text'),
])
@include('admin.partials.bilingual-field', [
    'name' => 'description',
    'label' => __('admin.fields.description'),
    'value' => $field('description'),
    'type' => 'textarea',
    'rows' => 3,
])
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.fields.focus_items'), 'icon' => 'statistics'])
<div class="admin-focus-items" id="focus-items-root">
    <div class="admin-focus-items__list" id="focus-items-list">
        @foreach($items as $i => $item)
            <div class="admin-focus-item" data-focus-item>
                <div class="admin-focus-item__header">
                    <strong class="admin-focus-item__label">{{ __('admin.fields.focus_item') }} {{ $i + 1 }}</strong>
                    <button type="button" class="admin-features-remove" data-remove-focus-item aria-label="{{ __('admin.actions.delete') }}">&times;</button>
                </div>
                @include('admin.partials.bilingual-field', [
                    'name' => 'item_'.$i.'_title',
                    'label' => __('admin.fields.title'),
                    'value' => \App\Support\Translator::splitForForm($item['title'] ?? ''),
                ])
                @include('admin.partials.bilingual-field', [
                    'name' => 'item_'.$i.'_description',
                    'label' => __('admin.fields.description'),
                    'value' => \App\Support\Translator::splitForForm($item['description'] ?? ''),
                    'type' => 'textarea',
                    'rows' => 2,
                ])
            </div>
        @endforeach
    </div>

    <input type="hidden" name="items_count" id="focus-items-count" value="{{ count($items) }}">

    <button type="button" class="admin-btn-secondary" id="add-focus-item" style="margin-top: 0.75rem;">
        + {{ __('admin.fields.add_focus_item') }}
    </button>
</div>

<template id="focus-item-template">
    <div class="admin-focus-item" data-focus-item>
        <div class="admin-focus-item__header">
            <strong class="admin-focus-item__label">{{ __('admin.fields.focus_item') }}</strong>
            <button type="button" class="admin-features-remove" data-remove-focus-item aria-label="{{ __('admin.actions.delete') }}">&times;</button>
        </div>
        <div class="admin-bilingual">
            <div class="admin-bilingual-header">
                <span class="admin-bilingual-title">{{ __('admin.fields.title') }}</span>
            </div>
            <div class="admin-bilingual-grid">
                <div class="admin-bilingual-col">
                    <div class="admin-bilingual-lang ar"><span class="admin-lang-dot"></span> {{ __('admin.fields.arabic') }}</div>
                    <input type="text" data-field="title_ar" class="admin-input" dir="rtl" placeholder="{{ __('admin.fields.arabic') }}...">
                </div>
                <div class="admin-bilingual-col">
                    <div class="admin-bilingual-lang en"><span class="admin-lang-dot en"></span> {{ __('admin.fields.english') }}</div>
                    <input type="text" data-field="title_en" class="admin-input" dir="ltr" placeholder="English...">
                </div>
            </div>
        </div>
        <div class="admin-bilingual">
            <div class="admin-bilingual-header">
                <span class="admin-bilingual-title">{{ __('admin.fields.description') }}</span>
            </div>
            <div class="admin-bilingual-grid">
                <div class="admin-bilingual-col">
                    <div class="admin-bilingual-lang ar"><span class="admin-lang-dot"></span> {{ __('admin.fields.arabic') }}</div>
                    <textarea data-field="description_ar" rows="2" class="admin-textarea" dir="rtl" placeholder="{{ __('admin.fields.arabic') }}..."></textarea>
                </div>
                <div class="admin-bilingual-col">
                    <div class="admin-bilingual-lang en"><span class="admin-lang-dot en"></span> {{ __('admin.fields.english') }}</div>
                    <textarea data-field="description_en" rows="2" class="admin-textarea" dir="ltr" placeholder="English..."></textarea>
                </div>
            </div>
        </div>
    </div>
</template>
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.fields.focus_image'), 'icon' => 'media'])
@include('admin.partials.image-upload-field', [
    'current' => $clientsImage,
    'inputName' => 'clients_image',
    'removeName' => 'remove_clients_image',
    'altName' => 'clients_image_alt',
    'label' => __('admin.fields.focus_image'),
])
@include('admin.partials.form-section-end')

<script>
document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('focus-items-root');
    if (!root) return;

    const list = document.getElementById('focus-items-list');
    const countInput = document.getElementById('focus-items-count');
    const addBtn = document.getElementById('add-focus-item');
    const template = document.getElementById('focus-item-template');
    const itemLabel = @json(__('admin.fields.focus_item'));

    const reindex = () => {
        [...list.querySelectorAll('[data-focus-item]')].forEach((item, index) => {
            const label = item.querySelector('.admin-focus-item__label');
            if (label) label.textContent = `${itemLabel} ${index + 1}`;

            item.querySelectorAll('[data-field]').forEach((field) => {
                const key = field.getAttribute('data-field');
                if (key === 'title_ar') field.name = `item_${index}_title_ar`;
                if (key === 'title_en') field.name = `item_${index}_title_en`;
                if (key === 'description_ar') field.name = `item_${index}_description_ar`;
                if (key === 'description_en') field.name = `item_${index}_description_en`;
            });

            item.querySelectorAll('[name^="item_"]').forEach((field) => {
                field.name = field.name.replace(/item_\d+_/, `item_${index}_`);
            });
        });
        countInput.value = list.querySelectorAll('[data-focus-item]').length;
    };

    addBtn?.addEventListener('click', () => {
        const node = template.content.firstElementChild.cloneNode(true);
        list.appendChild(node);
        reindex();
    });

    list.addEventListener('click', (event) => {
        const removeBtn = event.target.closest('[data-remove-focus-item]');
        if (!removeBtn) return;
        const item = removeBtn.closest('[data-focus-item]');
        if (!item) return;
        if (list.querySelectorAll('[data-focus-item]').length <= 1) {
            item.querySelectorAll('input, textarea').forEach((el) => { el.value = ''; });
            return;
        }
        item.remove();
        reindex();
    });
});
</script>
<style>
.admin-focus-item {
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(15, 23, 42, 0.08);
}
.admin-focus-item__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}
</style>
