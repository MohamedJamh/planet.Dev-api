<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tags = [];
        $comments = [];
        foreach($this->tags as $tag) {
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->name
            ];
        }
        foreach($this->comments as $comment) {
            $comments[] = [
                'id' => $comment->id,
                'content' => $comment->content,
                'userId' => $comment->user_id
            ];
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'userId' => $this->user_id,
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name
            ],
            'tags' => $tags,
            'comments' => $comments
        ];
    }
}
