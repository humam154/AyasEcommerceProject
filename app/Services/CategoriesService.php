<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoriesService
{

    public function create($request) : array
    {
        $imagePath = ' ';
        if ($request->hasFile('image')) {

                $ext = $request->file('image')->extension();

                $final_name = date('YmdHis') . '.' . $ext;

                $request->file('image')->move(public_path('uploads/categories'), $final_name);

                $imagePath = '/uploads/categories/' . $final_name;

        }
        if(!$request->has('parent_id')) {
            $lastId = (Category::latest('id')->value('id')) + 1;
            if(is_null($lastId)) {
                $lastId = 1;
            }
        } else {
            $lastId = (int) $request['parent_id'];
        }
        $category = Category::query()->create([
            'parent_id' => $lastId,
            'name' => $request['name'],
            'description' => $request['description'] ?? ' ',
            'image' => $imagePath,
        ]);


        $message = 'created successfully';
        $code = 201;

        return ['category' => $category, 'message' => $message, 'code' => $code];
    }

    public function get(): array
    {
        $categories = Category::query()->where('is_deleted', false)->select('name', 'image')->get();
        if ($categories->isEmpty()) {
            $message = 'No categories found';
            $code = 404;
        } else {
            $message = 'Success';
            $code = 200;
        }

        return ['categories' => $categories, 'message' => $message, 'code' => $code];
    }

    public function update($request, $id) : array
    {
        $category = Category::query()->find($id);

        if(!is_null($category)) {

            if ($request->hasFile('image')) {
                if(file_exists(public_path('uploads/categories/' . $category['image'])) AND !empty($category['image'])) {
                    unlink(public_path('uploads/categories/' . $category['image']));
                }

                $ext = $request->file('image')->extension();

                $final_name = date('YmdHis') . '.' . $ext;

                $request->file('image')->move(public_path('uploads/categories'), $final_name);

                $imagePath = '/uploads/categories/' . $final_name;

            }

            Category::query()->find($id)->update([
                'name' => $request['name'] ?? $category['name'],
                'description' => $request['description'] ?? $category['description'],
                'image' => $imagePath ?? $category['image'],
            ]);

            $category = Category::query()->find($id);
            $message = 'updated successfully';
            $code = 200;
        } else {
            $message = 'no category found';
            $code = 404;
        }

        return ['category' => $category, 'message' => $message, 'code' => $code];
    }

    public function delete($id) : array
    {
        $category = Category::query()->find($id);

        if(!is_null($category)) {

            Category::query()->find($id)->update([
                'is_deleted' => true,
            ]);
            $category = Category::query()->find($id);
            $message = 'deleted successfully';
            $code = 200;
        } else {
            $message = 'no category found';
            $code = 404;
        }

        return ['category' => $category, 'message' => $message, 'code' => $code];
    }
    public function getById($id) : array
    {
        $category = Category::query()->where('id', $id)->select('name', 'image')->first();
        if(!is_null($category)) {
            $message = 'success';
            $code = 200;
        } else {
            $category = [];
            $message = 'no category found';
            $code = 404;
        }

        return ['category' => $category, 'message' => $message, 'code' => $code];
    }
    public function getDetails($id) : array
    {
        $category = Category::with(['parentCategory', 'subCategories'])->find($id);

        if(!is_null($category)) {
            $message = 'success';
            $code = 200;
        } else {
            $category = [];
            $message = 'no category found';
            $code = 404;
        }

        return ['category' => $category, 'message' => $message, 'code' => $code];
    }

    public function getSubCategories($id) : array
    {
        $category = Category::with(['subCategories'])->find($id);
        if (!is_null($category)) {
            $category = $category->subCategories;
            $message = 'success';
            $code = 200;
        } else {
            $category = [];
            $message = 'no category found';
            $code = 404;
        }

        return ['category' => $category, 'message' => $message, 'code' => $code];
    }

    public function getAll() : array
    {
        $categories = Category::all();

        if (!$categories->isEmpty()) {
            $message = 'success';
            $code = 200;
        } else {
            $message = 'no categories found';
            $code = 404;
        }

        return ['categories' => $categories, 'message' => $message, 'code' => $code];
    }

    public function restore($id) : array
    {
        $category = Category::query()->find($id);
        if(!is_null($category)) {
            Category::query()->find($id)->update([
                'is_deleted' => false,
            ]);
            $category = Category::query()->find($id);
            $message = 'restored successfully';
            $code = 200;
        } else {
            $message = 'no category found';
            $code = 404;
        }

        return ['category' => $category, 'message' => $message, 'code' => $code];
    }

}
