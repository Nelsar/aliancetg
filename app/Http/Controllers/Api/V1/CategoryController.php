<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = new Category();

        return CategoryResource::collection($categories->all());
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return new CategoryResource($category);
    }
}
