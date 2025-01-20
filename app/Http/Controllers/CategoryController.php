<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function CategoriesList(Request $request)
    {
        $categories = Category::with('categories');

        if ($request->has('name')) {
            $categories = $categories->where('name','like','%' . $request->get('name') . '%');
        }

        $categories = $categories->whereNull('parent_id')
            ->orderByDesc('id')
            ->paginate(10);
        return CategoryResource::collection($categories);
    }

    public function userFavoriteCategories()
    {
        $data['userCategories'] = Auth::user()->categories();
        $data['category'] = Category::with('categories')
            ->whereNull('parent_id')
            ->get();

        return ['data' => $data];
    }
}
