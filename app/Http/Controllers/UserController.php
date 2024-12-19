<?php

namespace App\Http\Controllers;

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

    public function userRegister(UserRegisterRequest $request): JsonResponse
    {
        $data = [];

        try
        {
            $data = $this->userService->userRegister($request);

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
}
