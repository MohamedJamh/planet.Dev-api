<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class CommentsController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:api']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): CommentCollection
    {
        return $comments = new CommentCollection(Comment::paginate(20));
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
        $comment = Comment::create($request->all() + ['user_id' => auth()->user()->id]);
        return response()->json([
            "status" => true,
            "message" => "Comment submited succefully",
            "data" => new CommentResource($comment)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($comment): \Illuminate\Http\JsonResponse
    {
        $comment = Comment::find($comment);
        if(!$comment){
            return $this->abort();
        }
        return response()->json(new CommentResource($comment),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request , $comment): \Illuminate\Http\JsonResponse
    {
        //
        $comment = Comment::find($comment);
        if(!$comment){
            return $this->abort();
        }
        else if(auth()->user()->id != $comment->user_id){
            return response()->json([
                "message" => "you are not allowed to updated this comment"
            ]);
        }
        $comment->update($request->only('content'));
        return response()->json([
            "status" => "succes",
            "message" => "Comment updated succefully",
            "comment" => new CommentResource($comment)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment): \Illuminate\Http\JsonResponse
    {
        $hasAdminRole = auth()->user()->roles()->where('name','admin')->exists();
        $comment = Comment::find($comment);
        if(!$comment){
            return $this->abort();
        }else if(auth()->user()->id == $comment->user_id || $hasAdminRole == true){

            $comment->delete();
            return response()->json([
                "status" => true,
                "message" => "Comment deleted succefully"
            ],200);

        }

        return response()->json([
            "message" => "you are not allowed to delete this comment"
        ]);
    }
    private function abort(): \Illuminate\Http\JsonResponse{
        return response()->json([
            "status" => "failed",
            "message" => "Comment not found"
        ],404);
    }
}
