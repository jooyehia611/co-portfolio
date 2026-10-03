<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamMembersSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $members = [
            [
                'name' => 'Yousef Al-Malki',
                'role' => $this->t('المؤسس والرئيس التنفيذي', 'Founder & CEO'),
                'bio' => $this->t(
                    'أسس يوسف Ytech في 2018 برؤية لجلب تطوير برمجيات عالمي المستوى للشركات السعودية. بخبرة تتجاوز 12 عاماً في التقنية، يقود الاستراتيجية وعلاقات العملاء.',
                    'Yousef founded Ytech in 2018 with a vision to bring world-class software development to Saudi businesses. With 12+ years in tech, he leads strategy and client relationships.'
                ),
                'email' => 'yousef@ytech.com',
                'linkedin_url' => 'https://linkedin.com/in/yousef-almalki',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Noura Al-Shehri',
                'role' => $this->t('قائدة التطوير', 'Lead Developer'),
                'bio' => $this->t(
                    'تتخصص نورة في معماريات Laravel وReact. قادت التطوير في أكثر من 20 مشروعاً مؤسسياً وتوجّه فريق الهندسة.',
                    'Noura specializes in Laravel and React architectures. She has led development on 20+ enterprise projects and mentors the engineering team.'
                ),
                'email' => 'noura@ytech.com',
                'github_url' => 'https://github.com/noura-shehri',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Omar Al-Qahtani',
                'role' => $this->t('مصمم UI/UX', 'UI/UX Designer'),
                'bio' => $this->t(
                    'يصنع عمر واجهات بديهية متناسقة مع الهوية البصرية. يمتد عمله عبر التجارة الإلكترونية والرعاية الصحية والتطبيقات المالية في الخليج.',
                    'Omar creates intuitive, brand-aligned interfaces. His design work spans e-commerce, healthcare, and fintech applications across the GCC.'
                ),
                'email' => 'omar@ytech.com',
                'linkedin_url' => 'https://linkedin.com/in/omar-qahtani',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Layla Al-Dossari',
                'role' => $this->t('مديرة المشاريع', 'Project Manager'),
                'bio' => $this->t(
                    'تضمن ليلى بقاء كل مشروع على المسار بمنهجيات Agile. تربط التواصل بين العملاء وفريق التطوير.',
                    'Layla ensures every project stays on track with agile methodologies. She bridges communication between clients and the development team.'
                ),
                'email' => 'layla@ytech.com',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Faisal Al-Ghamdi',
                'role' => $this->t('مهندس DevOps', 'DevOps Engineer'),
                'bio' => $this->t(
                    'يدير فيصل البنية السحابية على AWS وAzure وخطوط CI/CD ومراقبة الأنظمة لجميع نشرات Ytech.',
                    'Faisal manages cloud infrastructure on AWS and Azure, CI/CD pipelines, and system monitoring for all Ytech deployments.'
                ),
                'email' => 'faisal@ytech.com',
                'github_url' => 'https://github.com/faisal-ghamdi',
                'is_featured' => false,
                'sort_order' => 5,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['slug' => Str::slug($member['name'])],
                array_merge($member, ['slug' => Str::slug($member['name'])])
            );
        }
    }
}
