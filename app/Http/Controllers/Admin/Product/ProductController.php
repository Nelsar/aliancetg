<?php

namespace App\Http\Controllers\Admin\Product;


use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $perPage = 25;

        $products = Product::latest()->paginate($perPage);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.create', compact('products', 'categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
 
        $request->validated();

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }

        $getrequest = $request->all();

        /*Find Request Category */
        $getcategory = Category::findOrFail($getrequest['category_id']);
        
        /*Find Request Brand */
        $getbrand = Brand::findOrFail($getrequest['brand_id']);

        $product = new Product();
        $product->sku = $getrequest['sku'];
        $product->article = $getrequest['article'];
        $product->name = $getrequest['name'];
        $product->fullName = $getrequest['fullName'];
        $product->description = $getrequest['description'];
        $product->images = $path ?? null;
        $product->category_id = $getcategory->id;
        $product->brand_id = $getbrand->id;
        $product->save();

        return redirect('admin/products')->with('flash_message', 'Товар добавлен');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $getproduct = Product::findOrFail($product->id);
        $getbrand = Brand::findOrFail($product->brand_id);
        $getcategory = Category::findOrFail($product->category_id);
        return view('admin.products.show', compact('getproduct', 'getbrand', 'getcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $getproduct = Product::findOrFail($product->id);
        return view('admin.products.edit', compact('getproduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $request->validated();

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }

        $getrequest = $request->all();

        /*Find Request Category */
        $getcategory = Category::findOrFail($getrequest['category_id']);

        /*Find Request Brand */
        $getbrand = Brand::findOrFail($getrequest['brand_id']);

        $product = new Product();
        $product->sku = $getrequest['sku'];
        $product->article = $getrequest['article'];
        $product->name = $getrequest['name'];
        $product->fullName = $getrequest['fullName'];
        $product->description = $getrequest['description'];
        $product->images = $path ?? null;
        $product->category_id = $getcategory->id;
        $product->brand_id = $getbrand->id;
        $product->update();

        return redirect('admin/products')->with('flash_message', 'Товар Обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $getproduct = Product::findOrFail($product->id);
        $getproduct->delete();
        return redirect('admin/products')->with('flash_message', 'Товар удален');
    }
}
