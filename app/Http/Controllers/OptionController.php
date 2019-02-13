<?php

namespace App\Http\Controllers;

use App\Option;
use App\OptionDescription;
use App\OptionValue;
use App\OptionValueDescription;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Request $request)
    {
        $language_id = $request->input('language_id') ? $request->input('language_id') : 2;
        $options = self::getOptionList($language_id);
        return response()->json(compact("options"), 200);
    }

    public function create(Request $request)
    {
        $language_id = $request->input('language_id') ? $request->input('language_id') : 2;

        // 1. create new Option
        $newOption = Option::create(['type' => $request->type, 'sort_order' => 1]);
        // 2. create new option description
        self::createOptionDescription($newOption->option_id, $request->option_description);
        // 3. create new option values
        if (isset($request->option_values) && is_array($request->option_values)) {
            self::createOptionValues($request->option_values, $newOption->option_id);
        }

        // 4. create response object
        $options = self::getOptionList($language_id);
        return response()->json(compact("options"), 201);
    }

    public function getOptionList($language_id)
    {
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
        return $options;
    }

    public function createOptionDescription($option_id, $description)
    {
        $description = json_decode(json_encode($description));
        OptionDescription::create(['option_id' => $option_id, 'language_id' => 1, 'name' => $description->english_name]);
        OptionDescription::create(['option_id' => $option_id, 'language_id' => 2, 'name' => $description->chinese_name]);

    }

    public function createOptionValues($option_values, $option_id)
    {
        foreach ($option_values as $value) {
            $value = json_decode(json_encode($value));
            $optionValue = OptionValue::create(["option_id" => $option_id]);
            self::createOptionValueDescriptions($value, $optionValue->option_value_id, $option_id);
        }
    }

    public function createOptionValueDescriptions($value, $option_value_id, $option_id)
    {
        $description = json_decode(json_encode($value));
        // 1. create decription for language_id = 1
        OptionValueDescription::create(['option_value_id' => $option_value_id, 'language_id' => 1, 'option_id' => $option_id, 'name' => $description->english_name]);
        // 2. create decription for language_id = 2
        OptionValueDescription::create(['option_value_id' => $option_value_id, 'language_id' => 2, 'option_id' => $option_id, 'name' => $description->chinese_name]);

    }
}
