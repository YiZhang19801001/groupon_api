<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * retreive all products 1. grouped by category 2. with full details (choices,options)
     * @param none
     * @return Response
     */
    public function index($language_id)
    {
        $categories = Category::all();

        $responseData = [];

        foreach ($categories as $category) {
            $dto = [];
            $dto['category_id'] = $category->category_id;

            // find category for $language_id matching language
            $categoryDescription = $category->descriptions()->where('language_id', $language_id)->first();
            if ($categoryDescription === null) { // if no matching language record provide default validate value for it.
                $categoryDescription = $category->descriptions()->first();
            }
            $dto['name'] = $categoryDescription->name;

            $products = $category->products()->get();
            foreach ($products as $product) {
                $options = array();
                $product_options = $product->options()->get();
                foreach ($product_options as $product_option) {
                    $newOption = array();

                    $productOptionDescription = $product_option->optionDescriptions()->where('language_id', $language_id)->first();
                    if ($productOptionDescription === null) {
                        $productOptionDescription = $product_option->optionDescriptions()->first();

                    }
                    $newOption['option_name'] = $productOptionDescription->name;

                    $newOption['required'] = $product_option->required;
                    $newOption['type'] = $product_option->option->type;

                    $newValues = array();

                    $productOptionValues = $product_option->optionValues()->get();
                    foreach ($productOptionValues as $productOptionValue) {
                        $newValue = array();

                        $productOptionValueDescription = $productOptionValue->descriptions()->where('language_id', $language_id)->first();
                        if ($productOptionValueDescription === null) {
                            $productOptionValueDescription = $productOptionValue->descriptions()->first();
                        }

                        $newValue['name'] = $productOptionValueDescription->name;
                        $newValue['price'] = number_format($productOptionValue->price, 2);

                        array_push($newValues, $newValue);
                    }
                    $newOption['values'] = $newValues;
                    array_push($options, $newOption);
                }
                $product['options'] = $options;
            }
            $dto['products'] = $products;
            array_push($responseData, $dto);
        }

        return response()->json($responseData, 200);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'sku' => 'required',
        ]);

        $input = $request->only('quantity', 'price', 'sku');

        $product = Product::create($input);

        return response()->json($product, 201);
    }

    public function update(Request $request, $product_id)
    {
        $validatedData = $request->validate([
            'price' => 'numeric',
            'quantity' => 'integer',
            'sku' => 'string',
        ]);

        $product = Product::findOrFail($product_id);
        $product->update($request->all());

        $product->save();

        return response()->json($product, 200);

    }
}

/**
 * Todo ::remove 😌
 */

// 📜 update (old way 👴)
// if (!is_null($request->price)) {
//     $product->price = $request->price;
// }

// if (!is_null($request->quantity)) {
//     $product->quantity = $request->quantity;
// }

// if (!is_null($request->sku)) {
//     $product->sku = $request->sku;
// }
// end 🔚
