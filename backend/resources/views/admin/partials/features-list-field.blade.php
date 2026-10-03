@php
    $featureGroups = $featureGroups ?? [];

    if (old('feature_groups')) {
        $featureGroups = collect(old('feature_groups'))
            ->map(function ($group) {
                return [
                    'title' => [
                        'ar' => $group['title_ar'] ?? '',
                        'en' => $group['title_en'] ?? '',
                    ],
                    'points' => collect($group['points'] ?? [])
                        ->map(fn ($point) => [
                            'ar' => $point['ar'] ?? '',
                            'en' => $point['en'] ?? '',
                        ])
                        ->values()
                        ->all(),
                ];
            })
            ->values()
            ->all();
    }

    if ($featureGroups === []) {
        $featureGroups = [[
            'title' => ['ar' => '', 'en' => ''],
            'points' => [['ar' => '', 'en' => '']],
        ]];
    }
@endphp

<div class="admin-features-field" id="feature-groups-root">
    <p class="admin-help admin-features-field__help">{{ __('admin.fields.key_features_help') }}</p>

    <div class="admin-feature-groups" id="feature-groups-list">
        @foreach($featureGroups as $groupIndex => $group)
            <div class="admin-feature-group" data-feature-group>
                <div class="admin-feature-group__header">
                    <strong>{{ __('admin.fields.key_features_group') }} {{ $groupIndex + 1 }}</strong>
                    <button type="button" class="admin-features-remove admin-feature-group__remove" data-remove-group aria-label="{{ __('admin.actions.delete') }}">
                        &times;
                    </button>
                </div>

                <div class="admin-bilingual-grid">
                    <div class="admin-bilingual-col">
                        <div class="admin-bilingual-lang ar">
                            <span class="admin-lang-dot"></span>
                            {{ __('admin.fields.arabic') }}
                        </div>
                        <input
                            type="text"
                            name="feature_groups[{{ $groupIndex }}][title_ar]"
                            value="{{ $group['title']['ar'] ?? '' }}"
                            class="admin-input"
                            dir="rtl"
                            placeholder="{{ __('admin.fields.key_features_group_title_ar') }}"
                        >
                    </div>
                    <div class="admin-bilingual-col">
                        <div class="admin-bilingual-lang en">
                            <span class="admin-lang-dot en"></span>
                            {{ __('admin.fields.english') }}
                        </div>
                        <input
                            type="text"
                            name="feature_groups[{{ $groupIndex }}][title_en]"
                            value="{{ $group['title']['en'] ?? '' }}"
                            class="admin-input"
                            dir="ltr"
                            placeholder="{{ __('admin.fields.key_features_group_title_en') }}"
                        >
                    </div>
                </div>

                <div class="admin-features-field__points-label">{{ __('admin.fields.key_features_points') }}</div>

                <div class="admin-features-list" data-points-list>
                    @foreach($group['points'] ?? [['ar' => '', 'en' => '']] as $pointIndex => $point)
                        <div class="admin-features-row" data-feature-row>
                            <div class="admin-bilingual-grid">
                                <div class="admin-bilingual-col">
                                    <input
                                        type="text"
                                        name="feature_groups[{{ $groupIndex }}][points][{{ $pointIndex }}][ar]"
                                        value="{{ $point['ar'] ?? '' }}"
                                        class="admin-input"
                                        dir="rtl"
                                        placeholder="{{ __('admin.fields.key_feature_placeholder_ar') }}"
                                    >
                                </div>
                                <div class="admin-bilingual-col">
                                    <input
                                        type="text"
                                        name="feature_groups[{{ $groupIndex }}][points][{{ $pointIndex }}][en]"
                                        value="{{ $point['en'] ?? '' }}"
                                        class="admin-input"
                                        dir="ltr"
                                        placeholder="{{ __('admin.fields.key_feature_placeholder_en') }}"
                                    >
                                </div>
                            </div>
                            <button type="button" class="admin-features-remove" data-remove-point aria-label="{{ __('admin.actions.delete') }}">&times;</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="admin-btn-secondary admin-features-add" data-add-point>
                    + {{ __('admin.fields.add_feature') }}
                </button>
            </div>
        @endforeach
    </div>

    <button type="button" class="admin-btn-secondary admin-feature-group-add" id="add-feature-group">
        + {{ __('admin.fields.add_feature_group') }}
    </button>
</div>

