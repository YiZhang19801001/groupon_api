<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryDescription;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($language_id)
    {
        $category = Category::all();
        $categoryDescriptions = CategoryDescription::where('language_id',$language_id);
    }
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'language_id' => 'required|integer',
        ]);

        $categoryDescriptions = CategoryDescription::where('name', $request->name)->get();
        if (count($categoryDescriptions) > 0) {
            return response()->json(['errors' => ['message' => "This category is already exists"]], 422);
        }

        $category = Category::create();
        $categoryDescription = CategoryDescription::create(['category_id' => $category->category_id, 'name' => $request->name, 'language_id' => $request->language_id]);

        return response()->json(['category_id' => $category->category_id, 'name' => $categoryDescription->name], 201);

    }

    public function update(Request $request, $category_id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'language_id' => 'required|integer',
        ]);

        $categoryDescription = CategoryDescription::where('category_id', $category_id)->where('language_id', $request->language_id)->first();

        if (!$categoryDescription) {
            return response()->json(['errors' => ['Messages' => 'This category can not be found.']], 400);
        }

        $categoryDescription->update($request->all());

        return response()->json(['category_id' => $categoryDescription->category_id, 'name' => $categoryDescription->name], 200);
    }
}
