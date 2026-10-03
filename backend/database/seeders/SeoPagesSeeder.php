<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class SeoPagesSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $pages = [
            [
                'page_key' => 'home',
                'slug' => '/',
                'page_title' => $this->t('Ytech | السعودية', 'Ytech | Saudi Arabia'),
                'page_description' => null,
                'meta_title' => $this->t('Ytech | شركة تطوير برمجيات في السعودية', 'Ytech | Software Development Company in Saudi Arabia'),
                'meta_description' => $this->t(
                    'Ytech تبني تطبيقات ويب مخصصة وتطبيقات جوال وحلول مؤسسية للشركات في السعودية والخليج.',
                    'Ytech builds custom web applications, mobile apps, and enterprise solutions for businesses across Saudi Arabia and the GCC.'
                ),
                'og_title' => $this->t('Ytech - نبني حلولاً رقمية قابلة للتوسع', 'Ytech - Building Digital Solutions That Scale'),
                'og_description' => $this->t(
                    'شارك Ytech في تطوير الويب والجوال والتجارة الإلكترونية والحلول السحابية.',
                    'Partner with Ytech for web development, mobile apps, e-commerce, and cloud solutions.'
                ),
                'is_indexable' => true,
            ],
            [
                'page_key' => 'about',
                'slug' => '/about',
                'page_title' => $this->t('من نحن', 'About Us'),
                'page_description' => $this->t(
                    'نبني حلولًا رقمية تساعد الشركات على النمو والتطور.',
                    'We build digital solutions that help businesses grow and evolve.'
                ),
                'meta_title' => $this->t('عن Ytech | فريقنا ورسالتنا', 'About Ytech | Our Team & Mission'),
                'meta_description' => $this->t(
                    'تعرف على Ytech، شركة سعودية لتطوير البرمجيات ملتزمة بتحويل الأعمال عبر التقنية منذ 2018.',
                    'Learn about Ytech, a Saudi software development company dedicated to transforming businesses through technology since 2018.'
                ),
                'is_indexable' => true,
            ],
            [
                'page_key' => 'services',
                'slug' => '/services',
                'page_title' => $this->t('تقنية مبنية حول عملك.', 'Technology built around your business.'),
                'page_description' => $this->t(
                    'قدرات برمجية متكاملة للمؤسسات المستعدة للاستثمار في بنية رقمية مستدامة.',
                    'End-to-end software capabilities for organizations ready to invest in lasting digital infrastructure.'
                ),
                'meta_title' => $this->t('خدماتنا | تطوير الويب والجوال والسحابة', 'Our Services | Web, Mobile & Cloud Development'),
                'meta_description' => $this->t(
                    'استكشف خدمات Ytech: تطوير تطبيقات الويب والجوال والتجارة الإلكترونية وتصميم UI/UX وDevOps والاستشارات.',
                    'Explore Ytech services: web application development, mobile apps, e-commerce, UI/UX design, cloud DevOps, and IT consulting.'
                ),
                'is_indexable' => true,
            ],
            [
                'page_key' => 'projects',
                'slug' => '/projects',
                'page_title' => $this->t('أعمال مختارة.', 'Selected work.'),
                'page_description' => $this->t(
                    'دراسات حالة من منصات مؤسسية ومنتجات SaaS وأنظمة أعمال حرجة.',
                    'Case studies from enterprise platforms, SaaS products, and mission-critical business systems.'
                ),
                'meta_title' => $this->t('معرض الأعمال | مشاريع Ytech', 'Portfolio & Case Studies | Ytech Projects'),
                'meta_description' => $this->t(
                    'اطلع على محفظة Ytech من المشاريع الناجحة بما فيها منصات التجارة الإلكترونية وتطبيقات الرعاية الصحية.',
                    'View Ytech portfolio of successful projects including e-commerce platforms, healthcare apps, and enterprise dashboards.'
                ),
                'is_indexable' => true,
            ],
            [
                'page_key' => 'contact',
                'slug' => '/contact',
                'page_title' => $this->t('لنبدأ محادثة', 'Start a conversation'),
                'page_description' => $this->t(
                    'أخبرنا عن مشروعك. نرد خلال يوم عمل واحد.',
                    'Tell us about your project. We respond within one business day.'
                ),
                'meta_title' => $this->t('تواصل مع Ytech | ابدأ مشروعك', 'Contact Ytech | Start Your Project'),
                'meta_description' => $this->t(
                    'تواصل مع Ytech لاستشارة مجانية. نرد خلال 24 ساعة.',
                    'Get in touch with Ytech for a free consultation. We respond within 24 hours.'
                ),
                'is_indexable' => true,
            ],
            [
                'page_key' => 'reviews',
                'slug' => '/reviews',
                'page_title' => $this->t('اسمع التجربة من أصحابها.', 'Hear it from our clients.'),
                'page_description' => $this->t(
                    'تجارب حقيقية يحكيها عملاؤنا بأصواتهم.',
                    'Real stories, shared in the voices of the people we work with.'
                ),
                'meta_title' => $this->t('آراء العملاء | Ytech', 'Client Reviews | Ytech'),
                'meta_description' => $this->t(
                    'تجارب حقيقية يحكيها عملاؤنا بأصواتهم.',
                    'Real stories, shared in the voices of the people we work with.'
                ),
                'is_indexable' => true,
            ],
        ];

        foreach ($pages as $page) {
            SeoPage::updateOrCreate(['page_key' => $page['page_key']], $page);
        }
    }
}
