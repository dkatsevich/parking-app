<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    public function index(Response $response)
    {
        return Category::tree();
    }

    public function show(Response $response, Category $category)
    {

        return Category::productsByCategory($category->id);

        // return Product::with('category')->where(

        //     function ($query) {
        //         $query->where('name', 'John')
        //               ->orWhere('name', 'Jane');
        //     }

        // )
        // ->where('qty', '<>', 0)->get();


        // return Product::where('category_id', $category->id)
        //                 ->where('qty', '<>', 0)->get();
    }
}
