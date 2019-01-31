<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderOption;
use App\OrderProduct;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * create new order in DB
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        //1. validation
        //2. create
        $today = new DateTime("now", new DateTimeZone('Australia/Sydney'));
        $date_today = $today->format('y-m-d');

        $input = [
            'invoice_no' => $request->invoice_no, 'store_id' => $request->store_id, 'customer_id' => $request->customer_id, 'fax' => $request->fax, 'payment_method' => $request->payment_method, 'total' => $request->total, 'date_added' => $date_today, 'date_modified' => $date_today,
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
}
