<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;

class BaseService {

    protected function test(Validator $validator) {
        if($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator;
    }

}