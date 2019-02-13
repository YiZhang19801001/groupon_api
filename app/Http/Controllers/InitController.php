<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InitController extends Controller
{
    public function index(Request $request)
    {
        $custom_setting = array();

        $custom_setting = \Config::get('custom');

        return response()->json(compact("custom_setting"), 200);
    }
}
