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

    public function run()
    {
        $NUMUSERS = 10;
        $NUMADMINS = 3;
        $MAXNUMTAGS = 6;
        $categoryIds = Category::pluck('id')->toArray();
        $tagsIds = Tag::pluck('id')->toArray();

        User::factory($NUMADMINS) // create users with admin role
                ->create()
                ->each(function($admin) {
                    $admin->roles()->attach([2, 3]);
                });

        $users = User::factory($NUMUSERS)->create(); // create users
        $users->each(function ($user) use ($categoryIds, $tagsIds, $MAXNUMTAGS, $users) {
            $user->roles()->attach([3]); // give it user role
            $numArticles = rand(0, 10);
            $catId = $categoryIds[array_rand($categoryIds)];
            Article::factory($numArticles)
                    ->create(['category_id' => $catId, 'user_id' => $user->id])
                    ->each(function ($article) use ($tagsIds, $MAXNUMTAGS, $users) {
                        $numComments = rand(0, 20);
                        $tags = fake()->randomElements($tagsIds, rand(1, $MAXNUMTAGS));
                        $article->tags()->attach($tags);
                        Comment::factory($numComments)
                                ->create(['article_id' => $article->id, 'user_id' => 1])
                                ->each(function($comment) use($users) {
                                    $comment->user_id = $users->random()->id;
                                    $comment->save();
                                });
                    });
        });
    }
}
