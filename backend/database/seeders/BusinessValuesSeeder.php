<?php

namespace Database\Seeders;

use App\Models\BusinessValue;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class BusinessValuesSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $values = [
            [
                'title' => $this->t('الجودة أولاً', 'Quality First'),
                'description' => $this->t(
                    'لا نساوم أبداً على جودة الكود أو الأمان أو تجربة المستخدم. كل سطر كود يُراجع ويُختبر.',
                    'We never compromise on code quality, security, or user experience. Every line of code is reviewed and tested.'
                ),
                'icon' => 'shield-check',
                'sort_order' => 1,
            ],
            [
                'title' => $this->t('الشفافية', 'Transparency'),
                'description' => $this->t(
                    'تواصل واضح وجداول زمنية صادقة وتحديثات منتظمة تبقيك مسيطراً على مشروعك.',
                    'Clear communication, honest timelines, and regular progress updates keep you in control of your project.'
                ),
                'icon' => 'eye',
                'sort_order' => 2,
            ],
            [
                'title' => $this->t('الابتكار', 'Innovation'),
                'description' => $this->t(
                    'نواكب اتجاهات التقنية لنقدم حلولاً حديثة ومستقبلية لعملك.',
                    'We stay ahead of technology trends to deliver modern, future-proof solutions for your business.'
                ),
                'icon' => 'lightbulb',
                'sort_order' => 3,
            ],
            [
                'title' => $this->t('الشراكة', 'Partnership'),
                'description' => $this->t(
                    'نعامل كل عميل كشريك طويل الأمد، مهتمون بنجاحك بعد تسليم المشروع.',
                    'We treat every client as a long-term partner, invested in your success beyond project delivery.'
                ),
                'icon' => 'handshake',
                'sort_order' => 4,
            ],
        ];

        foreach ($values as $value) {
            BusinessValue::updateOrCreate(['sort_order' => $value['sort_order']], $value);
        }
    }
}
