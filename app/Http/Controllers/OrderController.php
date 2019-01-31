<?php

namespace App\Http\Controllers;

use App\Order;
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

        $order_products = array();
        foreach ($request->order_items as $orderItem) {
            $orderItem = json_decode(json_encode($orderItem));
            $order_product = OrderProduct::create([
                'order_id' => $order->order_id,
                'product_id' => $orderItem->product_id,
                'quantity' => $orderItem->quantity,
                'price' => $orderItem->price,
                'total' => $orderItem->total,
            ]);

            array_push($order_products, $order_product);
        }
        //3. return response
        return response()->json(['order' => $order, 'order_products' => $order_products], 201);
    }
}
