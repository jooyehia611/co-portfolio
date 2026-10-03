<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Enums\ProjectType;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectsSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        Project::withTrashed()->forceDelete();

        $placeholderDescription = $this->t(
            'تفاصيل المشروع قيد الإضافة.',
            'Project details coming soon.'
        );

        $projects = [
            [
                'title' => $this->t('نظام المشتريات', 'Procurement System'),
                'project_type' => ProjectType::BusinessSystems,
                'sort_order' => 1,
            ],
            [
                'title' => $this->t('نظام العقارات', 'Property System'),
                'project_type' => ProjectType::BusinessSystems,
                'sort_order' => 2,
            ],
            [
                'title' => $this->t('نظام الحج', 'Haj System'),
                'project_type' => ProjectType::BusinessSystems,
                'sort_order' => 3,
            ],
            [
                'title' => $this->t('دبابي', 'Dababi'),
                'project_type' => ProjectType::Other,
                'sort_order' => 4,
            ],
            [
                'title' => $this->t('تعمير', 'Tameer'),
                'project_type' => ProjectType::BusinessSystems,
                'sort_order' => 5,
            ],
            [
                'title' => $this->t('أكام', 'Akam'),
                'project_type' => ProjectType::BusinessSystems,
                'sort_order' => 6,
            ],
            [
                'title' => $this->t('ريل إستيت', 'Realstate'),
                'project_type' => ProjectType::Web,
                'sort_order' => 7,
            ],
            [
                'title' => $this->t('إنجيكتورز', 'Injectors'),
                'project_type' => ProjectType::BusinessSystems,
                'sort_order' => 8,
            ],
            [
                'title' => $this->t('الفواتير', 'Invoices'),
                'project_type' => ProjectType::BusinessSystems,
                'sort_order' => 9,
            ],
            [
                'title' => $this->t('سعوديش', 'Saudissh'),
                'project_type' => ProjectType::Web,
                'sort_order' => 10,
            ],
            [
                'title' => $this->t('موقع مصر مودرن كلينكس', 'Misr Modern Clinics Website'),
                'project_type' => ProjectType::Web,
                'sort_order' => 11,
            ],
        ];

        foreach ($projects as $index => $data) {
            $serviceSlugs = $data['services'] ?? [];
            $techSlugs = $data['technologies'] ?? [];
            unset($data['services'], $data['technologies']);

            $slug = Str::slug($data['title']['en']);
            $project = Project::create(array_merge($data, [
                'slug' => $slug,
                'short_description' => $placeholderDescription,
                'description' => $placeholderDescription,
                'status' => ContentStatus::Published,
                'is_featured' => $index < 3,
            ]));

            if ($serviceSlugs) {
                $project->services()->sync(
                    Service::whereIn('slug', $serviceSlugs)->pluck('id')
                );
            }

            if ($techSlugs) {
                $project->technologies()->sync(
                    Technology::whereIn('slug', $techSlugs)->pluck('id')
                );
            }
        }
    }
}
