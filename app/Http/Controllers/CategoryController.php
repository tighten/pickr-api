<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::where('user_id', 1)->with('items')->get());
    }

    public function store()
    {
        request()->validate(['name' => 'required|string|max:20']);

        $category = Category::create([
            'name' => request()->input('name'),
            'user_id' => 1,
        ]);

        return response()->json($category);
    }

    public function update(Category $category)
    {
        request()->validate([
            'name' => 'required|string|max:20',
        ]);

        $category->update([
            'name' => request()->input('name'),
        ]);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([], 204);
    }
}
