<?php
namespace App\Http\Controllers\helpers;

use App\Category;
use App\Product;
use App\ProductToCategory;

class ProductHelper
{
    /**
     * helper function fetch all products list from DB
     *
     * @param integer $language_id
     * @param integer $status
     * @return Array
     */
    public function getProductsList($language_id, $status, $search_string, $user_group_id)
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

            $products = $category->products()->where("status", $status)->where("quantity", ">", 0)->orderBy("sort_order", "desc")->get();

            foreach ($products as $product) {
                # deal with discount
                // Todo:: read $user_group_id from $reqeust;
                $user_group_id = 2;
                $discountInfo = self::makeDiscountInfo($product, $user_group_id);
                $product["price"] = $discountInfo["price"];
                $product["isDiscount"] = $discountInfo["status"];

                # make product name
                $productDescription = $product->descriptions()->where('language_id', $language_id)->first();
                if ($productDescription === null) {
                    $productDescription = $product->descriptions()->first();
                }
                $product['name'] = $productDescription->name;

                # make product image
                $image_path = config("app.baseurl") . $product["image"];

                if ($product["image"] === null || !file_exists($_SERVER['DOCUMENT_ROOT'] . $image_path)) {
                    $product["image"] = '/images/products/default_product.jpg';

                }

                if ($search_string !== "" && !(strpos($product['name'], $search_string) !== false)) {
                    $products = $products->filter(function ($item) use ($product) {
                        return $item->product_id !== $product->product_id;
                    })->values();
                    continue;
                }

                # bind options to product
                $options = array();
                $product_options = $product->options()->get();
                foreach ($product_options as $product_option) {
                    $newOption = array();
                    # product option name
                    $productOptionDescription = $product_option->optionDescriptions()->where('language_id', $language_id)->first();
                    if ($productOptionDescription === null) {
                        $productOptionDescription = $product_option->optionDescriptions()->first();

                    }
                    $newOption['option_name'] = $productOptionDescription->name;
                    # mapping other generic values
                    $newOption['product_option_id'] = $product_option->product_option_id;
                    $newOption['required'] = $product_option->required;
                    $newOption['type'] = $product_option->option->type;

                    # product option values
                    $newValues = array();
                    $productOptionValues = $product_option->optionValues()->get();
                    foreach ($productOptionValues as $productOptionValue) {
                        $newValue = array();
                        # product option value name
                        $productOptionValueDescription = $productOptionValue->descriptions()->where('language_id', $language_id)->first();
                        if ($productOptionValueDescription === null) {
                            $productOptionValueDescription = $productOptionValue->descriptions()->first();
                        }
                        $newValue['name'] = $productOptionValueDescription->name;
                        # mapping product option generic value
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
        # generate category for solod out products
        $noStockProducts = Product::where("quantity", "<=", 0)->get();
        $noStockData["category_id"] = 9999999;
        $noStockData["name"] = $language_id == 1 ? "Sold Out" : "售罄";
        $noStockData["products"] = $noStockProducts;
        foreach ($noStockProducts as $product) {
            $productDescription = $product->descriptions()->where('language_id', $language_id)->first();
            if ($productDescription === null) {
                $productDescription = $product->descriptions()->first();
            }
            $product['name'] = $productDescription->name;
            $product["options"] = array();
        }
        array_push($responseData, $noStockData);

        return $responseData;
    }

    /**
     * function - fetch single product by $language_id and $product_id
     *
     * @param Integer $language_id
     * @param Integer $product_id
     * @return Object<Product> $responseData
     */
    public function getSingleProduct($language_id, $product_id)
    {
        $responseData = array();
//1. fetch product
        $product = Product::find($product_id);
        $responseData['product'] = $product;
//2. add details
        //2.1 descriptions
        $responseData['descriptions'] = $product->descriptions()->get();
//2.2 category

        $category = Category::find(ProductToCategory::where("product_id", $product_id)->first()->category_id);
        $categoryDescription = $category->descriptions()->where("language_id", $language_id)->first();
        if ($categoryDescription === null) {
            $categoryDescription = $category->descriptions()->first();
        }
        $category["name"] = $categoryDescription->name;
        $responseData['category'] = $category;
//2.3 options
        $responseData['options'] = $product->options()->get();
        foreach ($responseData['options'] as $value) {
            $valueDescription = $value->optionDescriptions()->where("language_id", $language_id)->first();
            if ($valueDescription === null) {
                $valueDescription = $value->optionDescriptions()->first();
            }
            //2.3.1 option name

            $value["option_name"] = $valueDescription->name;
            //2.3.2 option values
            $productOptionValues = $value->optionValues()->get();
            foreach ($productOptionValues as $productOptionValue) {
                $productOptionValueDescription = $value->optionDescriptions()->where("language_id", $language_id)->first();
                if ($productOptionValueDescription === null) {
                    $productOptionValueDescription = $value->optionDescriptions()->first();
                }

                $productOptionValue["option_value_name"] = $productOptionValueDescription->name;

            }
            $value["values"] = $productOptionValues;
        }
        return $responseData;
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

    /**
     * function - switch product status between inactive and active
     *
     * @param Request $request
     * @param Integer $product_id
     * @return Void
     */
    public function updateProductStatus($request, $product_id)
    {
        $product = Product::find($product_id);
        $request->product = json_decode(json_encode($request->product));
        $product->status = $request->product->status;
        $product->save();
    }

    # self helper functions
    public function makeDiscountInfo($product, $user_group_id)
    {
        $dt = new \DateTime("now", new \DateTimeZone('Australia/Sydney'));
        $today = $dt->format("Y-m-d");

        $sql = $product->discounts()
            ->where('customer_group_id', $user_group_id)
            ->where('quantity', '>', '0')
            ->where('date_start', '<=', $today)
            ->where('date_end', '>=', $today);
        $discounts = $sql->get();

        if (count($discounts) > 0) {
            return array(
                "price" => $sql
                    ->orderBy("priority", "desc")
                    ->first()->price,
                "status" => true,
            );
        }

        return array("price" => $product["price"], "status" => false);
    }

}
