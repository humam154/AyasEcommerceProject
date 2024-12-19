<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Responses\Response;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = [];

        try
        {
            $data = $this->userService->register($request);

            if($data['code'] != 200){
                return Response::Error($data['user'] ,$data['message'], $data['code']);
            }

            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable)
        {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->userService->login($request);
            if($data['code'] != 200){
                return Response::Error($data['user'] ,$data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function logout(): JsonResponse
    {
        $data = [];

        try {
            $data = $this->userService->logout();
            if($data['code'] != 200){
                return Response::Error($data['user'] ,$data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function changePassword(UserChangePasswordRequest $request): JsonResponse
    {
        $data = [];

        try{
            $data = $this->userService->changePassword($request);
            if($data['code'] != 200){
                return Response::Error($data['user'] ,$data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