<template id="feature-group-template">
    <div class="admin-feature-group" data-feature-group>
        <div class="admin-feature-group__header">
            <strong>{{ __('admin.fields.key_features_group') }}</strong>
            <button type="button" class="admin-features-remove admin-feature-group__remove" data-remove-group aria-label="{{ __('admin.actions.delete') }}">&times;</button>
        </div>
        <div class="admin-bilingual-grid">
            <div class="admin-bilingual-col">
                <div class="admin-bilingual-lang ar"><span class="admin-lang-dot"></span> {{ __('admin.fields.arabic') }}</div>
                <input type="text" data-name="title_ar" class="admin-input" dir="rtl" placeholder="{{ __('admin.fields.key_features_group_title_ar') }}">
            </div>
            <div class="admin-bilingual-col">
                <div class="admin-bilingual-lang en"><span class="admin-lang-dot en"></span> {{ __('admin.fields.english') }}</div>
                <input type="text" data-name="title_en" class="admin-input" dir="ltr" placeholder="{{ __('admin.fields.key_features_group_title_en') }}">
            </div>
        </div>
        <div class="admin-features-field__points-label">{{ __('admin.fields.key_features_points') }}</div>
        <div class="admin-features-list" data-points-list></div>
        <button type="button" class="admin-btn-secondary admin-features-add" data-add-point>+ {{ __('admin.fields.add_feature') }}</button>
    </div>
</template>

<template id="feature-point-template">
    <div class="admin-features-row" data-feature-row>
        <div class="admin-bilingual-grid">
            <div class="admin-bilingual-col">
                <input type="text" data-name="point_ar" class="admin-input" dir="rtl" placeholder="{{ __('admin.fields.key_feature_placeholder_ar') }}">
            </div>
            <div class="admin-bilingual-col">
                <input type="text" data-name="point_en" class="admin-input" dir="ltr" placeholder="{{ __('admin.fields.key_feature_placeholder_en') }}">
            </div>
        </div>
        <button type="button" class="admin-features-remove" data-remove-point aria-label="{{ __('admin.actions.delete') }}">&times;</button>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const root = document.getElementById('feature-groups-root');
    const groupsList = document.getElementById('feature-groups-list');
    const groupTemplate = document.getElementById('feature-group-template');
    const pointTemplate = document.getElementById('feature-point-template');
    const addGroupBtn = document.getElementById('add-feature-group');

    if (!root || !groupsList || !groupTemplate || !pointTemplate || !addGroupBtn) return;

    function reindexGroups() {
        groupsList.querySelectorAll('[data-feature-group]').forEach((group, groupIndex) => {
            group.querySelector('.admin-feature-group__header strong').textContent =
                @json(__('admin.fields.key_features_group')) + ' ' + (groupIndex + 1);

            group.querySelector('input[data-name="title_ar"]')?.setAttribute('name', `feature_groups[${groupIndex}][title_ar]`);
            const titleAr = group.querySelector(`input[name="feature_groups[${groupIndex}][title_ar]"]`) ?? group.querySelector('input[data-name="title_ar"]');
            const titleEn = group.querySelector(`input[name="feature_groups[${groupIndex}][title_en]"]`) ?? group.querySelector('input[data-name="title_en"]');
            titleAr?.setAttribute('name', `feature_groups[${groupIndex}][title_ar]`);
            titleEn?.setAttribute('name', `feature_groups[${groupIndex}][title_en]`);

            group.querySelectorAll('[data-feature-row]').forEach((row, pointIndex) => {
                const ar = row.querySelector('input[data-name="point_ar"]') ?? row.querySelectorAll('input')[0];
                const en = row.querySelector('input[data-name="point_en"]') ?? row.querySelectorAll('input')[1];
                if (ar) ar.setAttribute('name', `feature_groups[${groupIndex}][points][${pointIndex}][ar]`);
                if (en) en.setAttribute('name', `feature_groups[${groupIndex}][points][${pointIndex}][en]`);
            });
        });
    }

    function addPoint(group) {
        const list = group.querySelector('[data-points-list]');
        const row = pointTemplate.content.cloneNode(true);
        list.appendChild(row);
        reindexGroups();
    }

    function addGroup() {
        const groupNode = groupTemplate.content.cloneNode(true);
        groupsList.appendChild(groupNode);
        const group = groupsList.lastElementChild;
        addPoint(group);
        reindexGroups();
    }

    addGroupBtn.addEventListener('click', addGroup);

    root.addEventListener('click', function (event) {
        const addPointBtn = event.target.closest('[data-add-point]');
        if (addPointBtn) {
            addPoint(addPointBtn.closest('[data-feature-group]'));
            return;
        }

        const removePointBtn = event.target.closest('[data-remove-point]');
        if (removePointBtn) {
            const group = removePointBtn.closest('[data-feature-group]');
            const rows = group.querySelectorAll('[data-feature-row]');
            if (rows.length <= 1) {
                rows[0].querySelectorAll('input').forEach((input) => { input.value = ''; });
            } else {
                removePointBtn.closest('[data-feature-row]')?.remove();
            }
            reindexGroups();
            return;
        }

        const removeGroupBtn = event.target.closest('[data-remove-group]');
        if (removeGroupBtn) {
            const groups = groupsList.querySelectorAll('[data-feature-group]');
            if (groups.length <= 1) {
                groups[0].querySelectorAll('input').forEach((input) => { input.value = ''; });
            } else {
                removeGroupBtn.closest('[data-feature-group]')?.remove();
            }
            reindexGroups();
        }
    });
});
</script>
