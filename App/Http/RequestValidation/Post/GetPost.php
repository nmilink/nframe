<?php
namespace App\Http\RequestValidation\Post;

use Engine\Http\RequestValidation\ValidationInterface;

class GetPost implements ValidationInterface{
    public function getRules():array{
        return [
            'id'=>['required','exists|user_posts|id','int'],
        ];
    }
}