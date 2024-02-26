<?php
namespace App\Http\RequestValidation\User;

use Engine\Http\RequestValidation\ValidationInterface;

class Login implements ValidationInterface{
    public function getRules():array{
        return [
            'email'=>['required','max|255'],
            'password'=>['required','string','min|8','max|255'],
            
        ];
    }
}