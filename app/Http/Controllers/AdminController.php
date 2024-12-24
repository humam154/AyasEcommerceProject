<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AddModeratorRequest;
use App\Http\Requests\Admin\AdminChangePasswordRequest;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\User\EditProfileRequest;
use App\Http\Responses\Response;
use App\Services\AdminService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;

class AdminController extends Controller
{
    private AdminService $adminService;

    private UserService $userService;
    public function __construct(AdminService $adminService, UserService $userService)
    {
        $this->adminService = $adminService;

        $this->userService = $userService;
    }
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->adminService->login($request);
            if($data['code'] != 200){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function logout(): JsonResponse
    {
        $data = [];

        try {
            $data = $this->adminService->logout();
            if($data['code'] != 200){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function changePassword(AdminChangePasswordRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->adminService->changePassword($request);
            if($data['code'] != 200){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function addModerator(AddModeratorRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->adminService->addModerator($request);

            if($data['code'] != 200){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }

            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function editProfile(EditProfileRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->userService->editProfile($request);
            if($data['code'] != 200){
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
