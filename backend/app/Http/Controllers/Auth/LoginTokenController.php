<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Services\Auth\UserService;

class LoginTokenController extends Controller
{

    protected $service;

    public function __construct(UserService $_service) {
        $this->service = $_service;
    }

    public function login(Request $request)
    {
        $token = $this->service->createToken($request->email, $request->password);
        return ($token) ? response()->json([ 'token' => $token]) : response(null, 403);
    }

}