<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RssFeed extends Model
{
    protected $table = 'rss_sources';

    protected $fillable = ['name','link'];
}
