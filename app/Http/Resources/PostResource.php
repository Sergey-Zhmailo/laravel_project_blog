<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param   \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'image'         => $this->image,
            'excerpt'       => $this->excerpt,
            'content'       => $this->content,
            'is_published'  => $this->is_published,
            'published_at'  => $this->published_at,
            'post_category' => PostCategoryResource::make($this->whenLoaded('post_category')),
            'post_tags'     => PostTagsResource::collection($this->whenLoaded('post_tags')),
            'comments'      => CommentsResource::collection($this->whenLoaded('comments')),
        ];
    }
}
