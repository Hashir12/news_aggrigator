<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function toggleUserCategory($id)
    {
        $category = Category::where('id',$id)->first();
        if (!$category) {
            return ['error' => 'No category found.'];
        }

        $user = Auth::user();

        $query = $user->categories();
        $query->toggle([$id]);

        if (!$category->parent_id) {
            $isChecked = DB::table('user_categories')
                ->where('user_id', $user->id)
                ->where('category_id', $id)
                ->exists();

            $categoryChildIds = $category->categories()->pluck('id')->toArray();
            $isChecked ? $query->syncWithoutDetaching($categoryChildIds) : $query->detach($categoryChildIds);
        } else {
            $parentCategory = $category->parentCategory;
            $categoryChildIds = $parentCategory->categories()->pluck('id');
            $checkedCount = DB::table('user_categories')
                ->where('user_id', $user->id)
                ->whereIn('category_id', $categoryChildIds)
                ->count();

            if ($checkedCount === $categoryChildIds->count()) {
                $query->syncWithoutDetaching([$parentCategory->id]);
            }
            else {
                $query->detach([$parentCategory->id]);
            }
        }
        return true;
    }
}
