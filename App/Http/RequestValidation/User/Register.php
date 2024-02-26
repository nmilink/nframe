<?php
namespace App\Http\RequestValidation\User;

use Engine\Http\RequestValidation\ValidationInterface;

class Register implements ValidationInterface{
    public function getRules():array{
        return [
            'email'=>['required','email','notExists|users|email','notFraud','max|255'],
            'password'=>['required','string','min|8','equalTo|password2','max|255'],
            'password2'=>['required','string','min|8','max|255'],
            
        ];
    }
}