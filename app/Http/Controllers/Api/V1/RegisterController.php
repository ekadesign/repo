<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class RegisterController extends Controller
{

    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function register(Request $request){

        $repo = new UserRepository();
        $repo->getUserByDecodedJWT($request->input('token'));

        return ['success' => true];

    }
}
