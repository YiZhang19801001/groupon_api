<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Request $request)
    {
        $language_id = $request->input('language_id') ? $request->input('language_id') : 2;

        $options = Option::all();

        foreach ($options as $option) {
            $option_description = $option->descriptions()->where('language_id', $language_id)->first();
            if ($option_description === null) {
                $option_description = $option->descriptions()->first();
            }
            $option["name"] = $option_description->name;
            $option_values = $option->optionValues()->get();
            foreach ($option_values as $option_value) {
                $option_value_description = $option_value->description()->where('language_id', $language_id)->first();
                if ($option_value_description === null) {
                    $option_value_description = $option_value->description()->first();
                }

                $option_value["name"] = $option_value_description->name;
            }
            $option["values"] = $option_values;

        }

        return response()->json(compact("options"), 200);
    }
}
