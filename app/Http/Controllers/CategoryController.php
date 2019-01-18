<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryDescription;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'languageId' => 'required|integer',
        ]);

        $categoryDescriptions = CategoryDescription::where('name', $request->name)->get();
        if (count($categoryDescriptions) > 0) {
            return response()->json(['errors' => ['message' => "This category is already exists"]], 422);
        }

        $category = Category::create();
        $categoryDescription = CategoryDescription::create(['category_id' => $category->category_id, 'name' => $request->name, 'language_id' => $request->languageId]);

        return response()->json(['category_id' => $category->category_id, 'name' => $categoryDescription->name], 201);

    }
}
