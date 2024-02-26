<?php

namespace App\Http\Controllers;

use App\EventMessages\User\UserRegistered;
use App\Http\RequestValidation\User\Login;
use App\Http\RequestValidation\User\Post;
use App\Http\RequestValidation\User\Register;
use App\Models\Users\UserRepositoryInterface;
use Engine\Application\EventHandlerInterface;
use Engine\Http\ControllerAbstract;
use Engine\Http\PathResolver\Attributes\Route;
use Engine\Http\PathResolver\Attributes\Validator;
use Engine\Http\Request\RequestInterface;

class UserController extends ControllerAbstract
{



    #[Route('users', 'POST')]
    #[Validator(Register::class)]
    public function store(RequestInterface $request, UserRepositoryInterface $repo, EventHandlerInterface $eventHandler)
    {
        $id = $repo->store($request->getProperty('email'), $request->getProperty('password'));
        if ($id === false) {
            return [
                'success' => false,
                'message' => 'insert_error',
            ];
        }
        $request->addToSession('userId', $id);
        $eventHandler->publish('user_register', UserRegistered::load($id, $request->getProperty('email')));
        return [
            'success' => true,
            'userId' => $id,
        ];
    }
    #[Route('users/login', 'POST')]
    #[Validator(Login::class)]
    public function logIn(RequestInterface $request, UserRepositoryInterface $repo)
    {
        $data = $repo->authenticate($request->getProperty('email'), $request->getProperty('password'));
        if ($data === false) {
            return [
                'success' => false,
                'message' => 'credentials_mismatch',
            ];
        }
        $request->addToSession('userId', $data['id']);
        return [
            'success' => true,
            'user' => $data,
        ];
    }
    #[Route('users/logout', 'POST')]
    public function logOut(RequestInterface $request)
    {
        $request->addToSession('userId', null);
        return [
            'success' => true,
            'message' => 'logged_out',
        ];
    }
    #[Route('users/me', 'GET')]
    public function me(RequestInterface $request, UserRepositoryInterface $repo)
    {
        if (is_null($request->getFromSession('userId'))) {
            return [
                'success' => false,
                'message' => 'not_logged_in',
            ];
        }
        $data = $repo->getById($request->getFromSession('userId'));
        if ($data === false) {
            return [
                'success' => false,
                'message' => 'not_logged_in',
            ];
        }
        return [
            'success' => true,
            'user' => $data,
        ];
    }

    #[Route('users/post', 'POST')]
    #[Validator(Post::class)]
    public function post(RequestInterface $request, UserRepositoryInterface $repo)
    {
        $id = $repo->post((int) $request->getFromSession('userId'), $request->getProperty('post'));
        if ($id === false) {
            return [
                'success' => false,
                'message' => 'insert_error',
            ];
        }
        return [
            'success' => true,
            'message' => 'post_created',
        ];
    }
}
