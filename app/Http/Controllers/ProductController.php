<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\helpers\ProductHelper;
use App\Option;
use App\Product;
use App\ProductDescription;
use App\ProductOption;
use App\ProductOptionValue;
use App\ProductToCategory;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = new ProductHelper();
    }
    /**
     * funciton - fetch all products 1. grouped by category 2. with full details (choices,options)
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        # read input from request
        $language_id = isset($request->language_id) ? $request->language_id : 2;
        $status = isset($request->product_status) ? $request->product_status : 0;
        $search_string = isset($request->search_string) ? $request->search_string : "";
        # read user_group_id from token
        $user_group_id = 0;
        $token = $request->bearerToken();
        $user = User::where("api_token", $token)->first();
        if ($user) {
            $user_group_id = $user->user_group_id;
        }

        # call function & create response Object
        $responseData = $this->helper->getProductsList($language_id, $status, $search_string, $user_group_id);

        # return response

        return response()->json($responseData, 200);
    }

    /**
     * function - create new product
     * @param Request
     * @return Response new product json just created
     */
    public function create(Request $request)
    {
        // Todo:: validate $request
        $errors = array();

        $status = 1;
        $product = json_decode(json_encode($request->product));

        if (count($errors) > 0) {
            return response()->json(compact('errors'), 422);
        }

        $category = json_decode(json_encode($request->category));
        $category_id = $category->category_id;
        //2. create oc_product
        $newProduct = Product::create([
            'price' => $product->price,
            'quantity' => $product->quantity,
            "sort_order" => $product->sort_order,
            "stock_status_id" => $product->stock_status_id,
        ]);

        $product_id = $newProduct->product_id;

        if ($request->get("file")) {
            $image = $request->get("file");
            $name = "$product_id.jpeg";
            \Image::make($request->get('file'))->save(public_path('images/products/') . $name);
            $newProduct->image = "/images/products/$name";
        }

        $newProduct->save();

        //3. create oc_product_description [multiple descriptions should be created, as user may entry all names for different languages]

        $descriptionCn = ProductDescription::create(['product_id' => $product_id, 'language_id' => 2, 'name' => $product->chinese_name]);
        $descriptionEn = ProductDescription::create(['product_id' => $product_id, 'language_id' => 1, 'name' => $product->english_name]);

        //4. create options for product

        if (isset($request->options)) {
            foreach ($request->options as $option) {
                $option = json_decode(json_encode($option));

                //4.1 create oc_product_option
                $productOption = ProductOption::create([
                    'product_id' => $product_id,
                    'option_id' => $option->option_id,
                    'value' => isset($option->value) ? $option->value : '', 'required' => isset($option->required) ? $option->required : 1,
                ]);
                // create option_values
                foreach ($option->values as $value) {
                    $value = json_decode(json_encode($value));
                    //4.6 create oc_product_option_value
                    $productOptionValue = ProductOptionValue::create([
                        'product_option_id' => $productOption->product_option_id,
                        'product_id' => $product_id, 'option_id' => $option->option_id,
                        'option_value_id' => $value->option_value_id, 'quantity' => isset($value->quantity) ? $value->quantity : 999, 'price' => isset($value->price) ? $value->price : 0,
                    ]);
                }
            }

        }

        ProductToCategory::create(['product_id' => $product_id, "category_id" => $category_id]);

        # groupon product add discounts
        if ($request->isGroupon) {
            $product = json_decode(json_encode($request->product));
            ProductDiscount::create([
                'product_id' => $product->product_id,
                'quantity' => $product->discountQuantity,
                'price' => $product->discountPrice,
                'date_start' => $product->date_start,
                'date_end' => $product->date_end,
            ]);
        }

        # prepare response object
        $search_string = isset($request->search_string) ? $request->search_string : "";
        $status = isset($request->status) ? $request->status : 0;
        $language_id = isset($request->language_id) ? $request->language_id : 2;

        $products = self::getProductsList($language_id, $status, $search_string);
        return response()->json(compact("products"), 201);
    }

    /**
     * update product
     * @param Request $request body
     * @param Integer $product_id
     */
    public function update(Request $request, $product_id)
    {
        //1. validation

        $errors = array();
        // $errors = $this->validateRequest($request);
        $request->product = json_decode(json_encode($request->product));
        $search_string = isset($request->search_string) ? $request->search_string : "";

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
        $product->quantity = $request->product->quantity;

        //How To:: upload image React && Laravel
        if ($request->get("file")) {
            $image = $request->get("file");
            $name = "$product_id.jpeg";
            \Image::make($request->get('file'))->save(public_path('images/products/') . $name);
            $product->image = "/images/products/$name";
        }

        $product->save();

        //3. update oc_product_description [multiple descriptions should be created, as user may update all names for different languages]
        $cn_des = ProductDescription::where("product_id", $product_id)->where("language_id", 2)->first();
        if ($cn_des === null) {} else {
            $cn_des->name = $request->product->chinese_name;
            $cn_des->save();
        }
        $en_des = ProductDescription::where("product_id", $product_id)->where("language_id", 1)->first();
        if ($en_des === null) {
            $en_des->name = $request->product->english_name;
            $en_des->save();
        }

        //4. update options for product
        $options = array();
        $new_product_option_ids = array();
        foreach ($request->options as $option) {
            $option = json_decode(json_encode($option));
            $option_array = array();
            // 4.1 check if update option or add option
            if (isset($option->product_option_id)) // update
            {
                array_push($new_product_option_ids, $option->product_option_id);
                $product_option = ProductOption::find($option->product_option_id);
                $product_option->optionValues()->delete();
                foreach ($option->values as $optionValue) {
                    $optionValue = json_decode(json_encode($optionValue));
                    ProductOptionValue::create([
                        'product_option_id' => $option->product_option_id,
                        'product_id' => $product_id,
                        'option_id' => $option->option_id,
                        'option_value_id' => $optionValue->option_value_id,
                        'quantity' => 999,
                        'price' => 0.00,
                    ]);
                }
            } else // add
            {
                $product_option = ProductOption::create([
                    'product_id' => $product_id,
                    'option_id' => $option->option_id,
                    'value' => "",
                    'required' => 1,
                ]);
                array_push($new_product_option_ids, $product_option->product_option_id);
                foreach ($option->values as $optionValue) {
                    $optionValue = json_decode(json_encode($optionValue));
                    ProductOptionValue::create([
                        'product_option_id' => $product_option->product_option_id,
                        'product_id' => $product_id,
                        'option_id' => $option->option_id,
                        'option_value_id' => $optionValue->option_value_id,
                        'quantity' => 999,
                        'price' => 0.00,
                    ]);
                }
            }
        }

        // How To:: use whereIn and whereNotIn
        // 5. delete options - remove product option which product_option_id not contains in $new_product_opiton_ids
        ProductOption::where("product_id", $product_id)->whereNotIn("product_option_id", $new_product_option_ids)->delete();

        $status = isset($request->status) ? $request->status : 0;
        $language_id = isset($request->language_id) ? $request->language_id : 2;
        $response_array = self::getProductsList($language_id, $status, $search_string);

        return response()->json($response_array, 200);

    }

    /**
     * show single product according to product_id
     * @param Integer Product_id
     * @return Response product with details
     */
    public function show(Request $request, $product_id)
    {
        $language_id = isset($request->language_id) ? $request->language_id : 2;

        $responseData = $this->helper->getSingleProduct($language_id, $product_id);
        //3. return response
        return response()->json($responseData, 200);
    }

    /**
     * function - partrial update product values
     *
     * @param Request $request
     * @param Integer $product_id
     * @return Response<Array<Product>> $response_array
     */
    public function patch(Request $request, $product_id)
    {
        # read input
        $language_id = isset($request->language_id) ? $request->language_id : 2;
        $search_string = isset($request->search_string) ? $request->search_string : "";
        $property = isset($request->property) ? $request->property : "status";
        $status = $request->product->status === 1 ? 0 : 1;

        # call function
        switch ($property) {
            case 'status':
                $this->helper->updateProductStatus($product_id, $request);
                break;
            default:
                # code...
                break;
        }

        # make return response object
        $response_array = self::getProductsList($language_id, $status, $search_string);

        return response()->json($response_array, 200);
    }

}
