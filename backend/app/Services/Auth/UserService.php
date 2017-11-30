<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Services\BaseService;
use App\User;

class UserService extends BaseService {

    protected $default_token = 'LoginToken';
    protected $default_password = '12345678';
    
    public function createUser($loggedUser, $input) 
    {
        $data = $this->test(Validator::make($input, [
            'name' => 'required', 
            'email' => 'required',
            'password' => 'optional'
        ]));
        return User::create($data->valid());
    }

    public function resetPassword($loggedUser, $email) 
    {
        $user = User::where('email', $email)->first();
        if($user) {
            $user->password = \Hash::make($this->default_password);
            $user->save();
        }
    }

    public function createToken($email, $password) 
    {
        $logged = Auth::attempt(['email' => $email, 'password' => $password]);
        if($logged) {
            $user = Auth::user();
            $token = $user->createToken($this->default_token)->accessToken;
        } else {
            $token = null;
        }
        return $token;
    }

    public function detailUser($user) 
    {
        $out = User::find($user->id)->with(['roles'])->first();
        return $out;
    }

}