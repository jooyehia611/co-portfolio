<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientsSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'AlNoor Trading Co.', 'website_url' => 'https://alnoor-example.com', 'is_featured' => true, 'sort_order' => 1],
            ['name' => 'MedTrack Clinics', 'website_url' => 'https://medtrack-example.com', 'is_featured' => true, 'sort_order' => 2],
            ['name' => 'Gulf Logistics Group', 'website_url' => 'https://gulflogistics-example.com', 'is_featured' => true, 'sort_order' => 3],
            ['name' => 'FinServe Capital', 'website_url' => 'https://finserve-example.com', 'is_featured' => true, 'sort_order' => 4],
            ['name' => 'EduLearn Academy', 'website_url' => 'https://edulearn-example.com', 'is_featured' => true, 'sort_order' => 5],
            ['name' => 'Saudi Tech Ventures', 'website_url' => 'https://stventures-example.com', 'is_featured' => false, 'sort_order' => 6],
            ['name' => 'Riyadh Properties', 'website_url' => 'https://riyadhprops-example.com', 'is_featured' => false, 'sort_order' => 7],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(
                ['slug' => Str::slug($client['name'])],
                array_merge($client, ['slug' => Str::slug($client['name'])])
            );
        }
    }
}
