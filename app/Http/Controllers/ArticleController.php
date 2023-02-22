<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    public function index()
    {
        return new ArticleCollection(Article::all());
    }

    public function show(Article $article)
    {
        return new ArticleResource($article);
    }
}
