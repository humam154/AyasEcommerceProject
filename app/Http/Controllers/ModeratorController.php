<?php

namespace App\Http\Controllers;

use App\Http\Requests\Moderator\ModeratorChangePasswordRequest;
use App\Http\Requests\Moderator\ModeratorLoginRequest;
use App\Http\Requests\User\EditProfileRequest;
use App\Http\Responses\Response;
use App\Services\ModeratorService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;

class ModeratorController extends Controller
{
    private ModeratorService $moderatorService;

    private UserService $userService;

    public function __construct(ModeratorService $moderatorService, UserService $userService)
    {
        $this->moderatorService = $moderatorService;

        $this->userService = $userService;
    }

    public function login(ModeratorLoginRequest $request) : JsonResponse
    {
        $data = [];

        try {
            $data = $this->moderatorService->login($request);
            if ($data['code'] != 200) {
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function logout() : JsonResponse
    {
        $data = [];

        try {
            $data = $this->moderatorService->logout();
            if ($data['code'] != 200) {
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function changePassword(ModeratorChangePasswordRequest $request) : JsonResponse
    {
        $data = [];

        try {
            $data = $this->moderatorService->changePassword($request);
            if ($data['code'] != 200) {
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function editProfile(EditProfileRequest $request) : JsonResponse
    {
        $data = [];

        try {
            $data = $this->userService->editProfile($request);
            if ($data['code'] != 200) {
                return Response::Error($data['user'], $data['message'], $data['code']);
            }

            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
