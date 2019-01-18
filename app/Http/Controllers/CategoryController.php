<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryDescription;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * return all categories with selected language - if no description name in this language use default language as alternative
     * @param Integer $language_id
     * @return Response all categories
     *
     */
    public function index($language_id)
    {
        $response_array = array();
        $categories = Category::all();

        foreach ($categories as $category) {
            $item = array();

            $description = $category->descriptions()->where('language_id', $language_id)->first();
            if ($description === null) {
                $description = $category->descriptions()->first();

            }
            $item['category_id'] = $category->category_id;
            $item['name'] = $description->name;

            array_push($response_array, $item);
        }

        return response()->json(['categories' => $response_array], 200);

    }
    /**
     * return single category format ['category_id','name']
     * @param Integer $language_id
     * @param Integer $category_id
     * @return Response select category with name
     */
    public function show($language_id, $category_id)
    {
        $category = Category::find($category_id);
        $description = $category->descriptions()->where('language_id', $language_id)->first();
        if ($description === null) {
            $description = $category->descriptions()->first();

        }

        return response()->json(['category' => ['category_id' => $category->category_id, 'name' => $description->name]], 200);
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
