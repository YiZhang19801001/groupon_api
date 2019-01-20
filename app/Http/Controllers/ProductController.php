<?php

namespace App\Http\Controllers;

use App\Category;
use App\Option;
use App\OptionDescription;
use App\OptionValue;
use App\OptionValueDescription;
use App\Product;
use App\ProductDescription;
use App\ProductOption;
use App\ProductOptionValue;
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
                $productDescription = $product->descriptions()->where('language_id', $language_id)->first();
                if ($productDescription === null) {
                    $productDescription = $product->descriptions()->first();
                }
                $product['name'] = $productDescription->name;

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

    /**
     * create product
     * @param Request
     * @return Response new product json just created
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|integer',

        ]);

        $response_array = array();
        //1. check category is available or not
        // $category = Category::find($request->category_id);
        // if ($category === null) {
        //     return response()->json(['errors' => ['message' => 'The category is not found']], 400);
        // }

        $response_array['category_id'] = $request->category_id;

        $request->product = json_decode(json_encode($request->product));

        //2. create oc_product
        if (!isset($request->product->price) || !isset($request->product->quantity) || !isset($request->product->sku)) {
            $errors = array();
            if (!isset($request->product->price)) {
                $errors['product.price'] = ['The product.price field is required.'];
            }
            if (!isset($request->product->quantity)) {
                $errors['product.quantity'] = ['The product.quantity field is required.'];
            }

            if (!isset($request->product->sku)) {
                $errors['product.sku'] = ['The product.sku field is required.'];
            }

            return response()->json(['errors' => $errors], 422);
        }

        // die(json_encode($request->product->quantity));
        $product = Product::create(['price' => $request->product->price, 'sku' => $request->product->sku, 'quantity' => $request->product->quantity]);
        $response_array['product'] = ['price' => number_format($product->price, 2), 'sku' => $product->sku, 'quantity' => $product->quantity];
        //3. create oc_product_description [multiple descriptions should be created, as user may entry all names for different languages]
        $productDescriptions = array();
        foreach ($request->descriptions as $productDescription) {
            $productDescription = json_decode(json_encode($productDescription));
            $newProductDescription = ProductDescription::create(['product_id' => $product->product_id, 'language_id' => $productDescription->language_id, 'name' => $productDescription->name]);
            array_push($productDescriptions, $newProductDescription);
        }
        $response_array['descriptions'] = $productDescriptions;
        //4. create options for product
        $options = array();
        foreach ($request->options as $option) {
            $option = json_decode(json_encode($option));

            $option_array = array();
            //4.1 create oc_option if no exsiting option
            if ($option->option_id === 'new') {
                $newOption = Option::create(['type' => $option->type, 'sort_order' => 1]);
                $option->option_id = $newOption->option_id;
            }

            $option_array['option_id'] = $option->option_id;
            $option_array['type'] = $option->type;

            //4.2 create oc_option_description
            $optionDescriptions = array();
            foreach ($option->descriptions as $optionDescription) {
                $optionDescription = json_decode(json_encode($optionDescription));

                $newOptionDescription = OptionDescription::create(['option_id' => $option->option_id, 'language_id' => $optionDescription->language_id, 'name' => $optionDescription->name]);
                array_push($optionDescriptions, ['name' => $newOptionDescription->name, 'language_id' => $newOptionDescription->language_id]);
            }
            $option_array['descriptions'] = $optionDescriptions;

            //4.3 create oc_product_option
            $productOption = ProductOption::create(['product_id' => $product->product_id, 'option_id' => $option->option_id, 'value' => isset($option->value) ? $option->value : '', 'required' => $option->required]);
            $option_array['required'] = $productOption->required;
            $option_array['value'] = $productOption->value;

            $optionValues = array();
            // create option_values
            foreach ($option->values as $value) {
                $value = json_decode(json_encode($value));
                //4.4 create oc_option_value
                if ($value->option_value_id === 'new') {
                    $newOptionValue = OptionValue::create(['option_id' => $option->option_id]);
                    $value->option_value_id = $newOptionValue->option_value_id;
                }
                //4.5 create oc_option_value_description
                $optionValueDescriptions = array();
                foreach ($value->descriptions as $optionValueDescription) {
                    $optionValueDescription = json_decode(json_encode($optionValueDescription));
                    $newOptionValueDescription = OptionValueDescription::create(['option_value_id' => $value->option_value_id, 'language_id' => $optionValueDescription->language_id, 'option_id' => $option->option_id, 'name' => $optionValueDescription->name]);

                    array_push($optionValueDescriptions, ['name' => $newOptionValueDescription->name, 'language_id' => $newOptionValueDescription->language_id]);
                }

                //4.6 create oc_product_option_value
                $productOptionValue = ProductOptionValue::create(['product_option_id' => $productOption->product_option_id, 'product_id' => $product->product_id, 'option_id' => $option->option_id, 'option_value_id' => $value->option_value_id, 'quantity' => isset($value->quantity) ? $value->quantity : 999, 'price' => $value->price]);
                array_push($optionValues, ['option_value_id' => $productOptionValue->option_value_id, 'price' => number_format($productOptionValue->price, 2), 'quantity' => $productOptionValue->quantity, 'descriptions' => $optionValueDescriptions]);
            }

            $option_array['values'] = $optionValues;

            array_push($options, $option_array);
        }

        $response_array['options'] = $options;

        return response()->json($response_array, 201);
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
