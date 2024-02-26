<?php
namespace App\Http\RequestValidation\User;

use Engine\Http\RequestValidation\ValidationInterface;

class Post implements ValidationInterface{
    public function getRules():array{
        return [
            'post'=>['loggedIn','required','string','max|255'],
        ];
    }
}