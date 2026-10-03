<?php

namespace Database\Seeders;

use App\Models\BudgetRange;
use Database\Seeders\Concerns\Bilingual;
use Illuminate\Database\Seeder;

class BudgetRangesSeeder extends Seeder
{
    use Bilingual;

    public function run(): void
    {
        $ranges = [
            ['label' => $this->t('أقل من 25,000 ريال', 'Under 25,000 SAR'), 'min_amount' => 0, 'max_amount' => 25000, 'sort_order' => 1],
            ['label' => $this->t('25,000 - 75,000 ريال', '25,000 - 75,000 SAR'), 'min_amount' => 25000, 'max_amount' => 75000, 'sort_order' => 2],
            ['label' => $this->t('75,000 - 150,000 ريال', '75,000 - 150,000 SAR'), 'min_amount' => 75000, 'max_amount' => 150000, 'sort_order' => 3],
            ['label' => $this->t('150,000 - 500,000 ريال', '150,000 - 500,000 SAR'), 'min_amount' => 150000, 'max_amount' => 500000, 'sort_order' => 4],
            ['label' => $this->t('500,000+ ريال', '500,000+ SAR'), 'min_amount' => 500000, 'max_amount' => null, 'sort_order' => 5],
        ];

        foreach ($ranges as $range) {
            BudgetRange::updateOrCreate(['sort_order' => $range['sort_order']], $range);
        }
    }
}
