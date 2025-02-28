<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            'title' => 'RezeptExperte.de',
            'sitemap' => 'https://www.rezeptexperte.de/sitemap.xml',
            'language_id' => '1',
        ]);
        DB::table('projects')->insert([
            'title' => 'MedPort.de',
            'sitemap' => 'https://www.medport.de/sitemap.xml',
            'language_id' => '1',
        ]);
        DB::table('projects')->insert([
            'title' => 'Hoferichter.net',
            'sitemap' => 'https://www.hoferichter.net/sitemap.xml',
            'language_id' => '1',
        ]);
        DB::table('projects')->insert([
            'title' => 'Aspell.net',
            'sitemap' => 'http://aspellxxx/sitemap.xml',
            'language_id' => '2',
        ]);
    }
}
