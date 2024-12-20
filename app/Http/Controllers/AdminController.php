<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AdminChangePasswordRequest;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRegisterRequest;
use App\Http\Responses\Response;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Throwable;

class AdminController extends Controller
{
    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function register(AdminRegisterRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->adminService->register($request);
            if($data['code'] != 200){
                return Response::Error($data['user'], $data['message'], $data['code']);
            }
            return Response::Success($data['user'], $data['message'], $data['code']);
        }
        catch (Throwable $throwable)
        {
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
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
}
