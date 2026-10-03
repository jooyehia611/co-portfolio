<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class StatisticsSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $stats = [
            ['label' => $this->t('مشاريع مُنجزة', 'Projects Delivered'), 'value' => '80', 'suffix' => '+', 'icon' => 'folder', 'sort_order' => 1],
            ['label' => $this->t('عملاء سعداء', 'Happy Clients'), 'value' => '45', 'suffix' => '+', 'icon' => 'users', 'sort_order' => 2],
            ['label' => $this->t('سنوات خبرة', 'Years of Experience'), 'value' => '8', 'suffix' => '+', 'icon' => 'calendar', 'sort_order' => 3],
            ['label' => $this->t('أعضاء الفريق', 'Team Members'), 'value' => '15', 'suffix' => '', 'icon' => 'user-group', 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            Statistic::updateOrCreate(['sort_order' => $stat['sort_order']], $stat);
        }
    }
}
