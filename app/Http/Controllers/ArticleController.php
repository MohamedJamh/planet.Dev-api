<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Http\Requests\StoreArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        return new ArticleCollection(Article::with('category','tags')->get());
    }

    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    public function store(StoreArticleRequest $request)
    {
        return new ArticleResource(Article::create($request->all()));
    }
}
