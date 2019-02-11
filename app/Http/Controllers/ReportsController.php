<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function summary(Request $request)
    {
        $date_start = $request->input("date_start");
        $date_end = $request->input("date_end");

        $summary = array();

        $orders = Order::all();

        // 1. caculate sales
        $sum = 0;
        foreach ($orders as $order) {
            $order = json_decode(json_encode($order));
            $sum += $order->total;
        }

        // 2. sales by store
        $sum_by_store = array();
        $orders_by_store = $orders->groupby("store_id");
        foreach ($orders_by_store as $orderArray) {
            $total = 0;
            foreach ($orderArray as $order) {
                $total += $order->total;
            }
            array_push($sum_by_store, ["store_id" => $orderArray[0]->store_id, "total" => $total]);
        }

        // 3. sales by date
        $sum_by_date = array();
        $orders_by_date = $orders->groupby("fax");
        foreach ($orders_by_date as $orderArray) {
            $total = 0;
            foreach ($orderArray as $order) {
                $total += $order->total;
            }
            array_push($sum_by_date, ["date" => $orderArray[0]->fax, "total" => $total]);
        }

        // 4. sales by payment method
        $sum_by_payment = array();
        $orders_by_payment = $orders->groupby("payment_method");
        foreach ($orders_by_payment as $key => $orderArray) {
            $result = array();
            $orders_by_date_added = $orderArray->groupby("date_added");
            foreach ($orders_by_date_added as $orderArray2) {
                $total = 0;
                foreach ($orderArray2 as $order) {
                    $total += $order->total;
                }
                array_push($result, ["date" => $orderArray2[0]->date_added, "total" => $total]);
            }
            array_push($sum_by_payment, ["payment_method" => $key, "data" => $result]);
        }
        return response()->json($sum_by_payment);

        // 5. sales by products
        $sum_by_product = self::makeSalesByProduct($orders);

        // 6. sales by customer
        $sum_by_customer = array();
        $orders_by_customer = $orders->groupby("customer_id");
        foreach ($orders_by_customer as $orderArray) {
            $total = 0;
            foreach ($orderArray as $order) {
                $total += $order->total;
            }
            array_push($sum_by_customer, ["customer_id" => $orderArray[0]->customer_id, "total" => $total]);
        }

        $summary["sales"] = $sum;
        $summary["sales_by_store"] = $sum_by_store;
        $summary["sales_by_date"] = $sum_by_date;
        $summary["sales_by_payment"] = $sum_by_payment;
        $summary["sales_by_product"] = $sum_by_product;
        $summary["sales_by_customer"] = $sum_by_customer;

        return response()->json(compact("summary"), 200);
    }

    public function makeSalesByProduct($orders)
    {
        $array = array();
        $order_ids = $orders->pluck('order_id');

        $order_products = OrderProduct::whereIn('order_id', $order_ids)->get()->groupby("product_id");

        foreach ($order_products as $orderArray) {
            $total = 0;
            foreach ($orderArray as $order) {
                $total += $order->total;
            }
            array_push($array, ["product" => $orderArray[0]->product_id, "total" => $total]);

        }

        return $array;
    }
}
