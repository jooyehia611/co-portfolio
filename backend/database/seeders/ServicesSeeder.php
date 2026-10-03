<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Service;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServicesSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $services = [
            [
                'title' => $this->t('تطوير تطبيقات الويب', 'Web Application Development'),
                'short_description' => $this->t(
                    'تطبيقات ويب مخصصة مبنية بـ Laravel وReact وأطر حديثة للأداء والقابلية للتوسع.',
                    'Custom web apps built with Laravel, React, and modern frameworks for performance and scalability.'
                ),
                'description' => $this->t(
                    'نبني تطبيقات ويب قوية مصممة وفق عمليات عملك. من لوحات التحكم الداخلية إلى المنصات الموجهة للعملاء، يقدم فريقنا حلولاً آمنة وقابلة للتوسع باستخدام Laravel وVue.js وReact والبنية السحابية.',
                    'We build robust web applications tailored to your business processes. From internal dashboards to customer-facing platforms, our team delivers secure, scalable solutions using Laravel, Vue.js, React, and cloud infrastructure.'
                ),
                'capabilities' => [
                    'ar' => ['تطوير API', 'لوحات تحكم مخصصة', 'تكامل أنظمة ERP', 'أمان على مستوى المؤسسات'],
                    'en' => ['API Development', 'Custom Dashboards', 'ERP Integration', 'Enterprise Security'],
                ],
                'business_problems' => [
                    'ar' => ['عمليات يدوية بطيئة', 'أنظمة قديمة غير متصلة', 'صعوبة التوسع'],
                    'en' => ['Slow manual processes', 'Disconnected legacy systems', 'Scaling difficulties'],
                ],
                'icon' => 'code',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => $this->t('تطوير تطبيقات الجوال', 'Mobile App Development'),
                'short_description' => $this->t(
                    'تطبيقات جوال أصلية ومتعددة المنصات لـ iOS وAndroid يحبها المستخدمون.',
                    'Native and cross-platform mobile apps for iOS and Android that users love.'
                ),
                'description' => $this->t(
                    'تواصل مع عملائك أينما كانوا عبر تطبيقات جوال مصممة بعناية. نطور تطبيقات iOS/Android أصلية وحلولاً متعددة المنصات باستخدام Flutter وReact Native.',
                    'Reach your customers wherever they are with beautifully designed mobile applications. We develop native iOS/Android apps and cross-platform solutions using Flutter and React Native.'
                ),
                'icon' => 'smartphone',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => $this->t('حلول التجارة الإلكترونية', 'E-Commerce Solutions'),
                'short_description' => $this->t(
                    'متاجر إلكترونية مع دفع سلس وإدارة مخزون وتكامل بوابات الدفع.',
                    'Online stores with seamless checkout, inventory management, and payment integration.'
                ),
                'description' => $this->t(
                    'أطلق ونمِّ أعمالك الإلكترونية بمنصات تجارة إلكترونية مخصصة. ندمج بوابات الدفع ومزودي الشحن وأنظمة ERP لحل تجزئة متكامل.',
                    'Launch and grow your online business with custom e-commerce platforms. We integrate payment gateways, shipping providers, and ERP systems for a complete retail solution.'
                ),
                'icon' => 'shopping-cart',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => $this->t('تصميم UI/UX', 'UI/UX Design'),
                'short_description' => $this->t(
                    'تصميم يركز على المستخدم يحوّل الزوار إلى عملاء مخلصين.',
                    'User-centered design that converts visitors into loyal customers.'
                ),
                'description' => $this->t(
                    'يصنع فريق التصميم لدينا واجهات بديهية مدعومة بأبحاث المستخدم والنماذج الأولية. نضمن أن كل تفاعل يعكس علامتك ويلبي توقعات المستخدم.',
                    'Our design team creates intuitive interfaces backed by user research, wireframing, and prototyping. We ensure every interaction reflects your brand and meets user expectations.'
                ),
                'icon' => 'palette',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'title' => $this->t('السحابة وDevOps', 'Cloud & DevOps'),
                'short_description' => $this->t(
                    'بنية AWS وAzure وخطوط CI/CD ومراقبة مستمرة.',
                    'AWS and Azure infrastructure setup, CI/CD pipelines, and monitoring.'
                ),
                'description' => $this->t(
                    'انتقل إلى السحابة بثقة. نصمم وننشر ونحافظ على البنية السحابية مع خطوط آلية ومراقبة وخطط استرداد من الكوارث.',
                    'Migrate to the cloud with confidence. We architect, deploy, and maintain cloud infrastructure with automated pipelines, monitoring, and disaster recovery planning.'
                ),
                'icon' => 'cloud',
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'title' => $this->t('استشارات تقنية', 'IT Consulting'),
                'short_description' => $this->t(
                    'إرشاد تقني استراتيجي لمواءمة استثمارات IT مع أهداف العمل.',
                    'Strategic technology guidance to align IT investments with business goals.'
                ),
                'description' => $this->t(
                    'لست متأكداً من أين تبدأ؟ يقيّم مستشارونا أنظمتك الحالية ويحددون الفرص ويضعون خرائط طريق تقنية قابلة للتنفيذ للتحول الرقمي.',
                    'Not sure where to start? Our consultants assess your current systems, identify opportunities, and create actionable technology roadmaps for digital transformation.'
                ),
                'icon' => 'briefcase',
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            $slug = Str::slug($service['title']['en']);
            Service::updateOrCreate(
                ['slug' => $slug],
                array_merge($service, ['slug' => $slug, 'status' => ContentStatus::Published])
            );
        }
    }
}
