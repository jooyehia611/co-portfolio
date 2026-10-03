<?php

use App\Models\HomepageSection;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $hero = HomepageSection::query()->where('section_key', 'hero')->first();

        if (! $hero) {
            return;
        }

        $content = $hero->content ?? [];

        $defaults = [
            'kicker' => ['ar' => 'شريكك في التحول الرقمي', 'en' => 'Your partner in digital transformation'],
            'headline_line1_prefix' => ['ar' => 'نبني', 'en' => 'We build'],
            'headline_line1_accent' => ['ar' => 'حلول رقمية', 'en' => 'digital solutions'],
            'headline_line2' => ['ar' => 'تحول أفكارك إلى منتجات ناجحة.', 'en' => 'that turn ideas into successful products.'],
            'description' => [
                'ar' => 'نصمم ونطور منصات ويب وتطبيقات جوال وأنظمة أعمال تساعد الشركات على النمو بكفاءة وتحقيق أهدافها.',
                'en' => 'We design and develop web platforms, mobile apps, and business systems that help companies grow with efficiency and achieve their goals.',
            ],
            'float_grow_title' => ['ar' => 'نمِّ', 'en' => 'Grow'],
            'float_grow_sub' => ['ar' => 'أعمالك', 'en' => 'Your Business'],
            'float_idea_title' => ['ar' => 'من الفكرة', 'en' => 'From Idea'],
            'float_idea_sub' => ['ar' => 'إلى منتج قابل للتوسع', 'en' => 'to Scalable Product'],
            'script_line1' => ['ar' => 'Ideas', 'en' => 'Ideas'],
            'script_line2' => ['ar' => 'To Impact', 'en' => 'To Impact'],
        ];

        foreach ($defaults as $key => $value) {
            if (empty($content[$key])) {
                $content[$key] = $value;
            }
        }

        if (empty($content['cta_primary']['label'])) {
            $content['cta_primary'] = [
                'label' => ['ar' => 'ابدأ مشروعك الآن', 'en' => 'Start your project now'],
                'url' => $content['cta_primary']['url'] ?? '/contact',
            ];
        }

        if (empty($content['cta_secondary']['label'])) {
            $content['cta_secondary'] = [
                'label' => ['ar' => 'شاهد أعمالنا', 'en' => 'See our work'],
                'url' => $content['cta_secondary']['url'] ?? '/work',
            ];
        }

        unset(
            $content['capabilities'],
            $content['eyebrow_brand'],
            $content['eyebrow_tagline'],
            $content['panel_eyebrow'],
            $content['panel_title'],
            $content['float_top_label'],
            $content['image_media_id'],
        );

        $hero->update([
            'content' => $content,
            'title' => $content['headline_line1_prefix'] ?? $hero->title,
            'subtitle' => $content['description'] ?? $hero->subtitle,
        ]);
    }

    public function down(): void
    {
        // Non-destructive content reshape — no rollback.
    }
};
