<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Services\Auth\UserService;

class LoginController extends Controller
{

    protected $service;
    
    public function __construct(UserService $_service) {
        $this->middleware('auth:api');
        $this->service = $_service;
    }

    public function login(Request $request) {
        return response()->json($this->service->detailUser($request->user()));
    }

}