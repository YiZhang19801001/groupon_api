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

    /**
     * function called by url : get("reports")
     *
     * @param Request $request
     * @return Response
     */
    public function summary(Request $request)
    {
        // prepare params
        $today = new DateTime("now", new DateTimeZone('Australia/Sydney'));
        $date_today = $today->format('Y-m-d');

        $language_id = isset($request->language_id) ? $request->language_id : 2;
        $date_start = isset($request->startDate) ? $request->startDate : $today;
        $date_end = isset($request->endDate) ? $request->endDate : $today;

        // fetch data from DB
        $orders = Order::where("date_added", ">=", $date_start)->where("date_added", "<=", $date_end)->get();

        // create response body
        $summary = $this->helper->makeSummary($orders, $language_id);

        // return response for request
        return response()->json(compact("summary"), 200);
    }

    /**
     * function called by url: get("report")
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        // prepare params
        $today = new DateTime("now", new DateTimeZone('Australia/Sydney'));
        $date_today = $today->format('Y-m-d');

        $language_id = isset($request->language_id) ? $request->language_id : 2;
        $date_start = isset($request->startDate) ? $request->startDate : $today;
        $date_end = isset($request->endDate) ? $request->endDate : $today;

        // fetch data from DB
        $orders = Order::where("date_added", ">=", $date_start)->where("date_added", "<=", $date_end)->get();

        // create response body
        $report = array();

        switch ($request->report_category) {
            case 'category':
                $report = $this->helper->categoryReport($orders, $language_id);
                break;
            case 'product':
                $report = $this->helper->productReport($orders, $language_id);
                break;
            case 'payment':
                $report = $this->helper->makeSalesByPayment($orders);
                break;
            case 'customer':
                $report = $this->helper->makeSalesByCustomer($orders);
                break;
            case 'date':
                $report = $this->helper->makeSalesByDate($orders);
                break;
            case 'store':
                $report = $this->helper->makeSalesByStore($orders);
                break;
            default:
                break;
        }

        return response()->json($report, 200);
    }

}
