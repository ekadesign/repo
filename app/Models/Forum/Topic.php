<?php

namespace App\Models\Forum;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    protected $table = 'forum_topics';

    protected $fillable = [ 'name', 'tags', 'views', 'text', 'category_id', 'user_id'];

    protected $hidden = ['user_id'];


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function getHumanTagsAttribute() {
        return implode(', ', (array)unserialize($this->attributes['tags']));
    }

    public function getTagsAttribute($value) {
        return (array)unserialize($value);
    }

    public function setTagsAttribute($value){
        $this->attributes['tags'] = serialize(explode(',', str_replace(' ', '', $value)));
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}