<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 25;
        $brands = Brand::latest()->paginate($perPage);

        return BrandResource::collection($brands);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getbrand = Brand::findOrFail($id);

        return new BrandResource($getbrand);
    }
}
