<?php

namespace App\Http\Controllers;

use App\Order;
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
        //3. return response
        return response()->json(compact('order'), 201);
    }
}
