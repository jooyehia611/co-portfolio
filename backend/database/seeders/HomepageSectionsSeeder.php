<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class HomepageSectionsSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'hero',
                'title' => $this->t('نبني', 'We build'),
                'subtitle' => $this->t(
                    'نصمم ونطور منصات ويب وتطبيقات جوال وأنظمة أعمال تساعد الشركات على النمو بكفاءة وتحقيق أهدافها.',
                    'We design and develop web platforms, mobile apps, and business systems that help companies grow with efficiency and achieve their goals.'
                ),
                'content' => [
                    'kicker' => $this->t('شريكك في التحول الرقمي', 'Your partner in digital transformation'),
                    'headline_line1_prefix' => $this->t('نبني', 'We build'),
                    'headline_line1_accent' => $this->t('حلول رقمية', 'digital solutions'),
                    'headline_line2' => $this->t('تحول أفكارك إلى منتجات ناجحة.', 'that turn ideas into successful products.'),
                    'description' => $this->t(
                        'نصمم ونطور منصات ويب وتطبيقات جوال وأنظمة أعمال تساعد الشركات على النمو بكفاءة وتحقيق أهدافها.',
                        'We design and develop web platforms, mobile apps, and business systems that help companies grow with efficiency and achieve their goals.'
                    ),
                    'cta_primary' => ['label' => $this->t('ابدأ مشروعك الآن', 'Start your project now'), 'url' => '/contact'],
                    'cta_secondary' => ['label' => $this->t('شاهد أعمالنا', 'See our work'), 'url' => '/work'],
                    'float_grow_title' => $this->t('نمِّ', 'Grow'),
                    'float_grow_sub' => $this->t('أعمالك', 'Your Business'),
                    'float_idea_title' => $this->t('من الفكرة', 'From Idea'),
                    'float_idea_sub' => $this->t('إلى منتج قابل للتوسع', 'to Scalable Product'),
                    'script_line1' => $this->t('Ideas', 'Ideas'),
                    'script_line2' => $this->t('To Impact', 'To Impact'),
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'section_key' => 'clients',
                'title' => $this->t('حلول رقمية لاحتياجات أعمال حقيقية', 'Digital solutions for real business needs'),
                'subtitle' => $this->t('من نعمل معهم', 'Who we work with'),
                'content' => [
                    'badge_text' => $this->t('منذ البداية', 'Since day one'),
                    'description' => $this->t(
                        'نصمم ونطور منتجات مخصصة — بدون قوالب جاهزة — لقطاعات وتحديات متنوعة.',
                        'We design and build tailored products — not templates — for diverse sectors and challenges.'
                    ),
                    'items' => [
                        [
                            'title' => $this->t('الشركات والمؤسسات', 'Companies & enterprises'),
                            'description' => $this->t(
                                'منصات وأنظمة تشغيلية تدعم عملياتك اليومية.',
                                'Operational platforms and systems for day-to-day business.'
                            ),
                        ],
                        [
                            'title' => $this->t('الشركات الناشئة', 'Startups'),
                            'description' => $this->t(
                                'منتجات رقمية من الفكرة إلى الإطلاق بسرعة ووضوح.',
                                'Digital products from idea to launch with clarity.'
                            ),
                        ],
                        [
                            'title' => $this->t('القطاع الخدمي', 'Service industries'),
                            'description' => $this->t(
                                'تجارب رقمية احترافية لعملائك وشركائك.',
                                'Professional digital experiences for clients and partners.'
                            ),
                        ],
                        [
                            'title' => $this->t('المؤسسات الكبرى', 'Large organizations'),
                            'description' => $this->t(
                                'حلول قابلة للتوسع بمعايير جودة عالية.',
                                'Scalable solutions built to high quality standards.'
                            ),
                        ],
                    ],
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'section_key' => 'services',
                'title' => $this->t('تقنية مبنية حول عملك.', 'Technology Built Around Your Business.'),
                'subtitle' => $this->t('خدماتنا', 'Our Services'),
                'content' => ['description' => $this->t(
                    'قدرات برمجية متكاملة للمؤسسات المستعدة للاستثمار في بنية رقمية مستدامة.',
                    'End-to-end software capabilities for organizations ready to invest in lasting digital infrastructure.'
                )],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'section_key' => 'projects',
                'title' => $this->t('مشاريعنا.', 'Our Projects.'),
                'subtitle' => $this->t('معرض الأعمال', 'Portfolio'),
                'content' => ['description' => $this->t(
                    'حلول برمجية ومشاريع رقمية نفذناها لعملائنا عبر قطاعات متعددة.',
                    'Software solutions and digital products we have delivered across multiple industries.'
                )],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'section_key' => 'business_values',
                'title' => $this->t('أثر يتجاوز الكود.', 'Impact Beyond Code.'),
                'subtitle' => null,
                'content' => ['description' => $this->t(
                    'نقيس النجاح بالكفاءة التشغيلية وتجربة العملاء والنمو المستدام.',
                    'We measure success by operational efficiency, customer experience, and sustainable growth.'
                )],
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'section_key' => 'process',
                'title' => $this->t('من الفكرة إلى الإطلاق.', 'From Idea to Launch.'),
                'subtitle' => $this->t('منهجية العمل', 'Our Work Process'),
                'content' => [
                    'description' => $this->t(
                        'نأخذ المنتجات من أول حوار إلى الإطلاق الحي — اكتشاف، تخطيط، بناء، ودعم مستمر.',
                        'We take products from first conversation to live launch — discovery, planning, build, and ongoing support.'
                    ),
                    'cta_label' => $this->t('عرض الأعمال', 'View All Work'),
                    'cta_url' => '/work',
                ],
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'section_key' => 'technology',
                'title' => $this->t('تقنية بلا حدود.', 'Technology Without Limitations.'),
                'subtitle' => null,
                'content' => [],
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'section_key' => 'statistics',
                'title' => $this->t('إنجازات مثبتة.', 'Proven at Scale.'),
                'subtitle' => $this->t('الأثر', 'Impact'),
                'content' => [],
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'section_key' => 'testimonials',
                'title' => $this->t('موثوقون من صناع القرار.', 'Trusted by Decision Makers.'),
                'subtitle' => null,
                'content' => [],
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'section_key' => 'insights',
                'title' => $this->t('رؤى ووجهات نظر.', 'Insights & Perspectives.'),
                'subtitle' => null,
                'content' => [],
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'section_key' => 'cta',
                'title' => $this->t('لديك فكرة؟ لنبني شيئاً قوياً.', "Have an Idea? Let's Build Something Powerful."),
                'subtitle' => $this->t(
                    'أخبرنا عن رؤيتك. سنتواصل معك خلال يوم عمل واحد مع الخطوات التالية.',
                    'Tell us about your vision. We will respond within one business day with next steps.'
                ),
                'content' => [
                    'cta_label' => $this->t('ابدأ محادثة', 'Start a Conversation'),
                    'cta_url' => '/contact',
                ],
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'section_key' => 'about',
                'title' => $this->t('عن عالمنا الرقمي لخدمة أعمالك.', 'About Our Digital World for Your Business.'),
                'subtitle' => $this->t('داخل الشركة', 'Inside Our Company'),
                'content' => [
                    'description' => $this->t(
                        'واي تك شركة سعودية لتطوير البرمجيات، متخصصة في تطبيقات الويب وتطبيقات الجوال وحلول المؤسسات. ساعدنا شركات في الخليج على تحويل حضورها الرقمي منذ 2018.',
                        'Ytech is a Saudi-based software development company specializing in web applications, mobile apps, and enterprise solutions. Since 2018, we have helped businesses across the GCC transform their digital presence.'
                    ),
                    'years_count' => '8',
                    'progress_value' => 96,
                    'progress_text' => $this->t(
                        'رضا العملاء عبر المشاريع المُسلَّمة — نساعدك على التوسع بثقة واستراتيجية واضحة.',
                        'Client satisfaction across delivered projects — helping you scale faster with a clear strategy.'
                    ),
                    'solution_text' => $this->t(
                        'حل واي تك: فرق مخصصة، تسليم تدريجي، وملكية كاملة للكود.',
                        'YTECH SOLUTION: dedicated teams, incremental delivery, and full code ownership.'
                    ),
                    'cta_label' => $this->t('المزيد عنا', 'About More'),
                    'cta_url' => '/about',
                ],
                'is_active' => true,
                'sort_order' => 12,
            ],
            [
                'section_key' => 'wordmark',
                'title' => $this->t('واي تك', 'Ytech'),
                'subtitle' => null,
                'content' => [
                    'word' => $this->t('واي تك', 'Ytech'),
                ],
                'is_active' => true,
                'sort_order' => 13,
            ],
            [
                'section_key' => 'marquee',
                'title' => $this->t('قدراتنا', 'Capabilities'),
                'subtitle' => null,
                'content' => [
                    'items' => [
                        $this->t('ويب', 'Web'),
                        $this->t('جوال', 'Mobile'),
                        $this->t('أنظمة', 'Systems'),
                        $this->t('تصميم', 'Design'),
                        $this->t('سحابة', 'Cloud'),
                        $this->t('تكامل', 'Integration'),
                        $this->t('أتمتة', 'Automation'),
                        $this->t('استشارات', 'Consulting'),
                    ],
                ],
                'is_active' => true,
                'sort_order' => 14,
            ],
            [
                'section_key' => 'team',
                'title' => $this->t('تعرّف على فريق العمل.', 'Meet The Team Members.'),
                'subtitle' => $this->t('فريقنا', 'Our Team'),
                'content' => ['description' => $this->t(
                    'مهندسون ومصممون ومديرو منتجات يعملون معك مباشرة من الفكرة حتى الإطلاق.',
                    'Engineers, designers and product leads who work with you directly from idea through launch.'
                )],
                'is_active' => true,
                'sort_order' => 15,
            ],
            [
                'section_key' => 'video',
                'title' => $this->t('حلول برمجية فريدة لأعمالك', 'Unique Software Solutions for Your Business'),
                'subtitle' => $this->t('شاهد الفيديو', 'Watch Video'),
                'content' => [
                    'video_url' => '/media/hero/ytech-showreel.mp4',
                ],
                'is_active' => true,
                'sort_order' => 16,
            ],
            [
                'section_key' => 'awards',
                'title' => $this->t('تقدير لعملنا.', 'Recognition For Our Work.'),
                'subtitle' => $this->t('جوائزنا', 'Our Awards'),
                'content' => [],
                'is_active' => true,
                'sort_order' => 17,
            ],
        ];

        foreach ($sections as $section) {
            HomepageSection::updateOrCreate(['section_key' => $section['section_key']], $section);
        }
    }
}
