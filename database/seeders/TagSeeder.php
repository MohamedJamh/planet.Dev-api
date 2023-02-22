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
        $tags = ['JS', 'HTML', 'CSS', 'PHP', 'Laravel', 'Python', 'React', 'Vue', 'Angular', 'C++', 'Rust', 'WASM', 'Django', 'Rails', 'Express', 'NextJs', 'Crypto', 'Cobol', 'Fortran', 'Java', 'Kotlin', 'Swift', 'Go', 'TypeScript', 'Ruby', 'Scala', 'Haskell', 'Lua', 'SQL', 'MongoDB', 'Firebase', 'AWS', 'Docker', 'Kubernetes', 'Git', 'DevOps', 'Machine Learning', 'Data Science', 'Artificial Intelligence', 'Blockchain', 'Cybersecurity', 'Network Administration', 'UX/UI Design', 'Frontend Development', 'Backend Development', 'Full-stack Development', 'Mobile Development', 'Web Development', 'Game Development', 'Desktop Application Development', 'Embedded Systems', 'Robotics', 'Ruby on Rails', 'Flask', 'Spring', 'Hibernate', 'CodeIgniter', 'Symfony', 'Express.js', 'Struts', 'Yii', 'CakePHP'];
        $tagNames = [];
        $nowDate = now();
        foreach ($tags as $tag) {
            $tagNames[] = ['name' => $tag, 'created_at' => $nowDate, 'updated_at' => $nowDate];
        }

        Tag::insert($tagNames);
    }
}
