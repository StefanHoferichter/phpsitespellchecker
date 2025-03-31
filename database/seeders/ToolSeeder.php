<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('tools')->insert([
            'name' => 'Aspell',
        ]);
        DB::table('tools')->insert([
            'name' => 'LanguageTool',
        ]);
    }
}
