<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SettingsSeeder::class,
            HomepageSectionsSeeder::class,
            TechnologiesSeeder::class,
            ServicesSeeder::class,
            ProjectsSeeder::class,
            ClientsSeeder::class,
            TestimonialsSeeder::class,
            TeamMembersSeeder::class,
            StatisticsSeeder::class,
            AwardsSeeder::class,
            ProcessStepsSeeder::class,
            BusinessValuesSeeder::class,
            BudgetRangesSeeder::class,
            SeoPagesSeeder::class,
        ]);
    }
}
