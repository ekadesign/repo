<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'symbol' => $this->symbol,
            'tags' => $this->tags,
            'views' => $this->views,
            'text' => $this->text,
            'category_id' => $this->category_id,
            'user' => $this->user,
            'last_reply_date' => $this->messages()->latest()->first()->created_at,
            'last_reply_name' => $this->messages()->latest()->first()->user()->name,
        ];
    }
}
