<?php

namespace Database\Seeders;

use App\Models\Setting;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $settings = [
            ['key' => 'company_name', 'value' => $this->t('Ytech', 'Ytech'), 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_title', 'value' => $this->t('Ytech | السعودية', 'Ytech | Saudi Arabia'), 'group' => 'general', 'type' => 'text'],
            ['key' => 'tagline', 'value' => $this->t('نبني حلولاً رقمية قابلة للتوسع', 'Building Digital Solutions That Scale'), 'group' => 'general', 'type' => 'text'],
            ['key' => 'email', 'value' => 'hello@ytech.com', 'group' => 'contact', 'type' => 'email'],
            ['key' => 'phone', 'value' => '+966 50 123 4567', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'address', 'value' => $this->t('طريق الملك فهد، الرياض، المملكة العربية السعودية', 'King Fahd Road, Riyadh, Saudi Arabia'), 'group' => 'contact', 'type' => 'textarea'],
            ['key' => 'about_summary', 'value' => $this->t(
                'Ytech شركة سعودية متخصصة في تطوير البرمجيات، تشمل تطبيقات الويب والجوال والحلول المؤسسية. منذ 2018، ساعدنا الشركات في أنحاء الخليج على تحويل حضورها الرقمي.',
                'Ytech is a Saudi-based software development company specializing in web applications, mobile apps, and enterprise solutions. Since 2018, we have helped businesses across the GCC transform their digital presence.'
            ), 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'about_mission', 'value' => $this->t(
                'تمكين الشركات من خلال حلول تقنية مبتكرة تعزز النمو والكفاءة والميزة التنافسية في الاقتصاد الرقمي.',
                'To empower businesses with innovative technology solutions that drive growth, efficiency, and competitive advantage in the digital economy.'
            ), 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'about_vision', 'value' => $this->t(
                'أن نكون الشريك التقني الرائد للمؤسسات في الشرق الأوسط، المعروفين بالتميز والموثوقية والابتكار.',
                'To become the leading technology partner for enterprises across the Middle East, known for excellence, reliability, and innovation.'
            ), 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/ytech', 'group' => 'social', 'type' => 'url'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/ytech', 'group' => 'social', 'type' => 'url'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/ytech', 'group' => 'social', 'type' => 'url'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/ytech', 'group' => 'social', 'type' => 'url'],
            ['key' => 'github_url', 'value' => 'https://github.com/ytech', 'group' => 'social', 'type' => 'url'],
            ['key' => 'footer_text', 'value' => $this->t('© 2026 Ytech. جميع الحقوق محفوظة.', '© 2026 Ytech. All rights reserved.'), 'group' => 'general', 'type' => 'text'],
            ['key' => 'logo_id', 'value' => null, 'group' => 'general', 'type' => 'media'],
            ['key' => 'favicon_id', 'value' => null, 'group' => 'general', 'type' => 'media'],
            ['key' => 'default_og_image_id', 'value' => null, 'group' => 'general', 'type' => 'media'],
        ];

        foreach ($settings as $setting) {
            if (is_array($setting['value'])) {
                $setting['value'] = json_encode($setting['value'], JSON_UNESCAPED_UNICODE);
            }
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
