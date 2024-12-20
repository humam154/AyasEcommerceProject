<?php

namespace App\Http\Controllers;

use App\Http\Requests\Moderator\ModeratorChangePasswordRequest;
use App\Http\Requests\Moderator\ModeratorLoginRequest;
use App\Http\Requests\Moderator\ModeratorRegisterRequest;
use App\Http\Responses\Response;
use App\Services\ModeratorService;
use Illuminate\Http\JsonResponse;
use Throwable;

class ModeratorController extends Controller
{
    private ModeratorService $moderatorService;

    public function __construct(ModeratorService $moderatorService)
    {
        $this->moderatorService = $moderatorService;
    }

    public function register(ModeratorRegisterRequest $request) : JsonResponse
    {
        $data = [];

        try {
            $data = $this->moderatorService->register($request);
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
}
