<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $folder = config('dict.folder');
        $csvFile=$folder . '/custom_de.txt';
        $this->importWords($csvFile, 1);
        $csvFile=$folder . '/custom_en.txt';
        $this->importWords($csvFile, 2);
        $csvFile=$folder . '/ignored.txt';
        $this->importIgnored($csvFile);
    }
    
    private function importWords($csvFile, $languageId)
    {
        $content = file_get_contents($csvFile);
        $csvRows = preg_split("/\r\n|\n|\r/", $content);
        foreach($csvRows as $line)
        {
            if (strlen(trim($line)) > 0)
            {
                echo "#" . $line . "!";
                DB::table('words')->insert([
                    'language_id' => $languageId,
                    'name' => trim($line),
                ]);
            }
        }
    }

    private function importIgnored($csvFile)
    {
        $content = file_get_contents($csvFile);
        $csvRows = preg_split("/\r\n|\n|\r/", $content);
        foreach($csvRows as $line)
        {
            echo "#" . $line . "!";
            DB::table('ignored_words')->insert([
                'name' => $line,
            ]);
            
        }
    }
    
}
