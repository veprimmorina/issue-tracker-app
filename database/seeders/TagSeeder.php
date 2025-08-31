<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Bug', 'color' => '#dc3545'],
            ['name' => 'Feature', 'color' => '#0d6efd'],
            ['name' => 'Improvement', 'color' => '#198754'],
            ['name' => 'Documentation', 'color' => '#ffc107'],
            ['name' => 'Design', 'color' => '#6f42c1'],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(['name' => $tag['name']], $tag);
        }
    }
}
