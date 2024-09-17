<?php

namespace App\Http\Controllers\Admin\Category;


use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 25;

        $categories = Category::latest()->paginate($perPage);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->validated();

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }

        $requestData = $request->all();

        $category = new Category();
        $category->name = $requestData['name'];
        $category->image = $path ?? null;
        $category->save();

        return redirect('admin/categories')->with('flash_message', 'Категория добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $categoryData = Category::findOrFail($category->id);

        return view('admin.categories.show', compact('categoryData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::findOrFail($category->id);
        return view('admin.categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $requestData = $request->all();

        $request->validated();

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }


        $categoryData = Category::findOrFail($category->id);

        $categoryData->name = $requestData['name'];
        $categoryData->image = $path ?? null;
        $categoryData->update();

        return redirect('admin/categories')->with('flash_message', 'Категория добавлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $categoryData = Category::findOrFail($category->id);
        $categoryData->delete();
        return redirect('admin/categories')->with('flash_message', 'Категория удалена');
    }
}
