<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(){

        return response()->json(News::paginate(1));
    }
}
