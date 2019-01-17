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
    public function index()
    {
        $categories = Category::all();

        $responseData = [];

        foreach ($categories as $category) {
            $dto = [];
            $dto['category_id'] = $category->category_id;
            $dto['name'] = $category->description->name;
            $products = $category->products()->get();
            // foreach ($products as $product) {
            //     $product['options'] = $product->options();
            // }
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
