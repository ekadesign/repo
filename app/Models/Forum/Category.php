<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'forum_categories';

    protected $fillable = ['name'];

    public function topics(){
        return $this->hasMany(Topic::class);
    }
}
