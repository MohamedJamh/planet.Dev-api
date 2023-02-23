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
        foreach($this->tags as $tag) {
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->name
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
            'tags' => $tags
        ];
    }
}
