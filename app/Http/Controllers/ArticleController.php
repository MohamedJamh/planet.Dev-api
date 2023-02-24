<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Http\Requests\StoreArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        return new ArticleCollection(Article::with('category', 'tags', 'comments')->get());
    }

    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    public function store(StoreArticleRequest $request)
    {
        $article = Article::create($request->all());
        $article->tags()->attach($request->tags);
        return response()->json([
            "status" => true,
            "message" => "Article has been added successfully!",
            "article" => new ArticleResource($article)
        ]);
    }

    public function update(UpdateArticleRequest $request)
    {

    }
}
