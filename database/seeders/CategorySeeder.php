<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryNames = ["Algorithm", "Database", "UI/UX Design", "DevOps", "Blockchain", "Game development", "Virtual Reality", "Augmented Reality", "5G technology", "Quantum computing", "Programming languages", "Web development", "Cloud computing", "Artificial intelligence", "Cybersecurity", "Data privacy", "Software development", "Mobile apps", "Internet of Things"];

        foreach ($categoryNames as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
