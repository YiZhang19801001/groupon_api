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
    public function index(Request $request)
    {

        $language_id = isset($request->language_id) ? $request->language_id : 2;

        $response_array = self::getCategoryList($language_id);
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
            'chinese_name' => 'required',
            'english_name' => 'required',
        ]);
        $language_id = isset($request->language_id) ? $request->language_id : 2;

        $categoryDescriptions = CategoryDescription::where('name', $request->name)->get();
        if (count($categoryDescriptions) > 0) {
            return response()->json(['errors' => ['message' => "This category is already exists"]], 422);
        }

        $category = Category::create();
        $categoryDescription1 = CategoryDescription::create(['category_id' => $category->category_id, 'name' => $request->chinese_name, 'language_id' => 1]);
        $categoryDescription2 = CategoryDescription::create(['category_id' => $category->category_id, 'name' => $request->english_name, 'language_id' => 2]);

        $response_array = self::getCategoryList($language_id);

        return response()->json($response_array, 201);

    }

    public function update(Request $request, $category_id)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'language_id' => 'required|integer',
        // ]);
        $language_id = isset($request->language_id) ? $request->language_id : 2;

        $category = Category::find($category_id);

        if (!$category) {
            return response()->json(['errors' => ['Messages' => 'This category can not be found.']], 400);
        }

        $categoryDescription1 = CategoryDescription::where("category_id", $category_id)->where("language_id", 1)->first();
        $categoryDescription1->name = $request->english_name;
        $categoryDescription1->save();

        $categoryDescription2 = CategoryDescription::where("category_id", $category_id)->where("language_id", 2)->first();
        $categoryDescription2->name = $request->chinese_name;
        $categoryDescription2->save();

        $response_array = self::getCategoryList($language_id);
        return response()->json($response_array, 200);
    }

    public function getCategoryList($language_id)
    {
        $response_array = array();
        $categories = Category::all();

        foreach ($categories as $category) {
            $item = array();

            $description = $category->descriptions()->where('language_id', $language_id)->first();
            if ($description === null) {
                $description = $category->descriptions()->first();

            }

            $description2 = $category->descriptions()->where('language_id', '!=', $language_id)->first();

            $count = $category->products()->count();
            $item['category_id'] = $category->category_id;
            $item['name'] = $description->name;
            $item['other_name'] = $description2->name;
            $item["number_of_products"] = $count;

            array_push($response_array, $item);
        }

        return $response_array;

    }

}
