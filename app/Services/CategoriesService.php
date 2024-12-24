<?php

namespace App\Services;

use App\Models\Category;

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
        $category = Category::query()->create([
            'name' => $request['name'],
            'description' => $request['description'] ?? ' ',
            'image' => $imagePath,
        ]);

        if(!is_null($request['parent_id'])) {
            $category->update(['parent_id' => $request['parent_id']]);
        } else {
            $category->update(['parent_id' => $category['id']]);
        }

        $message = 'created successfully';
        $code = 201;

        return ['category' => $category, 'message' => $message, 'code' => $code];
    }

    public function get(): array
    {
        $categories = Category::query()->select('name', 'image')->get();
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

            $imagePath = ' ';
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
                'image' => $imagePath,
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

            if(file_exists(public_path('uploads/categories/' . $category['image'])) AND !empty($category['image'])) {
                unlink(public_path('uploads/categories/' . $category['image']));
            }

            $category = $category->delete();
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
        $category = Category::with(['subCategories'])->find($id);

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
        $categories = Category::withTrashed()->select('name', 'image')->get();
        if ($categories->isEmpty()) {
            $categories = [];
            $message = 'no categories found';
            $code = 404;
        } else {
            $message = 'success';
            $code = 200;
        }

        return ['categories' => $categories, 'message' => $message, 'code' => $code];
    }

}
