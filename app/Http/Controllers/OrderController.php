<?php

namespace App\Http\Controllers;

use App\Location;
use App\Order;
use App\OrderOption;
use App\OrderProduct;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class OrderController extends Controller
{
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
        $detailedOrder["store_id"] = $order->store_id;
        $store = Location::find($order->store_id);
        $detailedOrder["store_name"] = $store->name;
        $detailedOrder["picked_date"] = $order->fax;
        $detailedOrder["create_date"] = $order->date_added;
        $detailedOrder["payment_method"] = $order->payment_method;
        $detailedOrder["total"] = $order->total;

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
