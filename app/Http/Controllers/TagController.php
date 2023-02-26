<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreTagRequest;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','verified']);

    }

    public function index()
    {
        $tags = Tag::orderBy('id')->get();

        return response()->json([
            'status' => 'success',
            'tags' => TagResource::collection($tags)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(StoreTagRequest $request)
     {
        if (Gate::denies('update-tag')){
            return response()->json([
                'status' => "failed",
                'message' => "You are not authorized to create a tag",
            ], 401);
        }

        $tag = Tag::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "The tag has been created successfully",
            'tag' => $tag,
        ], 201);
     }

      /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */

     public function show($tag)
     {
        $tag = Tag::find($tag);

        if(!$tag){
            return response()->json([
                'message' => "tag not found",
            ], 404);
        }

        return new TagResource($tag);
     }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */

     public function update(StoreTagRequest $request, $tag)
     {
        if (Gate::denies('update-tag')){
            return response()->json([
                'status' => "failed",
                'message' => "You are not authorized to update this tag",
            ], 401);
        }

        $tag = Tag::find($tag);
        if(!$tag) {
             return response()->json([
                 'message' => "Tag not found"
                ], 404);
            }
            
        $tag->update($request->only('name'));
        return response()->json([
            'status' => true,
            'message' => "Tag has been updated successfully",
            'tag' => $tag,
        ], 200);
     }

       /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */

     public function destroy($tag)
     {
        if (Gate::denies('destroy-tag')){
            return response()->json([
                'status' => "failed",
                'message' => "You are not authorized to destroy this tag",
            ], 401);
        }
        $tag = Tag::find($tag);
         
        if (!$tag){
            return response()->json([
                'message' => "Tag not found",
            ], 404);
        }
        
        $tag->delete();
        return response()->json([
            'status' => true,
            'message' => "The tag has been deleted successfully",
        ], 200);
     }

}
