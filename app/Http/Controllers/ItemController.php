<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;

class ItemController extends Controller
{
    public function store(Category $category)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $item = Item::create([
            'name' => request()->input('name'),
            'description' => request()->input('description'),
            'category_id' => $category->id,
        ]);

        return response()->json($item);
    }

    public function update(Category $category, Item $item)
    {
        request()->validate([
            'name' => 'required|string|max:20',
            'description' => 'required|string|max:255',
        ]);

        $item->update([
            'name' => request()->input('name'),
            'description' => request()->input('description'),
        ]);

        return response()->json($item);
    }

    public function destroy(Category $category, Item $item)
    {
        $item->delete();

        return response()->json([], 204);
    }
}
