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
use App\ProductToCategory;
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
                    $newOption['product_option_id'] = $product_option->product_option_id;
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
                        $newValue['product_option_value_id'] = $productOptionValue->product_option_value_id;
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
        //1. validation
        $validatedData = $request->validate([
            'category_id' => 'required|integer',
        ]);

        $errors = $this->validateRequest($request);

        $request->product = json_decode(json_encode($request->product));

        //1.1 validate product.sku duplication
        if (isset($request->product->sku)) {
            $row = Product::where('sku', $request->product->sku)->get();
            if (count($row) > 0) {
                $errors['product.sku'] = ['The product sku is duplicate in database.'];
            }
        }

        if (count($errors) > 0) {
            return response()->json(compact('errors'), 422);
        }

        // create product with details and make response body
        $response_array = array();
        //2. create oc_product
        $product = Product::create(['price' => $request->product->price, 'sku' => $request->product->sku, 'quantity' => $request->product->quantity]);

        //3. create oc_product_description [multiple descriptions should be created, as user may entry all names for different languages]
        $productDescriptions = array();
        foreach ($request->descriptions as $productDescription) {
            $productDescription = json_decode(json_encode($productDescription));
            $newProductDescription = ProductDescription::create(['product_id' => $product->product_id, 'language_id' => $productDescription->language_id, 'name' => $productDescription->name]);
            array_push($productDescriptions, $newProductDescription);
        }

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

        // mapping value for response body;
        $response_array['category_id'] = $request->category_id;
        $response_array['product'] = ['price' => number_format($product->price, 2), 'sku' => $product->sku, 'quantity' => $product->quantity];
        $response_array['descriptions'] = $productDescriptions;
        $response_array['options'] = $options;

        return response()->json($response_array, 201);
    }

    /**
     * update product
     * @param Request $request body
     * @param Integer $product_id
     */
    public function update(Request $request, $product_id)
    {
        //1. validation
        $errors = $this->validateRequest($request);
        $request->product = json_decode(json_encode($request->product));

        if (!is_numeric($product_id) || !is_integer($product_id + 0)) {
            $errors['product_id'] = ['The product id field is required.'];

        } else {

            $product = Product::find($product_id);
            if ($product === null) {
                $errors['product'] = ['The product is not found.'];
            }
        }
        if (count($errors) > 0) {
            return response()->json(compact('errors'), 422);
        }

        // update product and prepare the response body
        //2. update oc_product
        $product = Product::find($product_id);
        $product->price = $request->product->price;
        $product->sku = $request->product->sku;
        $product->quantity = $request->product->quantity;
        $product->save();

        //3. update oc_product_description [multiple descriptions should be created, as user may update all names for different languages]
        $productDescriptions = array();
        foreach ($request->descriptions as $productDescription) {
            $productDescription = json_decode(json_encode($productDescription));
            $newProductDescription = ProductDescription::where('product_id', $product->product_id)->where('language_id', $productDescription->language_id)->first();
            if ($newProductDescription !== null) {
                $newProductDescription->update(['name' => $productDescription->name, 'language_id' => $productDescription->language_id, 'product_id' => $product->product_id]);
            } else {
                $newProductDescription = ProductDescription::create(['product_id' => $product->product_id, 'language_id' => $productDescription->language_id, 'name' => $productDescription->name]);
            }
            array_push($productDescriptions, $newProductDescription);
        }

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
                $newOptionDescription = OptionDescription::where('option_id', $option->option_id)->where('language_id', $optionDescription->language_id)->first();
                if ($newOptionDescription !== null) {

                    $newOptionDescription->update([
                        'option_id' => $option->option_id,
                        'language_id' => $optionDescription->language_id,
                        'name' => $optionDescription->name,
                    ]);
                } else {
                    $newOptionDescription = OptionDescription::create(['option_id' => $option->option_id, 'language_id' => $optionDescription->language_id, 'name' => $optionDescription->name]);

                }
                array_push($optionDescriptions, ['name' => $newOptionDescription->name, 'language_id' => $newOptionDescription->language_id]);
            }
            $option_array['descriptions'] = $optionDescriptions;
