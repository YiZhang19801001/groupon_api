<?php

namespace App\Http\Controllers;

use App\LayoutText;
use App\LayoutTextDescription;
use Illuminate\Http\Request;

class LayoutTextController extends Controller
{
    public function create(Request $request)
    {
        $layoutText = LayoutText::create(["name" => $request->name]);
        $en = LayoutTextDescription::create([
            "layout_text_id" => $layoutText->layout_text_id,
            "language_id" => 1,
            "text" => $request->english_text,
        ]);
        $cn = LayoutTextDescription::create([
            "layout_text_id" => $layoutText->layout_text_id,
            "language_id" => 2,
            "text" => $request->chinese_text,
        ]);

        return response()->json([
            "name" => $layoutText->name,
            "chinese_text" => $cn,
            "english_text" => $en,
        ], 200);
    }
}
