<?php

namespace Database\Seeders;

use App\Models\ProcessStep;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class ProcessStepsSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $steps = [
            [
                'title' => $this->t('الاكتشاف', 'Discovery'),
                'description' => $this->t(
                    'نتعرف على عملك وأهدافك ومتطلباتك عبر ورش عمل ومقابلات مع أصحاب المصلحة.',
                    'We learn about your business, goals, and requirements through workshops and stakeholder interviews.'
                ),
                'step_number' => 1,
                'icon' => 'search',
                'sort_order' => 1,
            ],
            [
                'title' => $this->t('التخطيط', 'Planning'),
                'description' => $this->t(
                    'يضع فريقنا خارطة طريق تفصيلية ونماذج أولية وبنية تقنية لموافقتك.',
                    'Our team creates a detailed project roadmap, wireframes, and technical architecture for your approval.'
                ),
                'step_number' => 2,
                'icon' => 'clipboard',
                'sort_order' => 2,
            ],
            [
                'title' => $this->t('التطوير', 'Development'),
                'description' => $this->t(
                    'سprints رشيقة مع عروض منتظمة تبقيك على اطلاع. نبني ونختبر ونكرر بناءً على ملاحظاتك.',
                    'Agile sprints with regular demos keep you informed. We build, test, and iterate based on your feedback.'
                ),
                'step_number' => 3,
                'icon' => 'code',
                'sort_order' => 3,
            ],
            [
                'title' => $this->t('الإطلاق والدعم', 'Launch & Support'),
                'description' => $this->t(
                    'ننشر حلّك وندرب فريقك ونوفر صيانة مستمرة وتحسينات للميزات.',
                    'We deploy your solution, train your team, and provide ongoing maintenance and feature enhancements.'
                ),
                'step_number' => 4,
                'icon' => 'rocket',
                'sort_order' => 4,
            ],
        ];

        foreach ($steps as $step) {
            ProcessStep::updateOrCreate(['step_number' => $step['step_number']], $step);
        }
    }
}
