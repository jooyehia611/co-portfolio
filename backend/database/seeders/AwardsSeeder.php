<?php

namespace Database\Seeders;

use App\Models\Award;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class AwardsSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $awards = [
            [
                'year' => '2025',
                'title' => $this->t('جائزة أفضل منصة مؤسسية', 'Enterprise Platform of the Year'),
                'platform' => $this->t('قمة التقنية السعودية', 'Saudi Tech Summit'),
                'result' => $this->t('فائز', 'Winner'),
                'sort_order' => 1,
            ],
            [
                'year' => '2024',
                'title' => $this->t('تكريم تجربة المستخدم', 'Product Experience Honoree'),
                'platform' => $this->t('جوائز جيتكس', 'GITEX Awards'),
                'result' => $this->t('فائز', 'Winner'),
                'sort_order' => 2,
            ],
            [
                'year' => '2024',
                'title' => $this->t('أفضل تطبيق جوال حكومي', 'Best Government Mobile App'),
                'platform' => $this->t('منتدى التحول الرقمي', 'Digital Transformation Forum'),
                'result' => $this->t('المركز الثاني', 'Runner Up'),
                'sort_order' => 3,
            ],
            [
                'year' => '2023',
                'title' => $this->t('تميّز في هندسة البرمجيات', 'Software Engineering Excellence'),
                'platform' => $this->t('جوائز الأعمال الخليجية', 'GCC Business Awards'),
                'result' => $this->t('فائز', 'Winner'),
                'sort_order' => 4,
            ],
            [
                'year' => '2022',
                'title' => $this->t('أفضل شريك تقني ناشئ', 'Emerging Technology Partner'),
                'platform' => $this->t('مبادرة الشركات الناشئة', 'Startup Riyadh'),
                'result' => $this->t('المركز الثاني', 'Runner Up'),
                'sort_order' => 5,
            ],
            [
                'year' => '2021',
                'title' => $this->t('جائزة تصميم الواجهات', 'UI/UX Design Award'),
                'platform' => $this->t('جوائز التصميم الإقليمية', 'Regional Design Awards'),
                'result' => $this->t('فائز', 'Winner'),
                'sort_order' => 6,
            ],
        ];

        foreach ($awards as $award) {
            Award::updateOrCreate(
                ['year' => $award['year'], 'sort_order' => $award['sort_order']],
                $award + ['is_active' => true],
            );
        }
    }
}
