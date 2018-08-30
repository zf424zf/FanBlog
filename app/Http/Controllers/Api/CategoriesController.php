<?php

namespace App\Http\Controllers\Api;


use App\Models\Category;
use App\Transformers\CategoryTransformer;

class CategoriesController extends Controller
{
    //
    public function index()
    {
        return $this->response->collection(Category::all(), app(CategoryTransformer::class));
    }
}
