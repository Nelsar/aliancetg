<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;

class BrandController extends Controller
{
    public function index()
    {
        $perPage = 25;

        $brands = Brand::latest()->paginate($perPage);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $request->validated();

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }

        $getrequest = $request->all();

        $brand = new Brand();
        $brand->name = $getrequest['name'];
        $brand->image = $path ?? null;
        $brand->description = $getrequest['description'];
        $brand->save();

        return redirect('admin/brands')->with('flash_message', 'Категория добавлена');

    }

    public function show(Brand $brand)
    {
        $getbrand = Brand::findOrFail($brand->id);
        return view('admin.brands.show', compact('getbrand'));
    }

    public function edit(Brand $brand)
    {
        $getbrand = Brand::findOrFail($brand->id);
        return view('admin.brands.edit', compact('getbrand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $getrequest = $request->all();

        $request->validated();

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }

        $getbrand = Brand::findOrFail($brand->id);
        $getbrand->name = $getrequest['name'];
        $getbrand->image = $path ?? null;
        $getbrand->update();

        return redirect('admin/brands')->with('flash_message', 'Категория Обновлена');
    }

    public function destroy($id)
    {
        $getbrand = Brand::findOrFail($id);
        $getbrand->delete();
        return redirect('admin/brands')->with('flash_message', 'Категория удалена');
    }
}
