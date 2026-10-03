<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Project;
use App\Models\Testimonial;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $alNoor = Project::where('slug', 'alnoor-retail-platform')->first();

        $testimonials = [
            [
                'client_name' => 'Ahmed Al-Rashid',
                'client_title' => 'CEO',
                'client_company' => 'AlNoor Trading Co.',
                'content' => $this->t(
                    'حوّلت Ytech أعمالنا التجزئية بمنصة تتعامل مع آلاف الطلبات يومياً. فهم فريقهم سوقنا وقدّموا أكثر مما توقعنا.',
                    'Ytech transformed our retail business with a platform that handles thousands of orders daily. Their team understood our market and delivered beyond expectations.'
                ),
                'rating' => 5,
                'project_id' => $alNoor?->id,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Dr. Sarah Al-Mutairi',
                'client_title' => 'Director of Operations',
                'client_company' => 'MedTrack Clinics',
                'content' => $this->t(
                    'أحدث تطبيق MedTrack ثورة في طريقة حجز مرضانا للمواعيد. قدمت Ytech منتجاً مصقولاً وموثوقاً في الوقت المحدد وضمن الميزانية.',
                    'The MedTrack app has revolutionized how our patients book appointments. Ytech delivered a polished, reliable product on time and within budget.'
                ),
                'rating' => 5,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Khalid Al-Otaibi',
                'client_title' => 'Operations Manager',
                'client_company' => 'Gulf Logistics Group',
                'content' => $this->t(
                    'خفّفت لوحة تتبع الأسطول لدينا تأخير التسليم بنسبة 35%. كان فريق Ytech سريع الاستجابة ومحترفاً ومستثمراً حقاً في نجاحنا.',
                    'Our fleet tracking dashboard reduced delivery delays by 35%. The Ytech team was responsive, professional, and truly invested in our success.'
                ),
                'rating' => 5,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'Fatima Al-Harbi',
                'client_title' => 'CTO',
                'client_company' => 'FinServe Capital',
                'content' => $this->t(
                    'كان الأمان والامتثال غير قابلين للتفاوض. بنت Ytech بوابة تلبي متطلبات SAMA مع تجربة مستخدم ممتازة.',
                    'Security and compliance were non-negotiable for us. Ytech built a portal that meets SAMA requirements while providing an excellent user experience.'
                ),
                'rating' => 5,
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['client_name' => $testimonial['client_name'], 'client_company' => $testimonial['client_company']],
                array_merge($testimonial, ['status' => ContentStatus::Published])
            );
        }
    }
}
