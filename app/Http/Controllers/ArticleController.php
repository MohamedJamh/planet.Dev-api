<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Filters\ArticleFilter;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified']);
    }
    public function index(Request $request)
    {
        $filter = new ArticleFilter();
        $queryItems = $filter->transform($request);
        if(count($queryItems) == 0 && $request->has('tag') == false) {
            return new ArticleCollection(Article::with('category', 'tags', 'comments')->get());
        }
        if($request->has('tag')) {
            $tag = $request->tag;
            return new ArticleCollection(Article::with('category', 'tags', 'comments')->where($queryItems)->whereHas('tags', function($query) use ($tag) {
                $query->where('name', $tag);
            })->get());
        }
        return new ArticleCollection(Article::with('category', 'tags', 'comments')->where($queryItems)->get());
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

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update($request->all());
        $request->tags ? $article->tags()->sync($request->tags) : null;
        return response()->json([
            "status" => true,
            "message" => "Article has been updated successfully!",
            "article" => new ArticleResource($article)
        ]);
    }

    public function destroy(Article $article)
    {
        $article->tags()->detach();
        $article->delete();
        return response()->json([
            "status" => true,
            "message" => "Article has been deleted successfully!"
        ]);
    }
}
