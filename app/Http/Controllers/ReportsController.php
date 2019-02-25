<?php

namespace App\Http\Controllers;

use App\Http\Controllers\helpers\ReportsHelper;
use App\Order;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * constructor funtion
     * @return Void create an instance of helper class - ReportsControllerHelper
     */
    public function __construct()
    {
        $this->helper = new ReportsHelper();
    }

    public function summary(Request $request)
    {
        $today = new DateTime("now", new DateTimeZone('Australia/Sydney'));
        $date_today = $today->format('Y-m-d');

        $language_id = isset($request->language_id) ? $request->language_id : 2;
        $date_start = isset($request->startDate) ? $request->startDate : $today;
        $date_end = isset($request->endDate) ? $request->endDate : $today;

        $orders = Order::where("date_added", ">=", $date_start)->where("date_added", "<=", $date_end)->get();

        $summary = $this->helper->makeSummary($orders, $language_id);

        return response()->json(compact("summary"), 200);
    }

}
