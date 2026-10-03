<?php

use App\Models\HomepageSection;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $section = HomepageSection::query()->where('section_key', 'clients')->first();

        if (! $section) {
            return;
        }

        $section->update([
            'title' => [
                'ar' => 'حلول رقمية لاحتياجات أعمال حقيقية',
                'en' => 'Digital solutions for real business needs',
            ],
            'content' => [
                'description' => [
                    'ar' => 'نصمم ونطور منتجات مخصصة — بدون قوالب جاهزة — لقطاعات وتحديات متنوعة.',
                    'en' => 'We design and build tailored products — not templates — for diverse sectors and challenges.',
                ],
                'items' => [
                    [
                        'title' => ['ar' => 'الشركات والمؤسسات', 'en' => 'Companies & enterprises'],
                        'description' => [
                            'ar' => 'منصات وأنظمة تشغيلية تدعم عملياتك اليومية.',
                            'en' => 'Operational platforms and systems for day-to-day business.',
                        ],
                    ],
                    [
                        'title' => ['ar' => 'الشركات الناشئة', 'en' => 'Startups'],
                        'description' => [
                            'ar' => 'منتجات رقمية من الفكرة إلى الإطلاق بسرعة ووضوح.',
                            'en' => 'Digital products from idea to launch with clarity.',
                        ],
                    ],
                    [
                        'title' => ['ar' => 'القطاع الخدمي', 'en' => 'Service industries'],
                        'description' => [
                            'ar' => 'تجارب رقمية احترافية لعملائك وشركائك.',
                            'en' => 'Professional digital experiences for clients and partners.',
                        ],
                    ],
                    [
                        'title' => ['ar' => 'المؤسسات الكبرى', 'en' => 'Large organizations'],
                        'description' => [
                            'ar' => 'حلول قابلة للتوسع بمعايير جودة عالية.',
                            'en' => 'Scalable solutions built to high quality standards.',
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function down(): void
    {
        // Non-destructive content update.
    }
};
