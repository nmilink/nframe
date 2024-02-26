<?php

namespace App\Http\Controllers;

use App\Http\RequestValidation\Post\GetPosts;
use App\Http\RequestValidation\Post\UpdatePost;
use App\Models\Posts\PostRepositoryInterface;
use Engine\Http\ControllerAbstract;
use Engine\Http\PathResolver\Attributes\Route;
use Engine\Http\PathResolver\Attributes\Validator;
use Engine\Http\Request\RequestInterface;

class PostController extends ControllerAbstract
{
    #[Route('posts', 'GET')]
    #[Validator(GetPosts::class)]
    public function index(RequestInterface $request,PostRepositoryInterface $repo)
    {
        
        $interval = $request->getProperty('interval')??10;
        $data = $repo->select((int) $interval);
        
        if($data === false){
            return [
                'success' => false,
                'message' => 'no_data_found',
            ];
        }
        return [
            'success' => true,
            'data' => $data,
        ];
    }
    #[Route('posts', 'PATCH')]
    #[Validator(UpdatePost::class)]
    public function update(RequestInterface $request,PostRepositoryInterface $repo)
    {
        $data = $repo->updatePost((int) $request->getProperty('id'), $request->getProperty('post'),$request->getFromSession('userId'));
        if($data === false){
            return [
                'success' => false,
                'message' => 'post_not_updated',
            ];
        }
        return [
            'success' => true,
            'message' => 'post_updated',
        ];
    }
    
}
