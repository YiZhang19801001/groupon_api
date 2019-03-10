<?php

namespace App\Http\Controllers\helpers;

use App\Location;
use App\Order;
use App\OrderOption;
use App\OrderProduct;
use App\OrderStatus;
use App\Product;
use App\ProductDescription;
use App\ProductOption;
use App\ProductOptionValue;
use App\User;

class OrderHelper
{
    /**
     * function - make orders group by store
     */
    public function makeOrdersByStore($search_string)
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            if ($search_string !== "") {
                if (
                    !(strpos($order['lastname'], $search_string) !== false)
                    && !(strpos($order['telephone'], $search_string) !== false)
                    && !(strpos($order['invoice_no'], $search_string) !== false)
                ) {
                    $orders = $orders->filter(function ($item) use ($order) {
                        return $item->order_id !== $order->order_id;
                    })->values();
                }
            }
        }
        foreach ($orders as $order) {
            $order["status_name"] = $order->status()->first()->name;
            $user = User::find($order->customer_id);
            $order["user"] = $user;
            $store = Location::find($order->store_id);
            $order["order_items"] = self::fetchOrderProducts($order->order_id);

            $order["store_name"] = $store->name;
        }

        $result = array();

        $orders = $orders->groupBy("store_id");
        foreach ($orders as $orderGroup) {
            $newRow = array();
            $newRow["store_id"] = $orderGroup[0]->store_id;
            $newRow["store_name"] = $orderGroup[0]->store_name;
            $newRow["order_products"] = self::makeStoreOrderProducts($orderGroup);

            array_push($result, $newRow);
        }

        return $result;
    }

    /**
     * helper function to fetch order product for certain order
     * @param Integer OrderId
     * @return Array(OrderProduct)
     */
    public function fetchOrderProducts($order_id)
    {
        $language_id = 2;
        $orderProducts = OrderProduct::where('order_id', $order_id)->get();
        if (count($orderProducts) < 1) {
            return $orderProducts;
        }
        foreach ($orderProducts as $orderProduct) {
            $options = array();
            $options = OrderOption::where('order_product_id', $orderProduct->order_product_id)->get();

            foreach ($options as $orderOption) {
                $product_option = ProductOption::find($orderOption["product_option_id"]);
                $product_option_value = ProductOptionValue::find($orderOption["product_option_value_id"]);

                $product_option_description = $product_option->optionDescriptions()->where('language_id', $language_id)->first();
                if ($product_option_description === null) {
                    $product_option_description = $product_option->optionDescriptions()->first();
                }
                if ($product_option_value) {
                    $product_option_value_description = $product_option_value->descriptions()->where('language_id', $language_id)->first();
                    if ($product_option_value_description === null) {
                        $product_option_value_description = $product_option_value->descriptions()->first();
                    }
                }
                $orderOption["option_name"] = $product_option_description->name;
                $orderOption["option_value_name"] = isset($product_option_value_description) ? $product_option_value_description->name : "";
                $orderOption["price"] = isset($product_option_value) ? number_format($product_option_value->price, 2) : 0;
            }
            $product_description = ProductDescription::where('product_id', $orderProduct->product_id)->where('language_id', $language_id)->first();
            if ($product_description === null) {
                $product_description = ProductDescription::where('product_id', $orderProduct->product_id)->first();
            }
            $orderProduct['name'] = $product_description->name;
            $orderProduct['options'] = $options;
        }

        return $orderProducts;
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
        $detailedOrder["comments"] = $order->comment;

        return $detailedOrder;
    }

    # self helper class
    public function makeStoreOrderProducts($orderGroup)
    {
        $order_products = array();
        foreach ($orderGroup as $order) {
            $order = json_decode(json_encode($order));

            foreach ($order->order_items as $order_item) {
                $order_item = json_decode(json_encode($order_item));
                $product_id = $order_item->product_id;
                if (array_key_exists($product_id, $order_products)) {
                    array_push($order_products[$product_id], ["product_name" => $order_item->name, "username" => $order->user->username, "date" => $order->fax, "quantity" => $order_item->quantity]);
                } else {
                    $order_products[$product_id] = array(["product_name" => $order_item->name, "username" => $order->user->username, "date" => $order->fax, "quantity" => $order_item->quantity]);
                };
            }
        }

        return collect($order_products)->values();
    }

    /**
     * helper function to fetch all orders with neccessary details from DB
     *
     * @param Request
     * @return void
     */
    public function makeOrders($search_string)
    {
        $orders = Order::paginate(3);
        foreach ($orders as $order) {
            if ($search_string !== "") {
                if (
                    !(strpos($order['lastname'], $search_string) !== false)
                    && !(strpos($order['telephone'], $search_string) !== false)
                    && !(strpos($order['invoice_no'], $search_string) !== false)
                ) {
                    $orders = $orders->filter(function ($item) use ($order) {
                        return $item->order_id !== $order->order_id;
                    })->values();
                }
            }
        }
        foreach ($orders as $order) {
            $order["status_name"] = $order->status()->first()->name;
            $user = User::find($order->customer_id);
            $order["user"] = $user;
            $store = Location::find($order->store_id);
            $order["order_items"] = self::fetchOrderProducts($order->order_id);

            $order["store_name"] = $store->name;
        }
        return $orders;
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

            // decrease product quantity
            $product = Product::find($orderItem->product_id);
            $product->decrement("quantity", $orderItem->quantity);
            if (!isset($product) || $product->quantity < 0) {
                return response()->json(["errors" => ["code" => 1, "message" => "quantity is over stock"]], 400);
            }

            if (isset($orderItem->options)) {
                $orderOptions = self::createOrderOptions($orderItem->options, $order_id, $order_product->order_product_id);
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
                'product_option_id' => $option->product_option_id,
                'product_option_value_id' => $option->product_option_value_id,
            ]);

            array_push($orderOptions, $orderOption);
        }

        return $orderOptions;
    }

}
