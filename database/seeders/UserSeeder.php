<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Hamcrest\Arrays\IsArray;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private function randomElements($arr, $maxElements)
    {
        $t = array_rand($arr, rand(1, $maxElements));
        if (!is_array($t))
            return [$arr[$t]];
            
        return array_map(fn($i) => $arr[$i], $t);
    }

    public function run()
    {
        $numUsers = 10;
        $numAdmins = 3;
        $userRoleId = 3;
        $categoryIds = Category::pluck('id')->toArray();
        $tagsIds = Tag::pluck('id')->toArray();
        $maxNumTags = 6;

        User::factory($numAdmins)
                ->create()
                ->each(function($admin) {
                    $admin->roles()->attach(2);
                });

        $users = User::factory($numUsers)->create();
        $userIds = User::pluck('id')->toArray(); //TODO: filter only users
        $users->each(function ($user) use ($userRoleId, $categoryIds, $tagsIds, $maxNumTags, $userIds) {
            $user->roles()->attach([$userRoleId]); // give it user role
            $numArticles = rand(0, 10);
            $catId = $categoryIds[array_rand($categoryIds)];
            Article::factory($numArticles)
                    ->create(['category_id' => $catId, 'user_id' => $user->id])
                    ->each(function ($article) use ($tagsIds, $maxNumTags, $userIds) {
                        $numComments = rand(0, 20);
                        $tags = $this->randomElements($tagsIds, $maxNumTags);
                        $article->tags()->attach($tags);
                        Comment::factory($numComments)
                                ->create(['article_id' => $article->id, 'user_id' => 1])
                                ->each(function($comment) use($userIds) {
                                    $comment->user_id = $userIds[array_rand($userIds)];
                                    $comment->save();
                                });
                    });
        });
    }
}
