<?php
namespace App\Http\RequestValidation\Post;

use Engine\Http\RequestValidation\ValidationInterface;

class GetPosts implements ValidationInterface{
    public function getRules():array{
        return [
            'interval'=>['int','min|0'],
        ];
    }
}