<?php

namespace App\Models\Forum;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'forum_messages';

    protected $fillable = ['text', 'parent_id', 'topic_id', 'user_id'];

    protected $hidden = ['user_id'];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function parent(){
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function replys(){
        return $this->hasMany(Message::class, 'parent_id')->with('user');
    }

    public function getReplysAttribute(){
        return $this->replys()->get();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
