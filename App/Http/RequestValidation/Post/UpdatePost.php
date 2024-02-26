<?php
namespace App\Http\RequestValidation\Post;

use Engine\Http\RequestValidation\ValidationInterface;

class UpdatePost implements ValidationInterface{
    public function getRules():array{
        return [
            'id'=>['required','loggedIn','exists|user_posts|id','int'],
            'post'=>['required','string','max|255']
        ];
    }
}