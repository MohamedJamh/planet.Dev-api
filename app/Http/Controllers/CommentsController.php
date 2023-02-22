<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): CommentCollection
    {
        return $comments = new CommentCollection(Comment::paginate(20));
        // return response()->json([
        //     'status' => 'success',
        //     'comments' => $comments
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request): \Illuminate\Http\JsonResponse
    {
        //
        $comment = Comment::create($request->all())->only('id','user_id','article_id');
        return response()->json([
            "status" => true,
            "message" => "Comment submited succefully",
            "comment" => new CommentResource($comment)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment): \Illuminate\Http\JsonResponse
    {
        return response()->json(new CommentResource($comment),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
