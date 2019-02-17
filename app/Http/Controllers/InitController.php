<?php

namespace App\Http\Controllers;

use App\LayoutText;
use Illuminate\Http\Request;

class InitController extends Controller
{
    public function index(Request $request)
    {
        $language_id = isset($request->language_id) ? $request->language_id : 2;
        $custom_setting = array();

        $custom_setting = \Config::get('custom');

        $layout_text = LayoutText::all();
        $labels = array();
        foreach ($layout_text as $item) {

            $desc = $item->descriptions()->where("language_id", $language_id)->first();
            if ($desc === null) {
                $desc = $item->descriptions()->first();
            }

            $labels[$item->name] = $desc->text;
        }

        return response()->json(["custom_setting" => $custom_setting, "layout_text" => $labels], 200);
    }
}
