<?php

namespace App\Http\Resources;

use App\Models\Forum\Topic;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            Topic::find($this->topic_id)->messages()->with('user')->get(),
            [
                'topic' => Topic::find($this->topic_id),
                'last_reply_date' => Topic::find($this->topic_id)->messages()->latest()->first()->created_at,
                'last_reply_name' => Topic::find($this->topic_id)->messages()->latest()->first()->user()->first()->name,
            ]
        ];
    }
}
