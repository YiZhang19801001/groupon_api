<?php

namespace App\Http\Controllers;

use App\Location;
use App\Option;
use App\Order;
use App\OrderOption;
use App\OrderProduct;
use App\OrderStatus;
use App\Product;
use App\ProductDescription;
use App\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * fetch all orders for cPanel use
     *
     * @param Request $request
     * @return void
     */
    public function getAll(Request $request)
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            $order["status_name"] = $order->status()->first()->name;
            $user = User::find($order->customer_id);
            $order["user"] = $user;
            $store = Location::find($order->store_id);
            $order["order_items"] = self::fetchOrderProducts($order->order_id);

            $order["store_name"] = $store->name;
        }

        return response()->json(compact("orders"), 200);
    }
    /**
     * show all orders for current user
     * @param void
     * @return Response
     */
    public function index(Request $request)
    {
        // get logged in user
        $user = $request->user();
        // response order with details container
        $responseOrders = array();
        // Todo:: paginate
        $orders = Order::where('customer_id', $user->user_id)->get();
        // add details to each order
        foreach ($orders as $order) {
            $detailedOrder = self::makeOrder($order);

            array_push($responseOrders, $detailedOrder);
        }

        return response()->json(['orders' => $responseOrders], 200);
    }
    /**
     * helper function to add order products to order
     * @param Order
     * @return Order order with details
     */
    public function makeOrder($order)
    {
        $detailedOrder = array();

        $detailedOrder["invoice_no"] = $order->invoice_no;
        $detailedOrder["order_id"] = $order->order_id;
        $detailedOrder["store_id"] = $order->store_id;
        $store = Location::find($order->store_id);
        $detailedOrder["store_name"] = $store->name;
        $detailedOrder["picked_date"] = $order->fax;
        $detailedOrder["create_date"] = $order->date_added;
        $detailedOrder["payment_method"] = $order->payment_method;
        $detailedOrder["total"] = $order->total;
        $detailedOrder["status_id"] = $order->order_status_id;
        $detailedOrder["status"] = OrderStatus::where('order_status_id', $order->order_status_id)->first()->name;
        $detailedOrder["order_items"] = self::fetchOrderProducts($order->order_id);

        return $detailedOrder;
    }
    /**
     * helper function to fetch order product for certain order
     * @param Integer OrderId
     * @return Array(OrderProduct)
     */
    public function fetchOrderProducts($order_id)
    {
        $orderProducts = OrderProduct::where('order_id', $order_id)->get();

        foreach ($orderProducts as $orderProduct) {
            $options = array();
            $options = OrderOption::where('order_product_id', $orderProduct->order_product_id)->get();
            $orderProduct['name'] = ProductDescription::where('product_id', $orderProduct->product_id)->where('language_id', 2)->first()->name;
            $orderProduct['options'] = $options;
        }

        return $orderProducts;
    }
    /**
     * helper function to fetch order product options
     * @param Integer OrderProductId
     * @return Array(OrderOption)
     */
    public function fetchOrderPorductOption($order_product_id)
    {
        $options = OrderOption::where('order_product_id', $order_product_id)->get();

        return $options;
    }
    /**
     * create new order in DB
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        //1. validation
        //2. create
        $today = new DateTime("now", new DateTimeZone('Australia/Sydney'));
        $date_today = $today->format('y-m-d');

        $input = [
            'invoice_no' => $request->invoice_no, 'store_id' => $request->store_id, 'customer_id' => $request->customer_id, 'fax' => $request->fax, 'payment_method' => $request->payment_method, 'total' => $request->total, 'date_added' => $date_today, 'date_modified' => $date_today, 'order_status_id' => $request->order_status_id,
        ];
        $order = Order::create($input);

        $order_products = $this->createOrderProducts($request, $order->order_id);
        //3. return response
        return response()->json(['order' => $order, 'order_products' => $order_products], 201);
    }

    /**
     * @param Request $request
     * @param Integer $order_id
     * @return Array array of oc_order_product
     */
    public function createOrderProducts($request, $order_id)
    {
        $order_products = array();
        foreach ($request->order_items as $orderItem) {
            $orderItem = json_decode(json_encode($orderItem));
            $order_product = OrderProduct::create([
                'order_id' => $order_id,
                'product_id' => $orderItem->product_id,
                'quantity' => $orderItem->quantity,
                'price' => $orderItem->price,
                'total' => $orderItem->total,
            ]);

            if (isset($orderItem->options)) {
                $orderOptions = $this->createOrderOptions($orderItem->options, $order_id, $order_product->order_product_id);
                $order_product['options'] = $orderOptions;
            }

            array_push($order_products, $order_product);

        }

        return $order_products;
    }

    /**
     * @param Array $options
     * @param Integer $order_id
     * @param Integer $order_product_id
     * @return Array array of new oc_order_option
     */
    public function createOrderOptions($options, $order_id, $order_product_id)
    {
        $orderOptions = array();
        foreach ($options as $option) {
            $option = json_decode(json_encode($option));

            $orderOption = OrderOption::create([
                'order_id' => $order_id,
                'order_product_id' => $order_product_id,
                'product_option_id' => $option->product_option_id, 'product_option_value_id' => $option->product_option_value_id,
            ]);

            array_push($orderOptions, $orderOption);
        }

        return $orderOptions;
    }

    /**
     * covert order_items into shopping cart list for front end use
     *
     * @param Request $request
     * @return Response $ShoppingCartList as json object
     */
    public function convertOrderToShoppingCartList(Request $request)
    {
        $language_id = $request->input("language_id");
        $orderItems = $request->items;

        // response result container
        $shoppingCartList = array();

        // maping value
        foreach ($orderItems as $orderItem) {
            $orderItem = json_decode(json_encode($orderItem));
            $newOrderItem = array();
            // fetch product by product_id
            $product_id = $orderItem->product_id;
            $product = Product::find($product_id);
            // fetch product name
            $productDescription = $product->descriptions()->where('language_id', $language_id)->first();
            if ($productDescription === null) {
                $productDescription = $product->descriptions()->first();
            }

            $product['name'] = $productDescription->name;

            // fetch product options
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

            // fetch order item choices
            $choices = array();
            foreach ($orderItem->options as $orderOption) {
                $orderOption = json_decode(json_encode($orderOption));

                // get value details
                $orderItemOptionValueName = "";
                $orderItemOptionValuePrice = "";
                foreach ($options as $option) {
                    foreach ($option["values"] as $optionValue) {
                        if ($optionValue["product_option_value_id"] == $orderOption->product_option_value_id) {
                            $orderItemOptionValueName = $optionValue["name"];
                            $orderItemOptionValuePrice = $optionValue["price"];
                        }
                    }

                }

                // chech duplicate product option exist in $choice or not
                $flag = false;
                $index = 0;
                for ($i = 0; $i < count($choices); $i++) {
                    $choice = $choices[$i];
                    if ($choice["productOption"] == $orderOption->product_option_id) {
                        $flag = true;
                        $index = $i;
                    }

                }

                // if no duplicate record in $choices

                if (!$flag) {

                    $choice = array();
                    $choice["productOption"] = $orderOption->product_option_id;
                    $choice["productOptionValue"] = [
                        "name" => $orderItemOptionValueName,
                        "price" => $orderItemOptionValuePrice,
                        "product_option_value_id" => $orderOption->product_option_value_id,
                    ];

                    array_push($choices, $choice);
                } else {

                    // if duplicate record find in $choices
                    array_push($choices[$index]["productOptionValue"], [
                        "name" => $orderItemOptionValueName,
                        "price" => $orderItemOptionValuePrice,
                        "product_option_value_id" => $orderOption->product_option_value_id,
                    ]);
                }

            }

            $product["choices"] = $choices;

            $newOrderItem["item"] = $product;
            $newOrderItem["quantity"] = $orderItem->quantity;

            array_push($shoppingCartList, $newOrderItem);
        }

        $this->deleteOrder($request->order_id);

        return response()->json(compact("shoppingCartList"), 200);
    }

    public function remove($order_id)
    {
        self::deleteOrder($order_id);
        return response()->json(["message" => "order deleted"], 204);

    }

    /**
     * delete order
     * @param Integer $oc_order_id
     * @return Void
     */
    public function deleteOrder($order_id)
    {
        Order::destroy($order_id);
        OrderProduct::where('order_id', $order_id)->delete();
        OrderOption::where('order_id', $order_id)->delete();

    }

}
