<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $urls = [
            'https://laravel.com/docs',
            'https://filamentphp.com/docs',
            'https://github.com',
        ];

        foreach ($urls as $url) {
            \App\Models\Link::create([
                'original_url' => $url,
                'created_by' => 1,
            ]);
        }
    }
}
