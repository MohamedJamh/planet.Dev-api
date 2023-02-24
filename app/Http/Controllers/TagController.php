<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $tags = Tag::select('id', 'name')->orderBy('id')->get();

        return response()->json([
            'status' => 'success',
            'tags' => $tags,
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
        $tag = Tag::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "The tag has been updated successfully",
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
        $tag = Tag::find($tag)->all('id', 'name');

        if(!$tag){
            return response()->json([
                'message' => "tag not found",
            ], 404);
        }

        return response()->json($tag, 200);
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
