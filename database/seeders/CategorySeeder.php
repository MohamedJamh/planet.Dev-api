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
        $categories = ['Programming Languages', 'Web Development', 'Mobile Development', 'DevOps', 'Cloud Computing', 'Data Science', 'Cybersecurity', 'Artificial Intelligence', 'Software Engineering', 'Internet of Things'];


        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