//safe
            //4.3 create oc_product_option
            $productOption = ProductOption::find($option->product_option_id);
            if ($productOption !== null) {
                $productOption->option_id = $option->option_id;
                $productOption->value = isset($option->value) ? $option->value : '';
                $productOption->required = $option->required;
                $productOption->save();

            } else {
                $productOption = ProductOption::create(['product_id' => $product->product_id, 'option_id' => $option->option_id, 'value' => isset($option->value) ? $option->value : '', 'required' => $option->required]);

            }
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
                    $newOptionValueDescription = OptionValueDescription::where('option_value_id', $value->option_value_id)->where('language_id', $optionValueDescription->language_id)->first();
                    if ($newOptionValueDescription !== null) {
                        $newOptionValueDescription->name = $optionValueDescription->name;
                        $newOptionValueDescription->save();
                    } else {

                        $newOptionValueDescription = OptionValueDescription::create(['option_value_id' => $value->option_value_id, 'language_id' => $optionValueDescription->language_id, 'option_id' => $option->option_id, 'name' => $optionValueDescription->name]);
                    }

                    array_push($optionValueDescriptions, ['name' => $newOptionValueDescription->name, 'language_id' => $newOptionValueDescription->language_id]);
                }

                //4.6 create oc_product_option_value
                $productOptionValue = ProductOptionValue::find($value->product_option_value_id);
                if ($productOptionValue !== null) {
                    $productOptionValue->product_option_id = $productOption->product_option_id;
                    $productOptionValue->product_id = $product->product_id;
                    $productOptionValue->option_id = $option->option_id;
                    $productOptionValue->option_value_id = $value->option_value_id;
                    if (isset($value->quantity)) {
                        $productOptionValue->quantity = $value->quantity;
                    }
                    $productOptionValue->price = $value->price;

                    $productOptionValue->save();
                } else {
                    $productOptionValue = ProductOptionValue::create(['product_option_id' => $productOption->product_option_id, 'product_id' => $product->product_id, 'option_id' => $option->option_id, 'option_value_id' => $value->option_value_id, 'quantity' => isset($value->quantity) ? $value->quantity : 999, 'price' => $value->price]);

                }
                array_push($optionValues, ['option_value_id' => $productOptionValue->option_value_id, 'price' => number_format($productOptionValue->price, 2), 'quantity' => $productOptionValue->quantity, 'descriptions' => $optionValueDescriptions]);
            }

            $option_array['values'] = $optionValues;

            array_push($options, $option_array);
        }

        // mapping value for response body;
        $response_array['category_id'] = $request->category_id;
        $response_array['product'] = ['price' => number_format($product->price, 2), 'sku' => $product->sku, 'quantity' => $product->quantity];
        $response_array['descriptions'] = $productDescriptions;
        $response_array['options'] = $options;

        return response()->json($response_array, 200);

    }

    /**
     * show single product according to product_id
     * @param Integer Product_id
     * @return Response product with details
     */
    public function show($product_id)
    {
        $responseData = array();
        //1. fetch product
        $product = Product::find($product_id);
        $responseData['product'] = $product;
        //2. add details
        //2.1 descriptions
        $responseData['descriptions'] = $product->descriptions()->get();
        //2.2 category
        $responseData['category_id'] = ProductToCategory::where('product_id', $product_id)->first()->category_id;
        //2.3 options
        $responseData['options'] = $product->options()->get();
        foreach ($responseData['options'] as $value) {
            $value['descriptions'] = $value->optionDescriptions()->get();
        }

        //2.4 option values
        $responseData['optionValues'] = $product->optionValues()->get();
        foreach ($responseData['optionValues'] as $value) {
            $value['descriptions'] = $value->descriptions()->get();
        }
        //3. return response
        return response()->json($responseData, 200);
    }

    /**
     * validate $request body isset() 😲 datatype 😲
     * @param Request $request body
     * @return Array errors array
     */
    public function validateRequest($request)
    {
        $errors = array();
        //1. validate incorrect category
        $category = Category::find($request->category_id);

        if ($category === null) {
            $errors['category'] = ['The category is not found.'];
            return $errors;
        }

        //2. validate requiration layer 1
        if (!isset($request->product)) {
            $errors['product'] = ['The product filed is required.'];
            return $errors;
        }

        //3. validate requiration layer 2
        $request->product = json_decode(json_encode($request->product));
        if (!isset($request->product->price) || !isset($request->product->quantity) || !isset($request->product->sku)) {

            if (!isset($request->product->price)) {
                $errors['product.price'] = ['The product.price field is required.'];
            }
            if (!isset($request->product->quantity)) {
                $errors['product.quantity'] = ['The product.quantity field is required.'];
            }

            if (!isset($request->product->sku)) {
                $errors['product.sku'] = ['The product.sku field is required.'];
            }

            return $errors;
        }

    }

}
