<?php

namespace App\Http\Controllers\helpers;

class OrderHelper
{
    /**
     * function - make orders group by store
     */
    public function makeOrdersByStore()
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
        return $orders;
    }
}
