<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologiesSeeder extends Seeder
{
    public function run(): void
    {
        $technologies = [
            ['name' => 'Laravel', 'icon' => 'laravel', 'description' => 'PHP framework for elegant web applications', 'sort_order' => 1],
            ['name' => 'React', 'icon' => 'react', 'description' => 'JavaScript library for building user interfaces', 'sort_order' => 2],
            ['name' => 'Vue.js', 'icon' => 'vue', 'description' => 'Progressive JavaScript framework', 'sort_order' => 3],
            ['name' => 'Node.js', 'icon' => 'nodejs', 'description' => 'JavaScript runtime for server-side applications', 'sort_order' => 4],
            ['name' => 'Flutter', 'icon' => 'flutter', 'description' => 'Cross-platform mobile development framework', 'sort_order' => 5],
            ['name' => 'AWS', 'icon' => 'aws', 'description' => 'Amazon Web Services cloud platform', 'sort_order' => 6],
            ['name' => 'Docker', 'icon' => 'docker', 'description' => 'Container platform for deployment', 'sort_order' => 7],
            ['name' => 'MySQL', 'icon' => 'mysql', 'description' => 'Relational database management system', 'sort_order' => 8],
            ['name' => 'Redis', 'icon' => 'redis', 'description' => 'In-memory data store for caching', 'sort_order' => 9],
            ['name' => 'Tailwind CSS', 'icon' => 'tailwind', 'description' => 'Utility-first CSS framework', 'sort_order' => 10],
        ];

        foreach ($technologies as $tech) {
            Technology::updateOrCreate(
                ['slug' => Str::slug($tech['name'])],
                array_merge($tech, ['slug' => Str::slug($tech['name'])])
            );
        }
    }
}
