<?php

namespace App\Http\Resources;

use App\Models\Forum\Topic;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'topic' => Topic::find($this->id),
            'last_reply_date' => Topic::find($this->id)->messages()->count() ? Topic::find($this->id)->messages()->latest()->first()->created_at : null,
            'last_reply_name' => Topic::find($this->id)->messages()->count() ? Topic::find($this->id)->messages()->latest()->first()->user()->first()->name : null,
        ];
    }
}
