<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['js', 'html', 'css', 'php', 'laravel', 'bitcoin', 'tesla', 'python', 'youcode', 'jamh'];
        $tagNames = [];
        foreach ($names as $name) {
            $tagNames[] = ['name' => $name, 'created_at' => now(), 'updated_at' => now()];
        }

        Tag::insert($tagNames);
    }
}
