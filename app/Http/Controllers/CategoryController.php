<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\CategoryCreateRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use App\Http\Responses\Response;
use App\Services\CategoriesService;
use Illuminate\Http\JsonResponse;
use Throwable;

class CategoryController extends Controller
{
    private CategoriesService $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    public function create(CategoryCreateRequest $request): JsonResponse
    {
        $data = [];

        try {
            $data = $this->categoriesService->create($request);
            if($data['code'] != 200){
                return Response::Error($data['category'], $data['message'], $data['code']);
            }

            return Response::Success($data['category'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function get(): JsonResponse
    {
        $data = [];

        try{
            $data = $this->categoriesService->get();

            if($data['code'] != 200){
                return Response::Error($data['categories'], $data['message'], $data['code']);
            }

            return Response::Success($data['categories'], $data['message'], $data['code']);
        }

        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function update(CategoryUpdateRequest $request, $id): JsonResponse
    {
        $data = [];

        try {
            $data = $this->categoriesService->update($request, $id);
            if($data['code'] != 200){
                return Response::Error($data['category'], $data['message'], $data['code']);
            }
            return Response::Success($data['category'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function delete($id): JsonResponse
    {
        $data = [];

        try {
            $data = $this->categoriesService->delete($id);
            if($data['code'] != 200){
                return Response::Error($data['category'], $data['message'], $data['code']);
            }
            return Response::Success($data['category'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function getById($id): JsonResponse
    {
        $data = [];

        try {
            $data = $this->categoriesService->getById($id);
            if($data['code'] != 200){
                return Response::Error($data['category'], $data['message'], $data['code']);
            }
            return Response::Success($data['category'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function getDetails($id): JsonResponse
    {
        $data = [];

        try {
            $data = $this->categoriesService->getDetails($id);

            if($data['code'] != 200){
                return Response::Error($data['category'], $data['message'], $data['code']);
            }
            return Response::Success($data['category'], $data['message'], $data['code']);
        }

        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function getSubCategories($id): JsonResponse
    {
        $data = [];

        try {
            $data = $this->categoriesService->getSubCategories($id);
            if($data['code'] != 200){
                return Response::Error($data['category'], $data['message'], $data['code']);
            }
            return Response::Success($data['category'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function getAll(): JsonResponse
    {
        $data = [];

        try {
            $data = $this->categoriesService->getAll();
            if($data['code'] != 200){
                return Response::Error($data['category'], $data['message'], $data['code']);
            }
            return Response::Success($data['category'], $data['message'], $data['code']);
        }
        catch(Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data, $message);
        }
    }
}
