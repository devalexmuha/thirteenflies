<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Catalog\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('products')->get();
        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('products');
        return CategoryResource::make($category);
    }
}
