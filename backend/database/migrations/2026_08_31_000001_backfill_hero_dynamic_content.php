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
            'eyebrow_brand' => ['ar' => 'Y—TECH / DIGITAL ENGINEERING', 'en' => 'Y—TECH / DIGITAL ENGINEERING'],
            'eyebrow_tagline' => ['ar' => 'هندسة المنتجات والأنظمة الرقمية', 'en' => 'Digital products & systems engineering'],
            'headline_line1_prefix' => ['ar' => 'نبني ', 'en' => 'We build '],
            'headline_line1_accent' => ['ar' => 'منتجات رقمية', 'en' => 'digital products'],
            'headline_line2' => ['ar' => 'تخدم أعمالًا حقيقية.', 'en' => 'for real businesses.'],
            'description' => [
                'ar' => 'نصمم ونطور منصات ويب، تطبيقات موبايل، وأنظمة أعمال مخصصة تساعد الشركات على العمل بكفاءة والنمو بثقة.',
                'en' => 'We design and develop web platforms, mobile applications, and custom business systems that help companies operate efficiently and grow with confidence.',
            ],
            'capabilities' => [
                'web' => ['ar' => 'WEB PLATFORMS', 'en' => 'WEB PLATFORMS'],
                'mobile' => ['ar' => 'MOBILE APPS', 'en' => 'MOBILE APPS'],
                'systems' => ['ar' => 'BUSINESS SYSTEMS', 'en' => 'BUSINESS SYSTEMS'],
                'custom' => ['ar' => 'CUSTOM SOFTWARE', 'en' => 'CUSTOM SOFTWARE'],
            ],
        ];

        foreach ($defaults as $key => $value) {
            if ($key === 'capabilities') {
                $content['capabilities'] = $content['capabilities'] ?? [];
                foreach ($value as $capKey => $capValue) {
                    if (empty($content['capabilities'][$capKey])) {
                        $content['capabilities'][$capKey] = $capValue;
                    }
                }

                continue;
            }

            if (empty($content[$key])) {
                $content[$key] = $value;
            }
        }

        $hero->update([
            'content' => $content,
            'title' => $content['headline_line1_prefix'] ?? $hero->title,
            'subtitle' => $content['description'] ?? $hero->subtitle,
        ]);
    }

    public function down(): void
    {
        // Non-destructive backfill — no rollback needed.
    }
};
