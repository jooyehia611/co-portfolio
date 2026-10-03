@php
    $content = $section->content ?? [];
    $ctaPrimary = $content['cta_primary'] ?? [];
    $ctaSecondary = $content['cta_secondary'] ?? [];
    $ctaPrimaryLabel = \App\Support\Translator::splitForForm($ctaPrimary['label'] ?? '');
    $ctaSecondaryLabel = \App\Support\Translator::splitForForm($ctaSecondary['label'] ?? '');
    $field = fn (string $key) => \App\Support\Translator::splitForForm($content[$key] ?? '');
@endphp

<p class="admin-help" style="margin-bottom: 1.25rem;">
    {{ __('admin.hero.page_help') }}
</p>

@include('admin.partials.form-section-start', ['title' => __('admin.hero.kicker_section'), 'icon' => 'settings'])
@include('admin.partials.bilingual-field', [
    'name' => 'kicker',
    'label' => __('admin.hero.kicker'),
    'value' => $field('kicker'),
])
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.hero.headline_section'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'headline_line1_prefix',
    'label' => __('admin.hero.headline_line1_prefix'),
    'value' => $field('headline_line1_prefix'),
])
@include('admin.partials.bilingual-field', [
    'name' => 'headline_line1_accent',
    'label' => __('admin.hero.headline_line1_accent'),
    'value' => $field('headline_line1_accent'),
])
@include('admin.partials.bilingual-field', [
    'name' => 'headline_line2',
    'label' => __('admin.hero.headline_line2'),
    'value' => $field('headline_line2'),
])
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.hero.description_section'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'description',
    'label' => __('admin.hero.description'),
    'value' => $field('description'),
    'type' => 'textarea',
])
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.hero.cta_section'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'cta_primary_label',
    'label' => __('admin.hero.cta_primary'),
    'value' => $ctaPrimaryLabel,
])
<div class="admin-field">
    <label class="admin-label">{{ __('admin.hero.cta_primary_url') }}</label>
    <input type="text" name="cta_primary_url" value="{{ old('cta_primary_url', $ctaPrimary['url'] ?? '/contact') }}" class="admin-input" dir="ltr">
</div>
@include('admin.partials.bilingual-field', [
    'name' => 'cta_secondary_label',
    'label' => __('admin.hero.cta_secondary'),
    'value' => $ctaSecondaryLabel,
])
<div class="admin-field">
    <label class="admin-label">{{ __('admin.hero.cta_secondary_url') }}</label>
    <input type="text" name="cta_secondary_url" value="{{ old('cta_secondary_url', $ctaSecondary['url'] ?? '/work') }}" class="admin-input" dir="ltr">
</div>
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.hero.floats_section'), 'icon' => 'settings'])
@include('admin.partials.bilingual-field', [
    'name' => 'float_grow_title',
    'label' => __('admin.hero.float_grow_title'),
    'value' => $field('float_grow_title'),
])
@include('admin.partials.bilingual-field', [
    'name' => 'float_grow_sub',
    'label' => __('admin.hero.float_grow_sub'),
    'value' => $field('float_grow_sub'),
])
@include('admin.partials.bilingual-field', [
    'name' => 'float_idea_title',
    'label' => __('admin.hero.float_idea_title'),
    'value' => $field('float_idea_title'),
])
@include('admin.partials.bilingual-field', [
    'name' => 'float_idea_sub',
    'label' => __('admin.hero.float_idea_sub'),
    'value' => $field('float_idea_sub'),
])
@include('admin.partials.form-section-end')

@include('admin.partials.form-section-start', ['title' => __('admin.hero.script_section'), 'icon' => 'edit'])
@include('admin.partials.bilingual-field', [
    'name' => 'script_line1',
    'label' => __('admin.hero.script_line1'),
    'value' => $field('script_line1'),
])
@include('admin.partials.bilingual-field', [
    'name' => 'script_line2',
    'label' => __('admin.hero.script_line2'),
    'value' => $field('script_line2'),
])
@include('admin.partials.form-section-end')
